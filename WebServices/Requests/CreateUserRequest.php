<?php

require_once(ROOT_DIR . 'WebServices/Requests/UserRequestBase.php');

class CreateUserRequest extends UserRequestBase
{
	public $password;
	public $language;

	public static function Example()
	{
		$request = new CreateUserRequest();
		$request->firstName = 'first';
		$request->lastName = 'last';
		$request->emailAddress = 'email@address.com';
		$request->userName = 'username';
		$request->timezone = 'America/Chicago';
		$request->language = 'en_us';
		$request->password = 'unencrypted password';
		$request->phone = '123-456-7989';
		$request->organization = 'organization';
		$request->position = 'position';
		$request->customAttributes = array(new AttributeValueRequest(99, 'attribute value'));
		return $request;
	}
}

?>