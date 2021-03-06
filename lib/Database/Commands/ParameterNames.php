<?php

class ParameterNames
{
	private function __construct()
	{
	}

	const ACCESSORY_ID = '@accessoryid';
	const ACCESSORY_NAME = '@accessoryname';
	const ACCESSORY_QUANTITY = '@quantity';

	const ACTIVATION_CODE = '@activation_code';

	const ALLOW_CALENDAR_SUBSCRIPTION = '@allow_calendar_subscription';

	const ANNOUNCEMENT_ID = '@announcementid';
	const ANNOUNCEMENT_TEXT = '@text';
	const ANNOUNCEMENT_PRIORITY = '@priority';
	const ANNOUNCEMENT_IMPORTANT = '@important';

	const ATTRIBUTE_ID = '@custom_attribute_id';
	const ATTRIBUTE_CATEGORY = '@attribute_category';
	const ATTRIBUTE_LABEL = '@display_label';
	const ATTRIBUTE_POSSIBLE_VALUES = '@possible_values';
	const ATTRIBUTE_REGEX = '@validation_regex';
	const ATTRIBUTE_REQUIRED = '@is_required';
	const ATTRIBUTE_SORT_ORDER = '@sort_order';
	const ATTRIBUTE_TYPE = '@display_type';
	const ATTRIBUTE_VALUE = '@attribute_value';
	const ATTRIBUTE_ENTITY_ID = '@entity_id';
	const ATTRIBUTE_ENTITY_IDS = '@entity_ids';

	const CURRENT_DATE = '@current_date';
	const CURRENT_SERIES_ID = '@currentSeriesId';

	const DATE_CREATED = '@dateCreated';
	const DATE_MODIFIED = '@dateModified';
	const DESCRIPTION = '@description';

	const END_DATE = '@endDate';
	const END_TIME = '@endTime';
	const EMAIL_ADDRESS = '@email';
	const EVENT_CATEGORY = '@event_category';
	const EVENT_TYPE = '@event_type';

	const FILE_ID = '@file_id';
	const FILE_NAME = '@file_name';
	const FILE_TYPE = '@file_type';
	const FILE_SIZE = '@file_size';
	const FILE_EXTENSION = '@file_extension';
	const FIRST_NAME = '@fname';

	const GROUP_ID = '@groupid';
	const GROUP_NAME = '@groupname';
	const GROUP_ADMIN_ID = '@admin_group_id';

	const HOMEPAGE_ID = '@homepageid';

	const IS_ACTIVE = '@isactive';

	const LAST_LOGIN = '@lastlogin';
	const LAST_NAME = '@lname';
	const LAYOUT_ID = '@layoutid';

	const ORGANIZATION = '@organization';

	const PASSWORD = '@password';
	const PERIOD_AVAILABILITY_TYPE = '@periodType';
	const PERIOD_DAY_OF_WEEK = '@day_of_week';
	const PERIOD_LABEL = '@label';
	const PHONE = '@phone';
	const POSITION = '@position';
	const PUBLIC_ID = '@publicid';

	const QUOTA_DURATION = '@duration';
	const QUOTA_ID = '@quotaid';
	const QUOTA_LIMIT = '@limit';
	const QUOTA_UNIT = '@unit';

	const REMINDER_ID = '@reminder_id';
	const REMINDER_USER_ID = '@user_id';
	const REMINDER_SENDTIME = '@sendtime';
	const REMINDER_MESSAGE = '@message';
	const REMINDER_ADDRESS = '@address';
	const REMINDER_REFNUMBER = '@refnumber';
	const REMINDER_MINUTES_PRIOR = '@minutes_prior';
	const REMINDER_TYPE = '@reminder_type';

	const REFERENCE_NUMBER = '@referenceNumber';

	const REPEAT_OPTIONS = '@repeatOptions';
	const REPEAT_TYPE = '@repeatType';

	const REPORT_NAME = '@report_name';
	const REPORT_DETAILS = '@report_details';
	const REPORT_ID = "@report_id";

	const RESERVATION_INSTANCE_ID = '@reservationid';
	const RESERVATION_USER_LEVEL_ID = '@levelid';

	const RESOURCE_ID = '@resourceid';
	const RESOURCE_ALLOW_MULTIDAY = '@allow_multiday_reservations';
	const RESOURCE_AUTOASSIGN = '@autoassign';
	const RESOURCE_CONTACT = '@contact_info';
	const RESOURCE_COST = '@unit_cost';
	const RESOURCE_DESCRIPTION = '@description';
	const RESOURCE_LOCATION = '@location';
	const RESOURCE_MAX_PARTICIPANTS = '@max_participants';
	const RESOURCE_MAXDURATION = '@max_duration';
	const RESOURCE_MAXNOTICE = '@max_notice_time';
	const RESOURCE_MINDURATION = '@min_duration';
	const RESOURCE_MININCREMENT = '@min_increment';
	const RESOURCE_MINNOTICE = '@min_notice_time';
	const RESOURCE_NAME = '@resource_name';
	const RESOURCE_NOTES = '@resource_notes';
	const RESOURCE_REQUIRES_APPROVAL = '@requires_approval';
	const RESOURCE_LEVEL_ID = '@resourceLevelId';
	const RESOURCE_IMAGE_NAME = '@imageName';
	const RESOURCE_ISACTIVE = '@isActive';
	const RESOURCE_SORT_ORDER = '@sort_order';

	const ROLE_ID = '@roleid';
	const ROLE_LEVEL = '@role_level';

	const SALT = '@salt';
	const SCHEDULE_ID = '@scheduleid';
	const SCHEDULE_NAME = '@scheduleName';
	const SCHEDULE_ISDEFAULT = '@scheduleIsDefault';
	const SCHEDULE_WEEKDAYSTART = '@scheduleWeekdayStart';
	const SCHEDULE_DAYSVISIBLE = '@scheduleDaysVisible';
	const SERIES_ID = '@seriesid';
	const SESSION_TOKEN = '@session_token';
	const START_DATE = '@startDate';
	const START_TIME = '@startTime';
	const STATUS_ID = '@statusid';
	const TIMEZONE_NAME = '@timezone';
	const TYPE_ID = '@typeid';
	const LANGUAGE = '@language';
	const TITLE = '@title';
	const USER_ID = '@userid';
	const USER_ROLE_ID = '@user_roleid';
	const USER_STATUS_ID = '@user_statusid';
	const USER_LEVEL_ID = '@user_level';
	const USER_GROUP_ID = '@user_groupid';
	const USER_SESSION = '@user_session_value';
	const USERNAME = '@username';


	// used?
	const FIRST_NAME_SETTING = '@fname_setting';
	const LAST_NAME_SETTING = '@lname_setting';
	const USERNAME_SETTING = '@username_setting';
	const EMAIL_ADDRESS_SETTING = '@email_setting';
	const PASSWORD_SETTING = '@password_setting';
	const ORGANIZATION_SELECTION_SETTING = '@organization_setting';
	const GROUP_SETTING = '@group_setting';
	const POSITION_SETTING = '@position_setting';
	const ADDRESS_SETTING = '@address_setting';
	const PHONE_SETTING = '@phone_setting';
	const HOMEPAGE_SELECTION_SETTING = '@homepage_setting';
	const TIMEZONE_SELECTION_SETTING = '@timezone_setting';
}

?>