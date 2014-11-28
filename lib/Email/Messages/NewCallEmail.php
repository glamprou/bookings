<?php
 

require_once(ROOT_DIR . 'lib/Email/namespace.php');

class NewCallEmail extends EmailMessage
{
	/**
	 * @var User
	 */
	private $user;

	/**
	 * @var string
	 */
	private $caller;
	private $activation_code;

	public function __construct(User $user, User $caller, $activation_code)
	{
		$this->user = $user;
		$this->caller = $caller;
		$this->activation_code = $activation_code;
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
		return $this->Translate('YouHaveNewCall');
	}

	/**
	 * @return string
	 */
	function Body()
	{
		$AnswerUrl=Configuration::Instance()->GetScriptUrl()."/auto_call_answer.php?adcac=".$this->activation_code."&action=";
		
		$this->Set('FirstName', $this->user->FirstName());
		$this->Set('EmailAddress', $this->user->EmailAddress());
		$this->Set('caller', $this->caller->FirstName()." ".$this->caller->LastName());
		$this->Set('callerEmailAddress', $this->caller->EmailAddress());
		$this->Set('acceptCallUrl', $AnswerUrl.'1');
		$this->Set('declineCallUrl', $AnswerUrl.'0');
		$activationUrl = new Url(Configuration::Instance()->GetScriptUrl());
		$activationUrl->Add(Pages::CALLS);
		$this->Set('link', $activationUrl);
		return $this->FetchTemplate('YouHaveNewCall.tpl');
	}
}
?>