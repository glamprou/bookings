<?php


class ConfigKeys
{
    const ADMIN_EMAIL = 'admin.email';
    const ALLOW_REGISTRATION = 'allow.self.registration';
	const CSS_EXTENSION_FILE = 'css.extension.file';
    const DEFAULT_PAGE_SIZE = 'default.page.size';
    const DISABLE_PASSWORD_RESET = 'disable.password.reset';
    const ENABLE_EMAIL = 'enable.email';
	const HOME_URL = 'home.url';
	const INACTIVITY_TIMEOUT = 'inactivity.timeout';
    const LANGUAGE = 'default.language';
	const LOGOUT_URL = 'logout.url';
    const NAME_FORMAT = 'name.format';
    const PASSWORD_PATTERN = 'password.pattern';
    const SCRIPT_URL = 'script.url';
    const SERVER_TIMEZONE = 'server.timezone';
    const REGISTRATION_ENABLE_CAPTCHA = 'registration.captcha.enabled';
    const REGISTRATION_REQUIRE_ACTIVATION = 'registration.require.email.activation';
    const REGISTRATION_AUTO_SUBSCRIBE_EMAIL = 'registration.auto.subscribe.email';
    const VERSION = 'version';

    const SCHEDULE_SHOW_INACCESSIBLE_RESOURCES = 'show.inaccessible.resources';
    const SCHEDULE_RESERVATION_LABEL = 'reservation.label';
    const SCHEDULE_HIDE_BLOCKED_PERIODS = 'hide.blocked.periods';

    const DATABASE_TYPE = 'type';
    const DATABASE_USER = 'user';
    const DATABASE_PASSWORD = 'password';
    const DATABASE_HOSTSPEC = 'hostspec';
    const DATABASE_NAME = 'name';

    const PLUGIN_AUTHENTICATION = 'Authentication';
    const PLUGIN_AUTHORIZATION = 'Authorization';
    const PLUGIN_PERMISSION = 'Permission';
    const PLUGIN_POSTREGISTRATION = 'PostRegistration';
    const PLUGIN_PRERESERVATION = 'PreReservation';
    const PLUGIN_POSTRESERVATION = 'PostReservation';

    const RESERVATION_START_TIME_CONSTRAINT = 'start.time.constraint';
    const RESERVATION_UPDATES_REQUIRE_APPROVAL = 'updates.require.approval';
    const RESERVATION_PREVENT_PARTICIPATION = 'prevent.participation';
    const RESERVATION_PREVENT_RECURRENCE = 'prevent.recurrence';
    const RESERVATION_REMINDERS_ENABLED = 'enable.reminders';

    const IMAGE_UPLOAD_DIRECTORY = 'image.upload.directory';
    const IMAGE_UPLOAD_URL = 'image.upload.url';

    const CACHE_TEMPLATES = 'cache.templates';

    const USE_LOCAL_JQUERY = 'use.local.jquery';

    const INSTALLATION_PASSWORD = 'install.password';

    const ICS_SUBSCRIPTION_KEY = 'subscription.key';

    const PRIVACY_HIDE_USER_DETAILS = 'hide.user.details';
    const PRIVACY_HIDE_RESERVATION_DETAILS = 'hide.reservation.details';
    const PRIVACY_VIEW_RESERVATIONS = 'view.reservations';
    const PRIVACY_VIEW_SCHEDULES = 'view.schedules';

    const NOTIFY_CREATE_RESOURCE_ADMINS = 'resource.admin.add';
    const NOTIFY_CREATE_APPLICATION_ADMINS = 'application.admin.add';
    const NOTIFY_CREATE_GROUP_ADMINS = 'group.admin.add';

    const NOTIFY_UPDATE_RESOURCE_ADMINS = 'resource.admin.update';
    const NOTIFY_UPDATE_APPLICATION_ADMINS = 'application.admin.update';
    const NOTIFY_UPDATE_GROUP_ADMINS = 'group.admin.update';

    const NOTIFY_DELETE_RESOURCE_ADMINS = 'resource.admin.delete';
    const NOTIFY_DELETE_APPLICATION_ADMINS = 'application.admin.delete';
    const NOTIFY_DELETE_GROUP_ADMINS = 'group.admin.delete';

	const UPLOAD_ENABLE_RESERVATION_ATTACHMENTS = 'enable.reservation.attachments';
	const UPLOAD_RESERVATION_ATTACHMENTS = 'reservation.attachment.path';
	const UPLOAD_RESERVATION_EXTENSIONS = 'reservation.attachment.extensions';

	const PAGES_ENABLE_CONFIGURATION = 'enable.configuration';

	const API_ENABLED = 'enabled';
	const RECAPTCHA_ENABLED = 'enabled';
	const RECAPTCHA_PUBLIC_KEY = 'public.key';
	const RECAPTCHA_PRIVATE_KEY = 'private.key';
}

class ConfigSection
{
    const API = 'api';
    const DATABASE = 'database';
    const ICS = 'ics';
	const PAGES = 'pages';
    const PLUGINS = 'plugins';
    const PRIVACY = 'privacy';
    const RESERVATION = 'reservation';
    const RESERVATION_NOTIFY = 'reservation.notify';
    const SCHEDULE = 'schedule';
	const UPLOADS = 'uploads';
	const RECAPTCHA = 'recaptcha';
}

?>