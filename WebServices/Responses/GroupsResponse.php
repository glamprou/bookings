<?php

require_once(ROOT_DIR . 'WebServices/Responses/GroupItemResponse.php');

class GroupsResponse extends RestResponse
{
	/**
	 * @var array|GroupItemResponse[]
	 */
	public $groups;

	/**
	 * @param IRestServer $server
	 * @param array|GroupItemView[] $groups
	 */
	public function __construct(IRestServer $server, $groups)
	{
		foreach($groups as $group)
		{
			$this->groups[] = new GroupItemResponse($server, $group->Id, $group->Name);
		}
	}

	public static function Example()
	{
		return new ExampleGroupsResponse();
	}
}

class ExampleGroupsResponse extends GroupsResponse
{
	public function __construct()
	{
		$this->groups = array(GroupItemResponse::Example());
	}
}
?>