<?php
 

require_once(ROOT_DIR . 'lib/Email/namespace.php');

class DeleteAceGameReservationInformEmail extends EmailMessage
{
	/**
	 * @var User
	 */
	private $user;
	private $other;
	public function __construct(User $user,User $other)
	{
		$this->user = $user;
		$this->other = $other;
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
		return $this->Translate('DeleteAceGameReservationInform');
	}

	/**
	 * @return string
	 */
	function Body()
	{
		$this->Set('FirstName', $this->user->FirstName());
		$this->Set('EmailAddress', $this->user->EmailAddress());
		$this->Set('other', $this->other->FirstName()." ".$this->other->LastName());
		$this->Set('otherEmailAddress', $this->other->EmailAddress());
		$activationUrl = new Url(Configuration::Instance()->GetScriptUrl());
		$activationUrl->Add(Pages::CALLS);
		$this->Set('link', $activationUrl);
		return $this->FetchTemplate('DeleteAceGameReservationInform.tpl');
	}
}
?>