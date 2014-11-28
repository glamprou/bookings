<?php

class Pages
{
	const DEFAULT_HOMEPAGE_ID = 1;

	const ACTIVATION = 'activate.php';
	const CALENDAR = 'calendar.php';
	const CALENDAR_EXPORT = 'ical.php';
	const CALENDAR_SUBSCRIBE = 'ical-subscribe.php';
	const DASHBOARD = 'dashboard.php';
	const DEFAULT_LOGIN = 'dashboard.php';
	const INVITATION_RESPONSES = 'participation.php';
	const LOGIN = 'index.php';
	const MANAGE_RESERVATIONS = 'manage_reservations.php';
	const MANAGE_GROUPS = 'manage_groups.php';
	const MANAGE_GROUPS_ADMIN = 'manage_admin_groups.php';
	const MANAGE_GROUP_RESERVATIONS = 'manage_group_reservations.php';
	const MY_CALENDAR = 'my-calendar.php';
	const OPENINGS = 'openings.php';
	const NOTIFICATION_PREFERENCES = 'notification-preferences.php';
	const PARTICIPATION = 'participation.php';
	const PASSWORD = 'password.php';
	const PROFILE = 'profile.php';
	const REPORTS_GENERATE = 'generate-report.php';
	const REPORTS_SAVED = 'saved-reports.php';
	const REPORTS_COMMON = 'common-reports.php';
	const RESERVATION = 'reservation.php';
	const RESERVATION_FILE = 'reservation-file.php';
	const REGISTRATION = 'register.php';
	const SCHEDULE = 'schedule.php';

	private static $_pages = array(
		1 => array('url' => Pages::DASHBOARD, 'name' => 'MyDashboard'),
		2 => array('url' => Pages::SCHEDULE, 'name' => 'Schedule'),
		3 => array('url' => Pages::MY_CALENDAR, 'name' => 'MyCalendar'),
		4 => array('url' => Pages::CALENDAR, 'name' => 'ResourceCalendar')
	);

	private function __construct()
	{
	}

	public static function UrlFromId($pageId)
	{
		return self::$_pages[$pageId]['url'];
	}

	public static function GetAvailablePages()
	{
		return self::$_pages;
	}
}

?>