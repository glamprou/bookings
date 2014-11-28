<?php

interface IAuthenticationPage
{
	/**
	 * @return string
	 */
	public function GetEmailAddress();

	/**
	 * @return string
	 */
	public function GetPassword();

	/**
	 * @return void
	 */
	public function SetShowLoginError();
}

interface IAuthentication extends IAuthenticationPromptOptions
{
	/**
	 * @abstract
	 * @param string $username
	 * @param string $password
	 * @return bool If user is valid
	 */
	public function Validate($username, $password);

	/**
	 * @abstract
	 * @param string $username
	 * @param ILoginContext $loginContext
	 * @return UserSession
	 */
	public function Login($username, $loginContext);

	/**
	 * @param UserSession $user
	 * @return void
	 */
	public function Logout(UserSession $user);

	/**
	 * @return bool
	 */
	public function AreCredentialsKnown();

	/**
	 * @param IAuthenticationPage $loginPage
	 * @return void
	 */
	public function HandleLoginFailure(IAuthenticationPage $loginPage);
}

interface IAuthenticationPromptOptions
{
	/**
	 * @abstract
	 * @return bool
	 */
	public function ShowUsernamePrompt();

	/**
	 * @abstract
	 * @return bool
	 */
	public function ShowPasswordPrompt();

	/**
	 * @abstract
	 * @return bool
	 */
	public function ShowPersistLoginPrompt();

	/**
	 * @abstract
	 * @return bool
	 */
	public function ShowForgotPasswordPrompt();
}

?>