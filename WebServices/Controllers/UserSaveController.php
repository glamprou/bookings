<?php

require_once(ROOT_DIR . 'WebServices/Requests/CreateUserRequest.php');
require_once(ROOT_DIR . 'WebServices/Requests/UpdateUserRequest.php');
require_once(ROOT_DIR . 'WebServices/Validators/UserRequestValidator.php');
require_once(ROOT_DIR . 'lib/Application/User/namespace.php');

interface IUserSaveController
{
	/**
	 * @param CreateUserRequest $request
	 * @param WebServiceUserSession $session
	 * @return UserControllerResult
	 */
	public function Create($request, $session);

	/**
	 * @param $userId
	 * @param UpdateUserRequest $request
	 * @param WebServiceUserSession $session
	 * @return UserControllerResult
	 */
	public function Update($userId, $request, $session);

	/**
	 * @param $userId
	 * @param WebServiceUserSession $session
	 * @return UserControllerResult
	 */
	public function Delete($userId, $session);
}

class UserSaveController implements IUserSaveController
{
	/**
	 * @var IManageUsersServiceFactory
	 */
	private $serviceFactory;

	/**
	 * @var IUserRequestValidator
	 */
	private $requestValidator;

	public function __construct(IManageUsersServiceFactory $serviceFactory, IUserRequestValidator $requestValidator)
	{
		$this->serviceFactory = $serviceFactory;
		$this->requestValidator = $requestValidator;
	}

	/**
	 * @param CreateUserRequest $request
	 * @param WebServiceUserSession $session
	 * @return UserControllerResult
	 */
	public function Create($request, $session)
	{
		$errors = $this->requestValidator->ValidateCreateRequest($request);

		if (!empty($errors))
		{
			return new UserControllerResult(null, $errors);
		}

		$userService = $this->serviceFactory->CreateAdmin();

		$extraAttributes = array(UserAttribute::Phone => $request->phone, UserAttribute::Organization => $request->organization, UserAttribute::Position => $request->position);
		$customAttributes = array();
		foreach ($request->GetCustomAttributes() as $attribute)
		{
			$customAttributes[] = new AttributeValue($attribute->attributeId, $attribute->attributeValue);
		}

		$userId = $userService->AddUser($request->userName, $request->emailAddress, $request->firstName,
										$request->lastName, $request->password, $request->timezone, $request->language,
										Pages::DEFAULT_HOMEPAGE_ID, $extraAttributes, $customAttributes);

		return new UserControllerResult($userId);
	}

	/**
	 * @param int $userId
	 * @param UpdateUserRequest $request
	 * @param WebServiceUserSession $session
	 * @return UserControllerResult
	 */
	public function Update($userId, $request, $session)
	{
		$errors = $this->requestValidator->ValidateUpdateRequest($userId, $request);

		if (!empty($errors))
		{
			return new UserControllerResult(null, $errors);
		}

		$userService = $this->serviceFactory->CreateAdmin();

		$extraAttributes = array(UserAttribute::Phone => $request->phone, UserAttribute::Organization => $request->organization, UserAttribute::Position => $request->position);
		$customAttributes = array();
		foreach ($request->GetCustomAttributes() as $attribute)
		{
			$customAttributes[] = new AttributeValue($attribute->attributeId, $attribute->attributeValue);
		}

		$userService->UpdateUser($userId, $request->userName, $request->emailAddress, $request->firstName,
								 $request->lastName, $request->timezone, $extraAttributes);

		$userService->ChangeAttributes($userId, $customAttributes);

		return new UserControllerResult($userId);
	}

	/**
	 * @param $userId
	 * @param WebServiceUserSession $session
	 * @return UserControllerResult
	 */
	public function Delete($userId, $session)
	{
		$userService = $this->serviceFactory->CreateAdmin();
		$userService->DeleteUser($userId);

		return new UserControllerResult($userId);
	}
}

class UserControllerResult
{
	/**
	 * @var int
	 */
	private $userId;

	/**
	 * @var array|string[]
	 */
	private $errors = array();

	/**
	 * @param int $userId
	 * @param array $errors
	 */
	public function __construct($userId, $errors = array())
	{
		$this->userId = $userId;
		$this->errors = $errors;
	}

	/**
	 * @return bool
	 */
	public function WasSuccessful()
	{
		return !empty($this->userId) && empty($this->errors);
	}

	/**
	 * @return int
	 */
	public function UserId()
	{
		return $this->userId;
	}

	/**
	 * @return array|string[]
	 */
	public function Errors()
	{
		return $this->errors;
	}
}


?>