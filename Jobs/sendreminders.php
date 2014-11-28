<?php

//////////////////
/* Cron Example //
//////////////////

This script must be executed every minute for to enable Reservation Reminders functionality

* * * * * php /home/mydomain/public_html/phpScheduleIt/Jobs/sendreminders.php
* * * * * /path/to/php /home/mydomain/public_html/phpScheduleIt/Jobs/sendreminders.php

*/

define('ROOT_DIR', __DIR__ . '/../');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Domain/Reminder.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReminderEmail.php');
require_once(ROOT_DIR . 'Jobs/JobCop.php');

Log::Debug('Running sendreminders.php');

JobCop::EnsureCommandLine();

try
{
	$repository = new ReminderRepository();
	$now = Date::Now();

	$startNotices = $repository->GetReminderNotices($now, ReservationReminderType::Start);
	Log::Debug('Found %s start reminders', count($startNotices));
	foreach ($startNotices as $notice)
	{
		ServiceLocator::GetEmailService()->Send(new ReminderStartEmail($notice));
	}

	$endNotices = $repository->GetReminderNotices(Date::Now(), ReservationReminderType::End);
	Log::Debug('Found %s end reminders', count($endNotices));
	foreach ($endNotices as $notice)
	{
		ServiceLocator::GetEmailService()->Send(new ReminderEndEmail($notice));
	}
} catch (Exception $ex)
{
	Log::Error('Error running sendreminders.php: %s', $ex);
}

Log::Debug('Finished running sendreminders.php');
?>