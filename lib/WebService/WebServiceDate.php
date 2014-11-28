<?php

class WebServiceDate
{
	/**
	 * @param string $dateString
	 * @param UserSession $session
	 * @return Date
	 */
	public static function GetDate($dateString, UserSession $session)
	{
		if (StringHelper::Contains($dateString, 'T'))
		{
			return Date::ParseExact($dateString);
		}

		return Date::Parse($dateString, $session->Timezone);
	}
}

?>