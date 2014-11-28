<?php
 

require_once(ROOT_DIR . 'lib/Email/namespace.php');

class InsertCallDateInformEmail extends EmailMessage
{
	/**
	 * @var User
	 */
	private $user;
	private $caller;
	private $match_date;
	private $match_time;
	public function __construct(User $user,User $caller,$date,$time='')
	{
		$this->user = $user;
		$this->caller = $caller;
		$this->match_date = $date;
		$this->match_time = $time;
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
		return $this->Translate('InsertCallDateInform');
	}

	/**
	 * @return string
	 */
	function Body()
	{
		$newarr=explode('-',$this->match_date);
		
		$this->Set('FirstName', $this->user->FirstName());
		$this->Set('EmailAddress', $this->user->EmailAddress());
		$this->Set('date', $newarr[2]."-".$newarr[1]."-".$newarr[0]);
		$this->Set('time', $this->match_time);
		$this->Set('caller', $this->caller->FirstName()." ".$this->caller->LastName());
		$this->Set('callerEmailAddress', $this->caller->EmailAddress());
		$activationUrl = new Url(Configuration::Instance()->GetScriptUrl());
		$activationUrl->Add(Pages::CALLS);
		$this->Set('link', $activationUrl);
		return $this->FetchTemplate('InsertCallDateInform.tpl');
	}
}
?>