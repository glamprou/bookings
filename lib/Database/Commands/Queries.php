<?php
class Queries
{
	private function __construct()
	{
	}

	const ADD_ACCESSORY =
			'INSERT INTO accessories (accessory_name, accessory_quantity)
		VALUES (@accessoryname, @quantity)';

	const ADD_ACCOUNT_ACTIVATION =
			'INSERT INTO account_activation (user_id, activation_code, date_created) VALUES (@userid, @activation_code, @dateCreated)';

	const ADD_ANNOUNCEMENT =
			'INSERT INTO announcements (announcement_text, priority, start_date, end_date, important)
		VALUES (@text, @priority, @startDate, @endDate, @important)';

	const ADD_ATTRIBUTE =
			'INSERT INTO custom_attributes (display_label, display_type, attribute_category, validation_regex, is_required, possible_values, sort_order)
		VALUES (@display_label, @display_type, @attribute_category, @validation_regex, @is_required, @possible_values, @sort_order)';

	const ADD_ATTRIBUTE_VALUE =
			'INSERT INTO custom_attribute_values (custom_attribute_id, attribute_category, attribute_value, entity_id)
			VALUES (@custom_attribute_id, @attribute_category, @attribute_value, @entity_id)';

	const ADD_BLACKOUT_INSTANCE =
			'INSERT INTO blackout_instances (start_date, end_date, blackout_series_id)
		VALUES (@startDate, @endDate, @seriesid)';

	const ADD_EMAIL_PREFERENCE =
			'INSERT INTO user_email_preferences (user_id, event_category, event_type) VALUES (@userid, @event_category, @event_type)';

	const ADD_BLACKOUT_SERIES =
			'INSERT INTO blackout_series (date_created, title, owner_id, resource_id) VALUES (@dateCreated, @title, @userid, @resourceid)';

	const ADD_GROUP =
			'INSERT INTO groups (name) VALUES (@groupname)';

	const ADD_GROUP_RESOURCE_PERMISSION =
			'INSERT INTO group_resource_permissions (group_id, resource_id) VALUES (@groupid, @resourceid)';

	const ADD_GROUP_ROLE =
			'INSERT INTO group_roles (group_id, role_id) VALUES (@groupid, @roleid)';

	const ADD_LAYOUT =
			'INSERT INTO layouts (timezone) VALUES (@timezone)';

	const ADD_LAYOUT_TIME =
			'INSERT INTO time_blocks (layout_id, start_time, end_time, availability_code, label, day_of_week)
		VALUES (@layoutid, @startTime, @endTime, @periodType, @label, @day_of_week)';

	const ADD_QUOTA =
			'INSERT INTO quotas (quota_limit, unit, duration, resource_id, group_id, schedule_id)
		VALUES (@limit, @unit, @duration, @resourceid, @groupid, @scheduleid)';

	const ADD_REMINDER =
				'INSERT INTO reminders (user_id, address, message, sendtime, refnumber)
			VALUES (@user_id, @address, @message, @sendtime, @refnumber)';

	const ADD_RESERVATION =
			'INSERT INTO reservation_instances (start_date, end_date, reference_number, series_id)
		VALUES (@startDate, @endDate, @referenceNumber, @seriesid)';

	const ADD_RESERVATION_ACCESSORY =
			'INSERT INTO reservation_accessories (series_id, accessory_id, quantity)
		VALUES (@seriesid, @accessoryid, @quantity)';

	const ADD_RESERVATION_ATTACHMENT =
			'INSERT INTO reservation_files (series_id, file_name, file_type, file_size, file_extension)
		VALUES (@seriesid, @file_name, @file_type, @file_size, @file_extension)';

	const ADD_RESERVATION_REMINDER =
			'INSERT INTO reservation_reminders (series_id, minutes_prior, reminder_type)
			VALUES (@seriesid, @minutes_prior, @reminder_type)';

	const ADD_RESERVATION_RESOURCE =
			'INSERT INTO reservation_resources (series_id, resource_id, resource_level_id)
		VALUES (@seriesid, @resourceid, @resourceLevelId)';

	const ADD_RESERVATION_SERIES =
			'INSERT INTO
        reservation_series (date_created, title, description, allow_participation, allow_anon_participation, repeat_type, repeat_options, type_id, status_id, owner_id)
		VALUES (@dateCreated, @title, @description, false, false, @repeatType, @repeatOptions, @typeid, @statusid, @userid)';

	const ADD_RESERVATION_USER =
			'INSERT INTO reservation_users (reservation_instance_id, user_id, reservation_user_level)
		VALUES (@reservationid, @userid, @levelid)';

	const ADD_SAVED_REPORT =
			'INSERT INTO saved_reports (report_name, user_id, date_created, report_details)
			VALUES (@report_name, @userid, @dateCreated, @report_details)';

	const ADD_SCHEDULE =
			'INSERT INTO schedules (name, isdefault, weekdaystart, daysvisible, layout_id, admin_group_id)
		VALUES (@scheduleName, @scheduleIsDefault, @scheduleWeekdayStart, @scheduleDaysVisible, @layoutid, @admin_group_id)';

	const ADD_USER_GROUP =
			'INSERT INTO user_groups (user_id, group_id)
		VALUES (@userid, @groupid)';

	const ADD_USER_RESOURCE_PERMISSION =
			'INSERT INTO user_resource_permissions (user_id, resource_id)
		VALUES (@userid, @resourceid)';

	const ADD_USER_SESSION =
			'INSERT INTO user_session (user_id, last_modified, session_token, user_session_value)
		VALUES (@userid, @dateModified, @session_token, @user_session_value)';

	const AUTO_ASSIGN_PERMISSIONS =
			'INSERT INTO
          user_resource_permissions (user_id, resource_id)
		SELECT 
			@userid as user_id, resource_id 
		FROM 
			resources
		WHERE 
			autoassign=1';

	const AUTO_ASSIGN_RESOURCE_PERMISSIONS =
			'INSERT INTO
            user_resource_permissions (user_id, resource_id)
        SELECT
            user_id, @resourceid as resource_id
        FROM
            users';

	const CHECK_EMAIL =
			'SELECT user_id
		FROM users
		WHERE email = @email';

	const CHECK_USERNAME =
			'SELECT user_id
		FROM users
		WHERE username = @username';

	const CHECK_USER_EXISTANCE =
			'SELECT *
		FROM users
		WHERE ( (username IS NOT NULL AND username = @username) OR (email IS NOT NULL AND email = @email) )';

	const COOKIE_LOGIN =
			'SELECT user_id, lastlogin, email
		FROM users 
		WHERE user_id = @userid';

	const DELETE_ACCESSORY = 'DELETE FROM accessories WHERE accessory_id = @accessoryid';

	const DELETE_ATTRIBUTE = 'DELETE FROM custom_attributes WHERE custom_attribute_id = @custom_attribute_id';

	const DELETE_ATTRIBUTE_VALUES = 'DELETE FROM custom_attribute_values WHERE custom_attribute_id = @custom_attribute_id';

	const DELETE_ACCOUNT_ACTIVATION = 'DELETE FROM account_activation WHERE activation_code = @activation_code';

	const DELETE_ANNOUNCEMENT = 'DELETE FROM announcements WHERE announcementid = @announcementid';

	const DELETE_BLACKOUT_SERIES = 'DELETE FROM blackout_series WHERE blackout_series_id = @seriesid';

	const DELETE_EMAIL_PREFERENCE =
			'DELETE FROM user_email_preferences WHERE user_id = @userid AND event_category = @event_category AND event_type = @event_type';

	const DELETE_GROUP =
			'DELETE FROM groups	WHERE group_id = @groupid';

	const DELETE_GROUP_RESOURCE_PERMISSION =
			'DELETE	FROM group_resource_permissions WHERE group_id = @groupid AND resource_id = @resourceid';

	const DELETE_GROUP_ROLE = 'DELETE FROM group_roles WHERE group_id = @groupid AND role_id = @roleid';

	const DELETE_ORPHAN_LAYOUTS = 'DELETE l.* FROM layouts l LEFT JOIN schedules s ON l.layout_id = s.layout_id WHERE s.layout_id IS NULL';

	const DELETE_QUOTA = 'DELETE	FROM quotas	WHERE quota_id = @quotaid';

	const DELETE_RESOURCE_COMMAND = 'DELETE FROM resources WHERE resource_id = @resourceid';

	const DELETE_RESOURCE_RESERVATIONS_COMMAND =
			'DELETE s.*
		FROM reservation_series s 
		INNER JOIN reservation_resources rs ON s.series_id = rs.series_id 
		WHERE rs.resource_id = @resourceid';

	const DELETE_SAVED_REPORT = 'DELETE FROM saved_reports WHERE saved_report_id = @report_id AND user_id = @userid';

	const DELETE_SCHEDULE = 'DELETE FROM schedules WHERE schedule_id = @scheduleid';

	const DELETE_SERIES = 
		'UPDATE reservation_series 
		    SET status_id = @statusid, 
			last_modified = @dateModified 
		  WHERE series_id = @seriesid';

	const DELETE_USER = 'DELETE FROM users	WHERE user_id = @userid';

	const DELETE_USER_GROUP = 'DELETE FROM user_groups WHERE user_id = @userid AND group_id = @groupid';

	const DELETE_USER_RESOURCE_PERMISSION =
			'DELETE	FROM user_resource_permissions WHERE user_id = @userid AND resource_id = @resourceid';

	const DELETE_USER_SESSION =
			'DELETE	FROM user_session WHERE session_token = @session_token';

	const LOGIN_USER =
			'SELECT * FROM users WHERE (username = @username OR email = @username)';

	const GET_ACCESSORY_BY_ID = 'SELECT * FROM accessories WHERE accessory_id = @accessoryid';

	const GET_ACCESSORY_LIST =
			'SELECT *, rs.status_id as status_id
		FROM reservation_instances ri
		INNER JOIN reservation_series rs ON ri.series_id = rs.series_id
		INNER JOIN reservation_accessories ar ON ar.series_id = rs.series_id
		INNER JOIN accessories a on ar.accessory_id = a.accessory_id
		WHERE
			(
				(ri.start_date >= @startDate AND ri.start_date <= @endDate)
				OR
				(ri.end_date >= @startDate AND ri.end_date <= @endDate)
				OR
				(ri.start_date <= @startDate AND ri.end_date >= @endDate)
			) AND
			rs.status_id <> 2
		ORDER BY
			ri.start_date ASC';

	const GET_ALL_ACCESSORIES =
			'SELECT * FROM accessories ORDER BY accessory_name';

	const GET_ALL_ANNOUNCEMENTS = 'SELECT * FROM announcements ORDER BY start_date';

	const GET_ALL_APPLICATION_ADMINS = 'SELECT *
            FROM users
            WHERE status_id = @user_statusid AND
            user_id IN (
                SELECT user_id
                FROM user_groups ug
                INNER JOIN groups g ON ug.group_id = g.group_id
                INNER JOIN group_roles gr ON g.group_id = gr.group_id
                INNER JOIN roles ON roles.role_id = gr.role_id AND roles.role_level = @role_level
              )';

	const GET_ALL_GROUPS =
			'SELECT g.*, admin_group.name as admin_group_name
		FROM groups g
		LEFT JOIN groups admin_group ON g.admin_group_id = admin_group.group_id
		ORDER BY g.name';

	const GET_ALL_GROUPS_BY_ROLE =
			'SELECT g.*
		FROM groups g
		INNER JOIN group_roles gr ON g.group_id = gr.group_id
		INNER JOIN roles r ON r.role_id = gr.role_id
		WHERE r.role_level = @role_level
		ORDER BY g.name';

	const GET_ALL_GROUP_ADMINS =
			'SELECT u.* FROM users u
        INNER JOIN user_groups ug ON u.user_id = ug.user_id
        WHERE status_id = @user_statusid AND ug.group_id IN (
          SELECT g.admin_group_id FROM user_groups ug
          INNER JOIN groups g ON ug.group_id = g.group_id
          WHERE ug.user_id = @userid AND g.admin_group_id IS NOT NULL)';

	const GET_ALL_GROUP_USERS =
			'SELECT *
		FROM users u
		WHERE u.user_id IN (
		  SELECT DISTINCT (ug.user_id) FROM user_groups ug
		  INNER JOIN groups g ON g.group_id = ug.group_id
		  WHERE g.group_id IN (@groupid)
		  )
		AND (0 = @user_statusid OR u.status_id = @user_statusid)
		ORDER BY u.lname, u.fname';

	const GET_ALL_QUOTAS =
			'SELECT q.*, r.name as resource_name, g.name as group_name, s.name as schedule_name
		FROM quotas q
		LEFT JOIN resources r ON r.resource_id = q.resource_id
		LEFT JOIN groups g ON g.group_id = q.group_id
		LEFT JOIN schedules s ON s.schedule_id = q.schedule_id';

	const GET_ALL_REMINDERS = 'SELECT * FROM reminders';

	const GET_ALL_RESOURCES =
			'SELECT r.*, s.admin_group_id as s_admin_group_id
		FROM resources r
		INNER JOIN schedules s ON r.schedule_id = s.schedule_id
		ORDER BY COALESCE(r.sort_order,0), r.name';

	const GET_ALL_RESOURCE_ADMINS =
			'SELECT *
        FROM users
        WHERE status_id = @user_statusid AND
        user_id IN (
            SELECT user_id
            FROM user_groups ug
            INNER JOIN groups g ON ug.group_id = g.group_id
            INNER JOIN group_roles gr ON g.group_id = gr.group_id
            INNER JOIN roles ON roles.role_id = gr.role_id AND roles.role_level = @role_level
            INNER JOIN resources r ON g.group_id = r.admin_group_id
            WHERE r.resource_id = @resourceid
          )';

	const GET_ALL_SAVED_REPORTS = 'SELECT * FROM saved_reports WHERE user_id = @userid ORDER BY report_name, date_created';

	const GET_ALL_SCHEDULES = 'SELECT * FROM schedules s INNER JOIN layouts l ON s.layout_id = l.layout_id';

	const GET_ALL_USERS_BY_STATUS =
			'SELECT * FROM users WHERE (0 = @user_statusid OR status_id = @user_statusid) ORDER BY lname, fname';
	
	const GET_ALL_USERS_BY_LEVEL =
			'SELECT * FROM users us inner join custom_attribute_values ca on us.user_id=ca.entity_id where ca.custom_attribute_id=1 and ca.attribute_category=2 and ca.attribute_value=@user_level ORDER BY lname, fname';

	const GET_ALL_USERS_BY_GROUP =
			'SELECT * FROM users us inner join user_groups ug on us.user_id=ug.user_id where ug.group_id=@user_groupid ORDER BY lname, fname';
			
	const GET_ANNOUNCEMENT_BY_ID = 'SELECT * FROM announcements WHERE announcementid = @announcementid';

	const GET_ATTRIBUTES_BY_CATEGORY = 'SELECT * FROM custom_attributes
		WHERE attribute_category = @attribute_category ORDER BY sort_order, display_label';

	const GET_ATTRIBUTE_BY_ID = 'SELECT * FROM custom_attributes WHERE custom_attribute_id = @custom_attribute_id';

	const GET_ATTRIBUTE_MULTIPLE_VALUES = 'SELECT *
		FROM custom_attribute_values WHERE entity_id IN (@entity_ids) AND attribute_category = @attribute_category';

	const GET_ATTRIBUTE_VALUES = 'SELECT cav.*, ca.display_label
		FROM custom_attribute_values cav
		INNER JOIN custom_attributes ca ON ca.custom_attribute_id = cav.custom_attribute_id
		WHERE cav.attribute_category = @attribute_category AND cav.entity_id = @entity_id';

	const GET_BLACKOUT_LIST =
			'SELECT *
		FROM blackout_instances bi
		INNER JOIN blackout_series bs ON bi.blackout_series_id = bs.blackout_series_id
		INNER JOIN resources r on bs.resource_id = r.resource_id
		INNER JOIN users u ON u.user_id = bs.owner_id
		WHERE
			(
				(bi.start_date >= @startDate AND bi.start_date <= @endDate)
				OR
				(bi.end_date >= @startDate AND bi.end_date <= @endDate)
				OR
				(bi.start_date <= @startDate AND bi.end_date >= @endDate)
			) AND
			(@scheduleid = -1 OR r.schedule_id = @scheduleid)
		ORDER BY bi.start_date ASC';

	const GET_BLACKOUT_LIST_FULL =
			'SELECT bi.*, resources.*, u.*, bs.*, schedules.schedule_id
		FROM blackout_instances bi
		INNER JOIN blackout_series bs ON bi.blackout_series_id = bs.blackout_series_id
		INNER JOIN resources on bs.resource_id = resources.resource_id
		INNER JOIN schedules on resources.schedule_id = schedules.schedule_id
		INNER JOIN users u ON u.user_id = bs.owner_id
		ORDER BY bi.start_date ASC';

	const GET_DASHBOARD_ANNOUNCEMENTS =
			'SELECT announcement_text
		FROM announcements
		WHERE (start_date <= @current_date AND end_date >= @current_date) OR (end_date IS NULL)
		ORDER BY priority, start_date, end_date';

	const GET_GROUP_BY_ID =
			'SELECT *
		FROM groups
		WHERE group_id = @groupid';

	const GET_GROUPS_I_CAN_MANAGE = 'SELECT g.group_id, g.name
		FROM groups g
		INNER JOIN groups a ON g.admin_group_id = a.group_id
		INNER JOIN user_groups ug on ug.group_id = a.group_id
		WHERE ug.user_id = @userid';

	const GET_GROUP_RESOURCE_PERMISSIONS =
			'SELECT *
		FROM group_resource_permissions
		WHERE group_id = @groupid';

	const GET_GROUP_ROLES =
			'SELECT r.*
		FROM roles r
		INNER JOIN group_roles gr ON r.role_id = gr.role_id
		WHERE gr.group_id = @groupid';

	const GET_REMINDER_NOTICES = 'SELECT
		rs.*,
		ri.*,
		u.*,
		r.name as resource_name
		FROM reservation_instances ri
		INNER JOIN reservation_series rs ON ri.series_id = rs.series_id
		INNER JOIN reservation_reminders rr on ri.series_id = rr.series_id INNER JOIN reservation_users ru on ru.reservation_instance_id = ri.reservation_instance_id
		INNER JOIN users u on ru.user_id = u.user_id
		INNER JOIN reservation_resources ON reservation_resources.series_id = ri.series_id AND resource_level_id = 1
		INNER JOIN resources r on reservation_resources.resource_id = r.resource_id
		WHERE (@reminder_type=0 AND date_sub(start_date,INTERVAL rr.minutes_prior MINUTE) = @current_date) OR (@reminder_type=1 AND date_sub(end_date,INTERVAL rr.minutes_prior MINUTE) = @current_date)';

	const GET_REMINDERS_BY_USER = 'SELECT * FROM reminders WHERE user_id = @user_id';

   	const GET_REMINDERS_BY_REFNUMBER = 'SELECT * FROM reminders WHERE refnumber = @refnumber';

	const GET_RESOURCE_BY_CONTACT_INFO =
			'SELECT r.*, s.admin_group_id as s_admin_group_id
			FROM resources r
			INNER JOIN schedules s ON r.schedule_id = s.schedule_id
			WHERE r.contact_info = @contact_info';

	const GET_RESOURCE_BY_ID =
			'SELECT r.*, s.admin_group_id as s_admin_group_id
			FROM resources r
			INNER JOIN schedules s ON r.schedule_id = s.schedule_id
			WHERE r.resource_id = @resourceid';

	const GET_RESOURCE_BY_PUBLIC_ID =
			'SELECT r.*, s.admin_group_id as s_admin_group_id
			FROM resources r
			INNER JOIN  schedules s ON r.schedule_id = s.schedule_id
			WHERE r.public_id = @publicid';

	const GET_RESERVATION_BY_ID =
			'SELECT *
		FROM reservation_instances r
		INNER JOIN reservation_series rs ON r.series_id = rs.series_id
		WHERE
			r.reservation_instance_id = @reservationid AND
			status_id <> 2';

	const GET_RESERVATION_BY_REFERENCE_NUMBER =
			'SELECT *
		FROM reservation_instances r
		INNER JOIN reservation_series rs ON r.series_id = rs.series_id
		WHERE
			reference_number = @referenceNumber AND
			status_id <> 2';

	const GET_RESERVATION_FOR_EDITING =
			'SELECT ri.*, rs.*, rr.*, u.user_id, u.fname, u.lname, u.email, r.schedule_id, r.name, rs.status_id as status_id
		FROM reservation_instances ri
		INNER JOIN reservation_series rs ON rs.series_id = ri.series_id
		INNER JOIN users u ON u.user_id = rs.owner_id
		INNER JOIN reservation_resources rr ON rs.series_id = rr.series_id AND rr.resource_level_id = @resourceLevelId
		INNER JOIN resources r ON r.resource_id = rr.resource_id
		WHERE 
			reference_number = @referenceNumber AND
			rs.status_id <> 2';

	const GET_RESERVATION_LIST_TEMPLATE =
			'SELECT
				[SELECT_TOKEN]
			FROM reservation_instances ri
			INNER JOIN reservation_series rs ON rs.series_id = ri.series_id
			INNER JOIN reservation_users ru ON ru.reservation_instance_id = ri.reservation_instance_id
			INNER JOIN users ON users.user_id = ru.user_id
			INNER JOIN users owner ON owner.user_id = rs.owner_id
			INNER JOIN reservation_resources rr ON rs.series_id = rr.series_id
			INNER JOIN resources ON rr.resource_id = resources.resource_id
			INNER JOIN schedules ON resources.schedule_id = schedules.schedule_id
			LEFT JOIN reservation_users participants ON participants.reservation_instance_id = ri.reservation_instance_id AND participants.reservation_user_level = 2
			LEFT JOIN reservation_users invitees ON invitees.reservation_instance_id = ri.reservation_instance_id AND invitees.reservation_user_level = 3
			LEFT JOIN custom_attribute_values cav ON cav.entity_id = ri.series_id AND cav.attribute_category = 1
			[JOIN_TOKEN]
			WHERE  rs.status_id <> 2
			[AND_TOKEN]
			GROUP BY ri.reservation_instance_id, rr.resource_id, ri.series_id
			ORDER BY ri.start_date ASC';
			
	const GET_RESERVATION_LIST_TEMPLATE2 =
			'SELECT
				[SELECT_TOKEN]
			FROM reservation_instances ri
			INNER JOIN reservation_series rs ON rs.series_id = ri.series_id
			INNER JOIN reservation_users ru ON ru.reservation_instance_id = ri.reservation_instance_id
			INNER JOIN users ON users.user_id = ru.user_id
			INNER JOIN users owner ON owner.user_id = rs.owner_id
			INNER JOIN reservation_resources rr ON rs.series_id = rr.series_id
			INNER JOIN resources ON rr.resource_id = resources.resource_id
			INNER JOIN schedules ON resources.schedule_id = schedules.schedule_id
			LEFT JOIN reservation_users participants ON participants.reservation_instance_id = ri.reservation_instance_id AND participants.reservation_user_level = 2
			LEFT JOIN reservation_users invitees ON invitees.reservation_instance_id = ri.reservation_instance_id AND invitees.reservation_user_level = 3
			LEFT JOIN custom_attribute_values cav ON cav.entity_id = ri.series_id AND cav.attribute_category = 1
			[JOIN_TOKEN]
			WHERE  rs.status_id <> 2 [IN_TOKEN]
			[AND_TOKEN]
			GROUP BY ri.reservation_instance_id, rr.resource_id, ri.series_id
			ORDER BY ri.start_date ASC';

	const GET_RESERVATION_ACCESSORIES =
			'SELECT *
		FROM reservation_accessories ra
		INNER JOIN accessories a ON ra.accessory_id = a.accessory_id
		WHERE ra.series_id = @seriesid';

	const GET_RESERVATION_ATTACHMENT = 'SELECT * FROM reservation_files WHERE file_id = @file_id';

	const GET_RESERVATION_ATTACHMENTS_FOR_SERIES = 'SELECT * FROM reservation_files WHERE series_id = @seriesid';

	const GET_RESERVATION_PARTICIPANTS =
			'SELECT
			u.user_id, 
			u.fname,
			u.lname,
			u.email,
			ru.*
		FROM reservation_users ru
		INNER JOIN users u ON ru.user_id = u.user_id
		WHERE reservation_instance_id = @reservationid';

	const GET_RESERVATION_REMINDERS = 'SELECT * FROM reservation_reminders WHERE series_id = @seriesid';

	const GET_RESERVATION_RESOURCES =
			'SELECT r.*, rr.resource_level_id, s.admin_group_id as s_admin_group_id
		FROM reservation_resources rr
		INNER JOIN resources r ON rr.resource_id = r.resource_id
		INNER JOIN schedules s ON r.schedule_id = s.schedule_id
		WHERE rr.series_id = @seriesid
		ORDER BY resource_level_id, r.name';

	const GET_RESERVATION_SERIES_INSTANCES =
			'SELECT *
		FROM reservation_instances
		WHERE series_id = @seriesid';

	const GET_RESERVATION_SERIES_PARTICIPANTS =
			'SELECT ru.*, ri.*
		FROM reservation_users ru
		INNER JOIN reservation_instances ri ON ru.reservation_instance_id = ri.reservation_instance_id
		WHERE series_id = @seriesid';

	const GET_SCHEDULE_TIME_BLOCK_GROUPS =
			'SELECT
			tb.label, 
			tb.end_label, 
			tb.start_time, 
			tb.end_time, 
			tb.availability_code,
			tb.day_of_week,
			l.timezone
		FROM 
			time_blocks tb, 
			layouts l,
			schedules s
		WHERE 
			l.layout_id = s.layout_id  AND 
			tb.layout_id = l.layout_id AND
			s.schedule_id = @scheduleid 
		ORDER BY tb.start_time';

	const GET_SAVED_REPORT = 'SELECT * FROM saved_reports WHERE saved_report_id = @report_id AND user_id = @userid';

	const GET_SCHEDULE_BY_ID =
			'SELECT * FROM schedules s
		INNER JOIN layouts l ON s.layout_id = l.layout_id
		WHERE schedule_id = @scheduleid';

	const GET_SCHEDULE_BY_PUBLIC_ID =
			'SELECT * FROM schedules s
        INNER JOIN layouts l ON s.layout_id = l.layout_id
        WHERE public_id = @publicid';

	const GET_SCHEDULE_RESOURCES =
			'SELECT r.*, s.admin_group_id as s_admin_group_id FROM  resources r
		INNER JOIN schedules s ON r.schedule_id = s.schedule_id
		WHERE 
			r.schedule_id = @scheduleid AND
			r.isactive = 1
		ORDER BY r.sort_order, r.name';

	const GET_USERID_BY_ACTIVATION_CODE =
			'SELECT a.user_id FROM account_activation a
			INNER JOIN users u ON u.user_id = a.user_id
			WHERE activation_code = @activation_code AND u.status_id = @statusid';

	const GET_USER_BY_ID =
			'SELECT * FROM users WHERE user_id = @userid';

	const GET_USER_BY_PUBLIC_ID =
			'SELECT * FROM users WHERE public_id = @publicid';

	const GET_USER_EMAIL_PREFERENCES =
			'SELECT * FROM user_email_preferences WHERE user_id = @userid';

	const GET_USER_GROUPS =
			'SELECT g.*, r.role_level
		FROM user_groups ug
		INNER JOIN groups g ON ug.group_id = g.group_id
		LEFT JOIN group_roles gr ON ug.group_id = gr.group_id
		LEFT JOIN roles r ON gr.role_id = r.role_id
		WHERE user_id = @userid AND (@role_null is null OR r.role_level IN (@role_level) )';

	const GET_USER_RESOURCE_PERMISSIONS =
			'SELECT
			urp.user_id, r.resource_id, r.name
		FROM
			user_resource_permissions urp, resources r
		WHERE
			urp.user_id = @userid AND r.resource_id = urp.resource_id';

	const GET_USER_GROUP_RESOURCE_PERMISSIONS =
			'SELECT
			grp.group_id, r.resource_id, r.name
		FROM
			group_resource_permissions grp, resources r, user_groups ug
		WHERE
			ug.user_id = @userid AND ug.group_id = grp.group_id AND grp.resource_id = r.resource_id';

	const GET_USER_ROLES =
			'SELECT
			user_id, user_level 
		FROM 
			roles r
		INNER JOIN
			user_roles ur on r.role_id = ur.role_id
		WHERE 
			ur.user_id = @userid';

	const GET_USER_SESSION_BY_SESSION_TOKEN = 'SELECT * FROM user_session WHERE session_token = @session_token';

	const GET_USER_SESSION_BY_USERID = 'SELECT * FROM user_session WHERE user_id = @userid';

	const MIGRATE_PASSWORD =
			'UPDATE
			users 
		SET 
			password = @password, legacypassword = null, salt = @salt 
		WHERE 
			user_id = @userid';

	const REGISTER_FORM_SETTINGS =
			'INSERT INTO
			registration_form_settings (fname_setting, lname_setting, username_setting, email_setting, password_setting, 
			organization_setting, group_setting, position_setting, address_setting, phone_setting, homepage_setting, timezone_setting)	
		VALUES
			(@fname_setting, @lname_setting, @username_setting, @email_setting, @password_setting, @organization_setting, 
			 @group_setting, @position_setting, @address_setting, @phone_setting, @homepage_setting, @timezone_setting)
		';

	const REGISTER_MINI_USER =
			'INSERT INTO
			users (email, password, fname, lname, username, salt, timezone, status_id, role_id)
		VALUES
			(@email, @password, @fname, @lname, @username, @salt, @timezone, @user_statusid, @user_roleid)';

	const REGISTER_USER =
			'INSERT INTO
			users (email, password, fname, lname, phone, organization, position, username, salt, timezone, language, homepageid, status_id, date_created, public_id, default_schedule_id)
		VALUES
			(@email, @password, @fname, @lname, @phone, @organization, @position, @username, @salt, @timezone, @language, @homepageid, @user_statusid, @dateCreated, @publicid, @scheduleid)';

	const REMOVE_ATTRIBUTE_VALUE =
			'DELETE FROM custom_attribute_values WHERE custom_attribute_id = @custom_attribute_id AND entity_id = @entity_id';

	const DELETE_REMINDER = 'DELETE FROM reminders WHERE reminder_id = @reminder_id';

	const DELETE_REMINDER_BY_USER = 'DELETE FROM reminders WHERE user_id = @user_id';

	const DELETE_REMINDER_BY_REFNUMBER = 'DELETE FROM reminders WHERE refnumber = @refnumber';

	const REMOVE_RESERVATION_ACCESSORY =
			'DELETE FROM reservation_accessories WHERE accessory_id = @accessoryid AND series_id = @seriesid';

	const REMOVE_RESERVATION_ATTACHMENT =
			'DELETE FROM reservation_files WHERE file_id = @file_id';

	const REMOVE_RESERVATION_INSTANCE =
			'DELETE FROM reservation_instances WHERE reference_number = @referenceNumber';

	const REMOVE_RESERVATION_REMINDER =
			'DELETE FROM reservation_reminders WHERE series_id = @seriesid AND reminder_type = @reminder_type';

	const REMOVE_RESERVATION_RESOURCE =
			'DELETE FROM reservation_resources WHERE series_id = @seriesid AND resource_id = @resourceid';

	const REMOVE_RESERVATION_USER =
			'DELETE FROM reservation_users WHERE reservation_instance_id = @reservationid AND user_id = @userid';

	const ADD_RESOURCE =
			'INSERT INTO
			resources (name, location, contact_info, description, notes, isactive, min_duration, min_increment, 
					   max_duration, unit_cost, autoassign, requires_approval, allow_multiday_reservations, 
					   max_participants, min_notice_time, max_notice_time, schedule_id, admin_group_id)
		VALUES
			(@resource_name, @location, @contact_info, @description, @resource_notes, @isactive, @min_duration, @min_increment, 
			 @max_duration, @unit_cost, @autoassign, @requires_approval, @allow_multiday_reservations,
		     @max_participants, @min_notice_time, @max_notice_time, @scheduleid, @admin_group_id)';

	const SET_DEFAULT_SCHEDULE =
			'UPDATE schedules
		SET isdefault = 0
		WHERE schedule_id <> @scheduleid';

	const UPDATE_ACCESSORY =
			'UPDATE accessories
		SET accessory_name = @accessoryname, accessory_quantity = @quantity
		WHERE accessory_id = @accessoryid';

	const UPDATE_ANNOUNCEMENT =
			'UPDATE announcements
		SET announcement_text = @text, priority = @priority, start_date = @startDate, end_date = @endDate, important = @important
		WHERE announcementid = @announcementid';

	const UPDATE_ATTRIBUTE =
			'UPDATE custom_attributes
				SET display_label = @display_label, display_type = @display_type, attribute_category = @attribute_category,
				validation_regex = @validation_regex, is_required = @is_required, possible_values = @possible_values, sort_order = @sort_order
			WHERE custom_attribute_id = @custom_attribute_id';

	const UPDATE_GROUP =
			'UPDATE groups
		SET name = @groupname, admin_group_id = @admin_group_id
		WHERE group_id = @groupid';

	const UPDATE_LOGINDATA =
			'UPDATE users
		SET lastlogin = @lastlogin,
		language = @language
		WHERE user_id = @userid';

	const UPDATE_FUTURE_RESERVATION_INSTANCES =
			'UPDATE reservation_instances
		SET series_id = @seriesid
		WHERE
			series_id = @currentSeriesId AND
			start_date >= (SELECT start_date FROM reservation_instances WHERE reference_number = @referenceNumber)';

	const UPDATE_RESERVATION_INSTANCE =
			'UPDATE reservation_instances
		SET
			series_id = @seriesid,
			start_date = @startDate,
			end_date = @endDate
		WHERE
			reference_number = @referenceNumber';

	const UPDATE_RESERVATION_SERIES =
			'UPDATE
			reservation_series
		SET
			last_modified = @dateModified, 
			title = @title, 
			description = @description, 
			repeat_type = @repeatType, 
			repeat_options = @repeatOptions,
			status_id = @statusid,
			owner_id = @userid
		WHERE
			series_id = @seriesid';

	const UPDATE_RESOURCE =
			'UPDATE resources
		SET
			name = @resource_name,
			location = @location,
			contact_info = @contact_info,
			description = @description,
			notes = @resource_notes,
			min_duration = @min_duration,
			max_duration = @max_duration,
			autoassign = @autoassign,
			requires_approval = @requires_approval,
			allow_multiday_reservations = @allow_multiday_reservations,
			max_participants = @max_participants,
			min_notice_time = @min_notice_time,
			max_notice_time = @max_notice_time,
			image_name = @imageName,
			isactive = @isActive,
			schedule_id = @scheduleid,
			admin_group_id = @admin_group_id,
			allow_calendar_subscription = @allow_calendar_subscription,
			public_id = @publicid,
			sort_order = @sort_order
		WHERE
			resource_id = @resourceid';

	const UPDATE_SCHEDULE =
			'UPDATE schedules
		SET
			name = @scheduleName,
			isdefault = @scheduleIsDefault,
			weekdaystart = @scheduleWeekdayStart,
			daysvisible = @scheduleDaysVisible,
			allow_calendar_subscription = @allow_calendar_subscription,
			public_id = @publicid,
			admin_group_id = @admin_group_id
		WHERE
			schedule_id = @scheduleid';

	const UPDATE_SCHEDULE_LAYOUT =
			'UPDATE schedules
		SET
			layout_id = @layoutid
		WHERE
			schedule_id = @scheduleid';

	const UPDATE_USER =
			'UPDATE users
		SET
			status_id = @user_statusid,
			password = @password,
			salt = @salt,
			fname = @fname,
			lname = @lname,
			email = @email,
			username = @username,
			homepageId = @homepageid,
			last_modified = @dateModified,
			timezone = @timezone,
			allow_calendar_subscription = @allow_calendar_subscription,
			public_id = @publicid,
			language = @language,
			lastlogin = @lastlogin,
			default_schedule_id = @scheduleid
		WHERE
			user_id = @userid';

	const UPDATE_USER_ATTRIBUTES =
			'UPDATE	users
		SET
			phone = @phone,
			position = @position,
			organization = @organization
		WHERE
			user_id = @userid';

	const UPDATE_USER_BY_USERNAME =
			'UPDATE users
		SET 
			email = COALESCE(@email, email),
			password = @password,
			salt = @salt,
			fname = COALESCE(@fname, fname),
			lname = COALESCE(@lname, lname),
			phone = COALESCE(@phone, phone),
			organization = COALESCE(@organization, organization),
			position = COALESCE(@position, position)
		WHERE 
			username = @username';

	const UPDATE_USER_SESSION =
			'UPDATE user_session
		SET
			last_modified = @dateModified,
			session_token = @session_token,
			user_session_value = @user_session_value
		WHERE user_id = @userid';

	const VALIDATE_USER =
			'SELECT user_id, password, salt, legacypassword
		FROM users 
		WHERE (username = @username OR email = @username) AND status_id = 1';
}

class QueryBuilder
{
	public static $DATE_FRAGMENT = '((ri.start_date >= @startDate AND ri.start_date <= @endDate) OR
					(ri.end_date >= @startDate AND ri.end_date <= @endDate) OR
					(ri.start_date <= @startDate AND ri.end_date >= @endDate))';

	public static $SELECT_LIST_FRAGMENT = 'ri.*, rs.date_created as date_created, rs.last_modified as last_modified, rs.description as description,
					rs.status_id as status_id, owner.fname as owner_fname, owner.lname as owner_lname, owner.user_id as owner_id, owner.phone as owner_phone, owner.position as owner_position, owner.organization as owner_organization,
					resources.name, resources.resource_id, resources.schedule_id, rs.title, ru.reservation_user_level,
					GROUP_CONCAT(DISTINCT participants.user_id) as participant_list, GROUP_CONCAT(DISTINCT invitees.user_id) as invitee_list, GROUP_CONCAT(DISTINCT CONCAT(cav.custom_attribute_id,\'=\', cav.attribute_value)) as attributes';

	private static function Build($selectValue, $joinValue, $andValue)
	{
		if(isset($_GET['payment']) && $_GET['payment']!=''){
			//epilogi mono twn kratisewn pou ikanopoioun to payment
			$value=$_GET['payment'];
			if($value==1){
				$value='NAI';
			}
			else if($value==0){
				$value='OXI';
			}
			else{
				$value='';
			}
			$rows=pdoq("select entity_id from custom_attribute_values where attribute_category=1 and attribute_value=?",$value);
			$series_ids=array();
			foreach($rows as $row){
				$series_ids[]=$row->entity_id;
			}
			$series_ids=join(",",$series_ids);
			$rows=pdoq("select reservation_instance_id from reservation_instances where series_id IN ($series_ids)");
			$res_ids=array();
			foreach($rows as $row){
				$res_ids[]=$row->reservation_instance_id;
			}
			$res_ids=join(",",$res_ids);
			
			if(!empty($res_ids)){
				return str_replace('[AND_TOKEN]', $andValue,
					str_replace('[JOIN_TOKEN]', $joinValue,
					str_replace('[SELECT_TOKEN]', $selectValue, str_replace('[IN_TOKEN]', "AND ri.reservation_instance_id IN ($res_ids)", Queries::GET_RESERVATION_LIST_TEMPLATE2))));
			}
			return str_replace('[AND_TOKEN]', $andValue,
			   str_replace('[JOIN_TOKEN]', $joinValue,
			   str_replace('[SELECT_TOKEN]', $selectValue, str_replace('[IN_TOKEN]', "AND ri.reservation_instance_id IN ('')", Queries::GET_RESERVATION_LIST_TEMPLATE2))));
			
		}
		return str_replace('[AND_TOKEN]', $andValue,
			   str_replace('[JOIN_TOKEN]', $joinValue,
			   str_replace('[SELECT_TOKEN]', $selectValue, Queries::GET_RESERVATION_LIST_TEMPLATE)));
	}

	public static function GET_RESERVATION_LIST()
	{
		return self::Build(self::$SELECT_LIST_FRAGMENT, null, 'AND ' . self::$DATE_FRAGMENT . ' AND
					(@userid = -1 OR ru.user_id = @userid) AND
					(@levelid = 0 OR ru.reservation_user_level = @levelid) AND
					(@scheduleid = -1 OR resources.schedule_id = @scheduleid) AND
					(@resourceid = -1 OR rr.resource_id = @resourceid)');
	}

	public static function GET_RESERVATION_LIST_FULL()
	{
		return self::Build(self::$SELECT_LIST_FRAGMENT, null, 'AND (ru.reservation_user_level = @levelid)');
	}

    public static function GET_RESERVATION_LIST_FULL_INC_PARTS()
    {
        return self::Build(self::$SELECT_LIST_FRAGMENT, null, 'AND (ru.reservation_user_level = 1 OR ru.reservation_user_level = 2)');
    }

	public static function GET_RESERVATIONS_BY_ACCESSORY_NAME()
	{
		return self::Build(self::$SELECT_LIST_FRAGMENT,
						   'INNER JOIN reservation_accessories ar ON rs.series_id = ar.series_id INNER JOIN accessories a ON ar.accessory_id = a.accessory_id',
						   'AND ' . self::$DATE_FRAGMENT . ' AND a.accessory_name LIKE @accessoryname');
	}
}
?>
