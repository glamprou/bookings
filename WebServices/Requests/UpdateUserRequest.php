<?php

require_once(ROOT_DIR . 'WebServices/Requests/UserRequestBase.php');

class UpdateUserRequest extends UserRequestBase
{
	public static function Example()
	{
		$request = new UpdateUserRequest();
		$request->firstName = 'first';
		$request->lastName = 'last';
		$request->emailAddress = 'email@address.com';
		$request->userName = 'username';
		$request->timezone = 'America/Chicago';
		$request->phone = '123-456-7989';
		$request->organization = 'organization';
		$request->position = 'position';
		$request->customAttributes = array(new AttributeValueRequest(99, 'attribute value'));
		return $request;
	}
}

?>