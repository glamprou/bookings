<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);

$conf['settings']['server.timezone'] = 'Europe/Athens';
$conf['settings']['allow.self.registration'] = 'true';
$conf['settings']['admin.email'] = 'info@acetennis.gr';
$conf['settings']['default.page.size'] = '50';
$conf['settings']['enable.email'] = 'true';
$conf['settings']['enable.sms'] = 'true';
$conf['settings']['default.language'] = 'gr_el';
$conf['settings']['script.url'] = 'http://www.acetennis.gr/bookings/Web/';
$conf['settings']['password.pattern'] = '/^[^\\s]{6,}$/i';
$conf['settings']['schedule']['show.inaccessible.resources'] = 'true';
$conf['settings']['schedule']['reservation.label'] = '{name}';
$conf['settings']['schedule']['hide.blocked.periods'] = 'true';
$conf['settings']['image.upload.directory'] = 'Web/uploads/images';
$conf['settings']['image.upload.url'] = 'uploads/images';
$conf['settings']['cache.templates'] = 'true';
$conf['settings']['use.local.jquery'] = 'false';
$conf['settings']['registration.captcha.enabled'] = 'false';
$conf['settings']['registration.require.email.activation'] = 'true';
$conf['settings']['registration.auto.subscribe.email'] = 'false';
$conf['settings']['inactivity.timeout'] = '30';
$conf['settings']['name.format'] = '{last} {first}';
$conf['settings']['css.extension.file'] = '';
$conf['settings']['disable.password.reset'] = 'false';
$conf['settings']['home.url'] = '';
$conf['settings']['logout.url'] = '';
$conf['settings']['ics']['require.login'] = 'true';
$conf['settings']['ics']['subscription.key'] = '';
$conf['settings']['ics']['import'] = 'false';
$conf['settings']['ics']['import.key'] = '';
$conf['settings']['privacy']['view.schedules'] = 'true';
$conf['settings']['privacy']['view.reservations'] = 'true';
$conf['settings']['privacy']['hide.user.details'] = 'false';
$conf['settings']['privacy']['hide.reservation.details'] = 'false';
$conf['settings']['reservation']['start.time.constraint'] = 'current';
$conf['settings']['reservation']['updates.require.approval'] = 'false';
$conf['settings']['reservation']['prevent.participation'] = 'false';
$conf['settings']['reservation']['prevent.recurrence'] = 'false';
$conf['settings']['reservation']['enable.reminders'] = 'false';
$conf['settings']['reservation.notify']['resource.admin.add'] = 'false';
$conf['settings']['reservation.notify']['resource.admin.update'] = 'false';
$conf['settings']['reservation.notify']['resource.admin.delete'] = 'false';
$conf['settings']['reservation.notify']['application.admin.add'] = 'false';
$conf['settings']['reservation.notify']['application.admin.update'] = 'false';
$conf['settings']['reservation.notify']['application.admin.delete'] = 'true';
$conf['settings']['reservation.notify']['group.admin.add'] = 'false';
$conf['settings']['reservation.notify']['group.admin.update'] = 'false';
$conf['settings']['reservation.notify']['group.admin.delete'] = 'false';
$conf['settings']['uploads']['enable.reservation.attachments'] = 'false';
$conf['settings']['uploads']['reservation.attachment.path'] = 'uploads/reservation';
$conf['settings']['uploads']['reservation.attachment.extensions'] = 'txt,jpg,gif,png,doc,docx,pdf,xls,xlsx,ppt,pptx,csv';

$conf['settings']['database']['type'] = 'mysql';
$conf['settings']['database']['user'] = 'acetenni_user';
$conf['settings']['database']['password'] = 'vaBk-2Lo?B4Z';
$conf['settings']['database']['hostspec'] = '127.0.0.1';
$conf['settings']['database']['name'] = 'acetenni_phpscheduleit2';

$conf['settings']['phpmailer']['mailer'] = 'mail';
$conf['settings']['phpmailer']['smtp.host'] = '';
$conf['settings']['phpmailer']['smtp.port'] = '25';
$conf['settings']['phpmailer']['smtp.secure'] = '';
$conf['settings']['phpmailer']['smtp.auth'] = 'true';
$conf['settings']['phpmailer']['smtp.username'] = '';
$conf['settings']['phpmailer']['smtp.password'] = '';
$conf['settings']['phpmailer']['sendmail.path'] = '/usr/sbin/sendmail';
$conf['settings']['phpmailer']['smtp.debug'] = 'false';
$conf['settings']['plugins']['Authentication'] = '';
$conf['settings']['plugins']['Authorization'] = '';
$conf['settings']['plugins']['Permission'] = '';
$conf['settings']['plugins']['PostRegistration'] = '';
$conf['settings']['plugins']['PreReservation'] = '';
$conf['settings']['plugins']['PostReservation'] = '';
$conf['settings']['install.password'] = 'qALgETv';
$conf['settings']['pages']['enable.configuration'] = 'true';
$conf['settings']['api']['enabled'] = 'true';
$conf['settings']['recaptcha']['enabled'] = 'false';
$conf['settings']['recaptcha']['public.key'] = '';
$conf['settings']['recaptcha']['private.key'] = '';

if(defined('ROOT_DIR')){
	//require PDO Connection
	require_once(ROOT_DIR.'PDOConnection.php');
	require_once(ROOT_DIR.'SystemPreferencesAndGlobalFunctions.php');
}
?>