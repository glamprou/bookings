<?php
 

require_once(ROOT_DIR . 'lib/Email/namespace.php');

class CallDeclinedEmail extends EmailMessage
{
	/**
	 * @var User
	 */
	private $user;

	/**
	 * @var string
	 */
	private $caller;
	private $morethanthreematches;

	public function __construct(User $user, User $caller, $morethanthreematches=false)
	{
		$this->user = $user;
		$this->caller = $caller;
		$this->morethanthreematches = $morethanthreematches;
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
		return $this->Translate('CallDeclined');
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
		
		$link=mysql_connect("localhost", $conf['settings']['database']['user'], $conf['settings']['database']['password']);
		mysql_select_db($conf['settings']['database']['name']);
		
		$tmpres=mysql_query("select numAGFreeDecl from r_options");
		$tmprow=mysql_fetch_object($tmpres);
		$numofmatchesforfreedecl=$tmprow->numAGFreeDecl;
		
		$this->Set('numofmatchesforfreedecl', $numofmatchesforfreedecl);
		
		if($this->morethanthreematches){
			return $this->FetchTemplate('CallDeclined_morethanthreematches.tpl');
		}
		else{
			return $this->FetchTemplate('CallDeclined.tpl');
		}
	}
}
?>