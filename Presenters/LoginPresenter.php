<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class LoginPresenter
{
	/**
	 * @var ILoginPage
	 */
	private $_page = null;

	/**
	 * @var IWebAuthentication
	 */
	private $authentication = null;

	/**
	 * Construct page type and authentication method
	 * @param ILoginPage $page passed by reference
	 * @param IWebAuthentication $authentication default to null
	 */
	public function __construct(ILoginPage &$page, $authentication = null)
	{
		$this->_page = & $page;
		$this->SetAuthentication($authentication);
	}

	/**
	 * @param IWebAuthentication $authentication
	 */
	private function SetAuthentication($authentication)
	{
		if (is_null($authentication))
		{
			$this->authentication = new WebAuthentication(PluginManager::Instance()->LoadAuthentication(), ServiceLocator::GetServer());
		}
		else
		{
			$this->authentication = $authentication;
		}
	}

	public function PageLoad()
	{
		$this->SetSelectedLanguage();

		if ($this->authentication->AreCredentialsKnown())
		{
			$this->Login();
		}

		$server = ServiceLocator::GetServer();
		$loginCookie = $server->GetCookie(CookieKeys::PERSIST_LOGIN);

		if ($this->IsCookieLogin($loginCookie))
		{
			if ($this->authentication->CookieLogin($loginCookie, new WebLoginContext(new LoginData(true))))
			{
				$this->_Redirect();
			}
		}

		$allowRegistration = Configuration::Instance()->GetKey(ConfigKeys::ALLOW_REGISTRATION, new BooleanConverter());
		$allowAnonymousSchedule = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY,
																		   ConfigKeys::PRIVACY_VIEW_SCHEDULES,
																		   new BooleanConverter());
		$this->_page->SetShowRegisterLink($allowRegistration);
		$this->_page->SetShowScheduleLink($allowAnonymousSchedule);

		$this->_page->ShowForgotPasswordPrompt(!Configuration::Instance()->GetKey(ConfigKeys::DISABLE_PASSWORD_RESET,
																				  new BooleanConverter()) && $this->authentication->ShowForgotPasswordPrompt());
		$this->_page->ShowPasswordPrompt($this->authentication->ShowPasswordPrompt());
		$this->_page->ShowPersistLoginPrompt($this->authentication->ShowPersistLoginPrompt());
		$this->_page->ShowUsernamePrompt($this->authentication->ShowUsernamePrompt());
	}

	public function Login()
	{
		$id = $this->_page->GetEmailAddress();

		if ($this->authentication->Validate($id, $this->_page->GetPassword()))
		{
			$context = new WebLoginContext(new LoginData($this->_page->GetPersistLogin(), $this->_page->GetSelectedLanguage()));
			$this->authentication->Login($id, $context);
			$this->_Redirect();
		}
		else
		{
			$this->authentication->HandleLoginFailure($this->_page);
			$this->_page->SetShowLoginError();
		}
	}

	public function ChangeLanguage()
	{
		$resources = Resources::GetInstance();

		$languageCode = $this->_page->GetRequestedLanguage();
		if ($resources->SetLanguage($languageCode))
		{
			ServiceLocator::GetServer()->SetCookie(new Cookie(CookieKeys::LANGUAGE, $languageCode));
			$this->_page->SetSelectedLanguage($languageCode);
			$this->_page->Redirect(Pages::LOGIN);
		}
	}

	public function Logout()
	{
		$url = Configuration::Instance()->GetKey(ConfigKeys::LOGOUT_URL);
		if (empty($url))
		{
			$url = htmlspecialchars_decode($this->_page->GetResumeUrl());
			$url = sprintf('%s?%s=%s', Pages::LOGIN, QueryStringKeys::REDIRECT, urlencode($url));
		}
		$this->authentication->Logout(ServiceLocator::GetServer()->GetUserSession());
		$this->_page->Redirect($url);
	}

	private function _Redirect()
	{
		$redirect = $this->_page->GetResumeUrl();

		if (!empty($redirect))
		{
			$this->_page->Redirect($redirect);
		}
		else
		{
			$defaultId = ServiceLocator::GetServer()->GetUserSession()->HomepageId;
			$this->_page->Redirect(Pages::UrlFromId($defaultId));
		}
	}

	private function IsCookieLogin($loginCookie)
	{
		return !empty($loginCookie);
	}

	private function SetSelectedLanguage()
	{
		$requestedLanguage = $this->_page->GetRequestedLanguage();
		if (!empty($requestedLanguage))
		{
			// this is handled by ChangeLanguage()
			return;
		}

		$languageCookie = ServiceLocator::GetServer()->GetCookie(CookieKeys::LANGUAGE);
		$languageHeader = ServiceLocator::GetServer()->GetLanguage();
		$languageCode = Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE);

		$resources = Resources::GetInstance($languageCookie);

		if ($resources->IsLanguageSupported($languageCookie))
		{
			$languageCode = $languageCookie;
		}
		else
		{
			if ($resources->IsLanguageSupported($languageHeader))
			{
				$languageCode = $languageHeader;
			}
		}

		$this->_page->SetSelectedLanguage(strtolower($languageCode));
		$resources->SetLanguage($languageCode);
	}
}

?>
