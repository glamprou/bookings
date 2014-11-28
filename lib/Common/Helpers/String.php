<?php
 
class StringHelper
{
	/**
	 * @static
	 * @param $haystack string
	 * @param $needle string
	 * @return bool
	 */
	public static function StartsWith($haystack, $needle)
	{	
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}

	/**
	 * @static
	 * @param $haystack string
	 * @param $needle string
	 * @return bool
	 */
	public static function EndsWith($haystack, $needle)
	{
		$length = strlen($needle);
	    if ($length == 0) {
	        return true;
	    }

	    $start  = $length * -1;
	    return (substr($haystack, $start) === $needle);
	}

	/**
	 * @static
	 * @param $haystack string
	 * @param $needle string
	 * @return bool
	 */
	public static function Contains($haystack, $needle)
	{
		return strpos($haystack, $needle) !== false;
	}
}
?>