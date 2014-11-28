<?php

require_once(ROOT_DIR . 'Controls/Control.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class CaptchaControl extends Control
{
	public function PageLoad()
	{
		if (Configuration::Instance()->GetSectionKey(ConfigSection::RECAPTCHA, ConfigKeys::RECAPTCHA_ENABLED,
													 new BooleanConverter())
		)
		{
			$this->showRecaptcha();
		}
		else
		{
			$this->showSecurimage();
		}
	}

	private function showRecaptcha()
	{
		Log::Debug('CaptchaControl using Recaptcha');
		require_once(ROOT_DIR . 'lib/external/recaptcha/recaptchalib.php');
		$response = recaptcha_get_html(Configuration::Instance()->GetSectionKey(ConfigSection::RECAPTCHA,
																				ConfigKeys::RECAPTCHA_PUBLIC_KEY));
		echo $response;
	}

	private function showSecurimage()
	{
		Log::Debug('CaptchaControl using Securimage');
		$url = CaptchaService::Create()->GetImageUrl();

		$label = Resources::GetInstance()->GetString('SecurityCode');
		$formName = FormKeys::CAPTCHA;

		echo "<img src='$url' alt='captcha' id='captchaImg'/>";
		echo "<br/><label class=\"reg\">$label<br/><input type=\"text\" class=\"input\" name=\"$formName\" size=\"20\" id=\"captchaValue\"/>";
	}
}


?>