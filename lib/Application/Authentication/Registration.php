<?php

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationEvents.php');

class Registration implements IRegistration
{
	/**
	 * @var PasswordEncryption
	 */
	private $_passwordEncryption;

	/**
	 * @var IUserRepository
	 */
	private $_userRepository;

	public function __construct($passwordEncryption = null, $userRepository = null)
	{
		$this->_passwordEncryption = $passwordEncryption;
		$this->_userRepository = $userRepository;

		if ($passwordEncryption == null)
		{
			$this->_passwordEncryption = new PasswordEncryption();
		}

		if ($userRepository == null)
		{
			$this->_userRepository = new UserRepository();
		}
	}

	public function Register($username, $email, $firstName, $lastName, $password, $timezone, $language,
							 $homepageId, $additionalFields = array(), $attributeValues = array(), $phone=NULL)
	{
		$encryptedPassword = $this->_passwordEncryption->EncryptPassword($password);

		$attributes = new UserAttribute($additionalFields);

		if ($this->CreatePending())
		{
			$user = User::CreatePending($firstName, $lastName, $email, $username, $language, $timezone, $encryptedPassword->EncryptedPassword(), $encryptedPassword->Salt(), $homepageId);
		}
		else
		{
			$user = User::Create($firstName, $lastName, $email, $username, $language, $timezone, $encryptedPassword->EncryptedPassword(), $encryptedPassword->Salt(), $homepageId, $phone);
		}
		$user->ChangeAttributes($attributes->Get(UserAttribute::Phone), $attributes->Get(UserAttribute::Organization), $attributes->Get(UserAttribute::Position));
		$user->ChangeCustomAttributes($attributeValues);

		if (Configuration::Instance()->GetKey(ConfigKeys::REGISTRATION_AUTO_SUBSCRIBE_EMAIL, new BooleanConverter()))
		{
			foreach (ReservationEvent::AllEvents() as $event)
			{
				$user->ChangeEmailPreference($event, true);
			}
		}

		$userId = $this->_userRepository->Add($user);
		$this->AutoAssignPermissions($userId);

		return $user;
	}

	/**
	 * @return bool
	 */
	protected function CreatePending()
	{
		return Configuration::Instance()->GetKey(ConfigKeys::REGISTRATION_REQUIRE_ACTIVATION, new BooleanConverter());
	}

	public function UserExists($loginName, $emailAddress)
	{
		$userId = $this->_userRepository->UserExists($emailAddress, $loginName);

		return !empty($userId);
	}

	public function Synchronize(AuthenticatedUser $user)
	{
		if ($this->UserExists($user->UserName(), $user->Email()))
		{
			$encryptedPassword = $this->_passwordEncryption->EncryptPassword($user->Password());
			$command = new UpdateUserFromLdapCommand($user->UserName(), $user->Email(), $user->FirstName(), $user->LastName(), $encryptedPassword->EncryptedPassword(), $encryptedPassword->Salt(), $user->Phone(), $user->Organization(), $user->Title());

			ServiceLocator::GetDatabase()->Execute($command);
		}
		else
		{
			$additionalFields = array('phone' => $user->Phone(), 'organization' => $user->Organization(), 'position' => $user->Title());
			$this->Register($user->UserName(), $user->Email(), $user->FirstName(), $user->LastName(), $user->Password(),
							$user->TimezoneName(),
							$user->LanguageCode(),
							Pages::DEFAULT_HOMEPAGE_ID,
							$additionalFields);
		}
	}

	private function AutoAssignPermissions($userId)
	{
		$autoAssignCommand = new AutoAssignPermissionsCommand($userId);
		ServiceLocator::GetDatabase()->Execute($autoAssignCommand);
	}
}

class AdminRegistration extends Registration
{
	protected function CreatePending()
	{
		return false;
	}
}

?>