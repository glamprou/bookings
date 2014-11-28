<?php

require_once(ROOT_DIR . 'lib/Application/Authorization/PermissionService.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/PermissionServiceFactory.php');

class ViewSchedulePermissionService implements IPermissionService
{
	/**
	 * @param IPermissibleResource $resource
	 * @param UserSession $user
	 * @return bool
	 */
	public function CanAccessResource(IPermissibleResource $resource, UserSession $user)
	{
		return true;
	}
}

class ViewSchedulePermissionServiceFactory implements IPermissionServiceFactory
{
	/**
	 * @return IPermissionService
	 */
	public function GetPermissionService()
	{
		return new ViewSchedulePermissionService();
	}
}

?>