<?php
 

require_once(ROOT_DIR . 'lib/Email/namespace.php');

class InsertCallDateEmail extends EmailMessage
{
	/**
	 * @var User
	 */
	private $user;
	private $caller;
	public function __construct(User $user,User $caller)
	{
		$this->user = $user;
		$this->caller = $caller;
		parent::__construct($user->Language());
	}

	/**
	 * @return array|EmailAddress[]|EmailAddress
	 */
	function To()
	{
		return new EmailAddress($this->user->EmailAddress(), $this->user->FullName());
	}

	/**
	 * @return string
	 */
	function Subject()
	{
		return $this->Translate('InsertCallDate');
	}

	/**
	 * @return string
	 */
	function Body()
	{
		
		$this->Set('FirstName', $this->user->FirstName());
		$this->Set('EmailAddress', $this->user->EmailAddress());
		$this->Set('caller', $this->caller->FirstName()." ".$this->caller->LastName());
		$this->Set('callerEmailAddress', $this->caller->EmailAddress());
		$activationUrl = new Url(Configuration::Instance()->GetScriptUrl());
		$activationUrl->Add(Pages::CALLS);
		$this->Set('link', $activationUrl);
		return $this->FetchTemplate('InsertCallDate.tpl');
	}
}
?>