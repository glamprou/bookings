<?php

require_once(ROOT_DIR . 'lib/Server/UserSession.php');

class Server
{
    public function __construct()
    {
    }

    public function SetCookie(Cookie $cookie)
    {
        setcookie($cookie->Name, $cookie->Value, $cookie->Expiration, $cookie->Path);
    }

	public function DeleteCookie(Cookie $cookie)
	{
		setcookie($cookie->Name, null, time() - 3600, $cookie->Path);
	}

    public function GetCookie($name)
    {
        if (isset($_COOKIE[$name]))
        {
            return $_COOKIE[$name];
        }
        return null;
    }

	const sessionId = 'phpScheduleIt';

    public function SetSession($name, $value)
    {
        if (!is_null($value))
        {
            @session_start();
        }

        $_SESSION[self::sessionId][$name] = $value;
    }

    public function GetSession($name)
    {
        @session_start();
        if (isset($_SESSION[self::sessionId][$name]))
        {
            return $_SESSION[self::sessionId][$name];
        }
        return null;
    }

	public function EndSession($name)
	{
		$this->SetSession($name, null);
		@session_unset();
		@session_destroy();
	}

	/**
     * @param string $name
     * @return string|null
     */
    public function GetQuerystring($name)
    {
        if (isset($_GET[$name]))
        {
            return htmlspecialchars($_GET[$name]);
        }
        return null;
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function GetForm($name)
    {
		$value = $this->GetRawForm($name);
		if (!empty($value) && !is_array($value))
		{
			return htmlspecialchars($value);
		}

        return $value;
    }

	/**
	 * @param string $name
	 * @return string|null
	 */
	public function GetRawForm($name)
	{
		if (isset($_POST[$name]))
		{
			if (is_array($_POST[$name]))
			{
				return $_POST[$name];
			}

			return $_POST[$name];
		}
		return null;
	}

	/**
	 * @param string $name
	 * @return null|UploadedFile
	 */
	public function GetFile($name)
    {
        if (isset($_FILES[$name]))
        {
            return new UploadedFile($_FILES[$name]);
        }
        return null;
    }

    public function GetUrl()
    {
        $url = $_SERVER['PHP_SELF'];

        if (isset($_SERVER['QUERY_STRING']))
        {
            $url .= '?' . $_SERVER['QUERY_STRING'];
        }

        return $url;
    }

    /**
     * @return UserSession
     */
    public function GetUserSession()
    {
        $userSession = $this->GetSession(SessionKeys::USER_SESSION);

        if (!empty($userSession))
        {
            return $userSession;
        }

        return new NullUserSession();
    }

    /**
     * @param $userSession UserSession
     * @return void
     */
    public function SetUserSession($userSession)
    {
        $this->SetSession(SessionKeys::USER_SESSION, $userSession);
    }

    /**
     * @return string
     */
    public function GetRequestMethod()
    {
        return $this->GetHeader('REQUEST_METHOD');
    }

    /**
     * @return string
     */
    public function GetLanguage()
    {
        $lang = $this->GetHeader('HTTP_ACCEPT_LANGUAGE');
        if (strlen($lang) > 4)
        {
            return substr(str_replace('-','_', $lang), 0, 5);
        }
        return null;
    }

    /**
     * @param string $headerCode
     * @return string
     */
    public function GetHeader($headerCode)
    {
        return $_SERVER[$headerCode];
    }

    /**
     * @return string
     */
    public function GetRemoteAddress()
    {
        return $this->GetHeader('REMOTE_ADDR');
    }
}

?>