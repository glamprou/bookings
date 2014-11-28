<?php

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/PasswordPresenter.php');


interface IPasswordPage extends IPage
{
	public function GetCurrentPassword();
	public function GetPassword();
	public function GetPasswordConfirmation();

	public function ResettingPassword();

	public function ShowResetPasswordSuccess($resetPasswordSuccess);
}
class PasswordPage extends SecurePage implements IPasswordPage
{
	/**
	 * @var \PasswordPresenter
	 */
	private $presenter;
	
	public function __construct()
	{
	    parent::__construct('ChangePassword');
		$this->presenter = new PasswordPresenter($this, new UserRepository(), new PasswordEncryption());
	}

	public function PageLoad()
	{
		$this->presenter->PageLoad();
		$this->Display('password.tpl');
	}

	public function GetCurrentPassword()
	{
		return $this->GetRawForm(FormKeys::CURRENT_PASSWORD);
	}

	public function GetPassword()
	{
		return $this->GetRawForm(FormKeys::PASSWORD);
	}

	public function GetPasswordConfirmation()
	{
		return $this->GetRawForm(FormKeys::PASSWORD_CONFIRM);
	}

	public function ResettingPassword()
	{
		$x = $this->GetForm(Actions::CHANGE_PASSWORD);

		return !empty($x);
	}

	public function ShowResetPasswordSuccess($resetPasswordSuccess)
	{
		$this->Set('ResetPasswordSuccess', $resetPasswordSuccess);
	}
}

?>