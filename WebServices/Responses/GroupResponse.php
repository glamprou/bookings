<?php

class GroupResponse extends RestResponse
{
	public $id;
	public $name;
	public $adminGroup;
	public $permissions = array();
	public $user = array();
	public $roles = array();

	public function __construct(IRestServer $server, Group $group)
	{
		$this->id = $group->Id();
		$this->name = $group->Name();
		$this->adminGroup = $server->GetServiceUrl(WebServices::GetGroup, array(WebServiceParams::GroupId => $group->AdminGroupId()));

		foreach ($group->AllowedResourceIds() as $resourceId)
		{
			$this->permissions[] = $server->GetServiceUrl(WebServices::GetResource, array(WebServiceParams::ResourceId => $resourceId));
		}

		foreach ($group->UserIds() as $userId)
		{
			$this->users[] = $server->GetServiceUrl(WebServices::GetUser, array(WebServiceParams::UserId => $userId));
		}

		foreach ($group->RoleIds() as $roleId)
		{
			$this->roles[] = $roleId;
		}
	}

	public static function Example()
	{
		return new ExampleGroupResponse();
	}
}

class ExampleGroupResponse extends GroupResponse
{
	public function __construct()
	{
		$this->id = 123;
		$this->name = 'group name';
		$this->adminGroup = 'http://url/to/group';
		$this->permissions = array('http://url/to/resource');
		$this->user = array('http://url/to/user');
		$this->roles = array(1,2);
	}
}

?>