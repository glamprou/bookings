<?php

require_once(ROOT_DIR . 'lib/WebService/namespace.php');
require_once(ROOT_DIR . 'WebServices/Controllers/UserSaveController.php');
require_once(ROOT_DIR . 'WebServices/Requests/CreateUserRequest.php');
require_once(ROOT_DIR . 'WebServices/Requests/UpdateUserRequest.php');
require_once(ROOT_DIR . 'WebServices/Responses/UserCreatedResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/UserUpdatedResponse.php');

class UsersWriteWebService
{
	/**
	 * @var IRestServer
	 */
	private $server;

	/**
	 * @var IUserSaveController
	 */
	private $controller;

	public function __construct(IRestServer $server, IUserSaveController $controller)
	{
		$this->server = $server;
		$this->controller = $controller;
	}

	/**
	 * @name CreateUser
	 * @description Creates a new user
	 * @request CreateUserRequest
	 * @response UserCreatedResponse
	 * @return void
	 */
	public function Create()
	{
		/** @var $request CreateUserRequest */
		$request = new CreateUserRequest($this->server->GetRequest());

		Log::Debug('UsersWriteWebService.Create() User=%s', $this->server->GetSession()->UserId);

		$result = $this->controller->Create($request, $this->server->GetSession());

		if ($result->WasSuccessful())
		{
			Log::Debug('UsersWriteWebService.Create() - User Created. Created UserId=%s',
					   $result->UserId());

			$this->server->WriteResponse(new UserCreatedResponse($this->server, $result->UserId()),
										 RestResponse::CREATED_CODE);
		}
		else
		{
			Log::Debug('UsersWriteWebService.Create() - User Create Failed.');

			$this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()),
										 RestResponse::BAD_REQUEST_CODE);
		}
	}

	/**
	 * @name UpdateUser
	 * @description Updates an existing user
	 * @request UpdateUserRequest
	 * @response UserUpdatedResponse
	 * @param $userId
	 * @return void
	 */
	public function Update($userId)
	{
		/** @var $request UpdateUserRequest */
		$request = new UpdateUserRequest($this->server->GetRequest());

		Log::Debug('UsersWriteWebService.Update() User=%s', $this->server->GetSession()->UserId);

		$result = $this->controller->Update($userId, $request, $this->server->GetSession());

		if ($result->WasSuccessful())
		{
			Log::Debug('UsersWriteWebService.Update() - User Updated. UserId=%s',
					   $result->UserId());

			$this->server->WriteResponse(new UserUpdatedResponse($this->server, $result->UserId()),
										 RestResponse::OK_CODE);
		}
		else
		{
			Log::Debug('UsersWriteWebService.Create() - User Update Failed.');

			$this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()),
										 RestResponse::BAD_REQUEST_CODE);
		}
	}

	/**
	 * @name DeleteUser
	 * @description Deletes an existing user
	 * @response DeletedResponse
	 * @param int $userId
	 * @return void
	 */
	public function Delete($userId)
	{
		Log::Debug('UsersWriteWebService.Delete() User=%s', $this->server->GetSession()->UserId);

		$result = $this->controller->Delete($userId, $this->server->GetSession());

		if ($result->WasSuccessful())
		{
			Log::Debug('UsersWriteWebService.Delete() - User Deleted. UserId=%s',
					   $result->UserId());

			$this->server->WriteResponse(new DeletedResponse(), RestResponse::OK_CODE);
		}
		else
		{
			Log::Debug('UsersWriteWebService.Delete() - User Delete Failed.');

			$this->server->WriteResponse(new FailedResponse($this->server, $result->Errors()),
										 RestResponse::BAD_REQUEST_CODE);
		}
	}
}

?>