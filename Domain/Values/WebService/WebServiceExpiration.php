<?php

class WebServiceExpiration
{
	const SESSION_LENGTH_IN_MINUTES = 30;

	/**
	 * @param string $expirationTime
	 * @return bool
	 */
	public static function IsExpired($expirationTime)
	{
		return Date::Parse($expirationTime, 'UTC')->LessThan(Date::Now());
	}

	/**
	 * @return string
	 */
	public static function Create()
	{
		return Date::Now()->AddMinutes(self::SESSION_LENGTH_IN_MINUTES)->ToUtc()->ToIso();
	}
}
?>