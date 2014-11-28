<?php

interface IRegistration
{
	/**
	 * @param string $login
	 * @param string $email
	 * @param string $firstName
	 * @param string $lastName
	 * @param string $password unencrypted password
	 * @param string $timezone name of user timezone
	 * @param string $language preferred language code
	 * @param int $homepageId lookup id of the page to redirect the user to on login
	 * @param array $additionalFields key value pair of additional fields to use during registration
	 * @param array|AttributeValue[] $attributeValues
	 * @return User
	 */
	public function Register($login, $email, $firstName, $lastName, $password, $timezone, $language, $homepageId, $additionalFields = array(), $attributeValues = array());
	
	/**
	 * @param string $loginName
	 * @param string $emailAddress
	 * @return bool if the user exists or not
	 */
	public function UserExists($loginName, $emailAddress);

	/**
	 * Add or update a user who has already been authenticated
	 * @param AuthenticatedUser $user
	 * @return void
	 */
	public function Synchronize(AuthenticatedUser $user);
}
?>