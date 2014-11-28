<?php

class WebServiceSessionToken
{
	/**
	 * Only used for testing
	 * @var string
	 */
	public static $_Token;

	/**
	 * @return string
	 */
	public static function Generate()
	{
		if (empty(self::$_Token))
		{
			return uniqid();
		}
		return self::$_Token;
	}
}

?>