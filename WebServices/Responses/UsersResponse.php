<?php

require_once(ROOT_DIR . 'lib/WebService/namespace.php');
require_once(ROOT_DIR . 'WebServices/Responses/UserItemResponse.php');

class UsersResponse extends RestResponse
{
	/**
	 * @var array|UserItemResponse[]
	 */
	public $users = array();

	/**
	 * @param IRestServer $server
	 * @param array|UserItemView[] $users
	 * @param IEntityAttributeList $attributes
	 */
	public function __construct(IRestServer $server, $users, IEntityAttributeList $attributes)
	{
		foreach ($users as $user)
		{
			$this->users[] = new UserItemResponse($server, $user, $attributes);
		}
	}

	public static function Example()
	{
		return new ExampleUsersResponse();

	}
}

class ExampleUsersResponse extends UsersResponse
{
	public function __construct()
	{
		$this->users = array(UserItemResponse::Example());
	}
}

?>