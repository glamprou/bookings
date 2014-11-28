<?php

interface ICaptchaService
{
	/**
	 * @abstract
	 * @return string
	 */
	public function GetImageUrl();

	/**
	 * @abstract
	 * @param string $captchaValue
	 * @return bool
	 */
	public function IsCorrect($captchaValue);
}

class NullCaptchaService implements ICaptchaService
{
	/**
	 * @return string
	 */
	public function GetImageUrl()
	{
		return '';
	}

	/**
	 * @param string $captchaValue
	 * @return bool
	 */
	public function IsCorrect($captchaValue)
	{
		return true;
	}
}

class CaptchaService implements ICaptchaService
{
	private function __construct()
	{

	}

	public function GetImageUrl()
	{
		$url = new Url(Configuration::Instance()->GetScriptUrl() . '/Services/Authentication/show-captcha.php');
		$url->AddQueryString('show', 'true');
		return $url->__toString();
	}

	public function IsCorrect($captchaValue)
	{
		require_once(ROOT_DIR . 'lib/external/securimage/securimage.php');

		$img = new securimage();
		$isValid = $img->check($captchaValue);

		Log::Debug('Checking captcha value. Value entered: %s. IsValid: %s', $captchaValue, (int)$isValid);

		return $isValid;
	}

	/**
	 * @static
	 * @return CaptchaService|NullCaptchaService
	 */
	public static function Create()
	{
		if (Configuration::Instance()->GetKey(ConfigKeys::REGISTRATION_ENABLE_CAPTCHA, new BooleanConverter()))
		{
			if (Configuration::Instance()->GetSectionKey(ConfigSection::RECAPTCHA, ConfigKeys::RECAPTCHA_ENABLED,
												  new BooleanConverter())
			)
			{
				Log::Debug('Using ReCaptchaService');
				return new ReCaptchaService();
			}
			Log::Debug('Using CaptchaService');
			return new CaptchaService();
		}

		return new NullCaptchaService();
	}
}

class ReCaptchaService implements ICaptchaService
{
	/**
	 * @return string
	 */
	public function GetImageUrl()
	{
		return '';
	}

	/**
	 * @param string $captchaValue
	 * @return bool
	 */
	public function IsCorrect($captchaValue)
	{
		$server = ServiceLocator::GetServer();
		Log::Debug('Checking ReCaptcha. Value entered=%s', $server->GetForm('recaptcha_response_field'));

		require_once(ROOT_DIR . 'lib/external/recaptcha/recaptchalib.php');
		$privatekey = Configuration::Instance()->GetSectionKey(ConfigSection::RECAPTCHA, ConfigKeys::RECAPTCHA_PRIVATE_KEY);

		$resp = recaptcha_check_answer($privatekey,
									 $server->GetRemoteAddress(),
									   $server->GetForm('recaptcha_challenge_field'),
									   $server->GetForm('recaptcha_response_field'));

		Log::Debug('ReCaptcha IsValid: %s', $resp->is_valid);

		return $resp->is_valid;
	}
}

?>