<?php

class UserSession
{
	public $UserId = '';
	public $FirstName = '';
	public $LastName = '';
	public $Email = '';
	public $Timezone = '';
	public $HomepageId = 1;
	public $IsAdmin = false;
	public $IsGroupAdmin = false;
	public $IsResourceAdmin = false;
	public $IsScheduleAdmin = false;
	public $LanguageCode = '';
	public $PublicId = '';
	public $LoginTime = '';
	public $ScheduleId = '';
	public $IsCoach = false;
	public $IsGuest = false;
	
	public function __construct($id)
	{
		$this->UserId = $id;
	}
	
	public function IsLoggedIn()
	{
		return true;
	}

	public function IsCoach()
	{
		$row=pdoq("select gr.coaches as isCoach from groups gr inner join user_groups ug on gr.group_id = ug.group_id where ug.user_id=?", $this->UserId);

        if($row && $row[0]->isCoach){
			$this->IsCoach = true;
			return true;
		}
		
		return false;
	}

	public function IsGuest()
	{
        $row=pdoq("select gr.guests as isGuest from groups gr inner join user_groups ug on gr.group_id = ug.group_id where ug.user_id=?", $this->UserId);
        if($row && $row[0]->isGuest){
            $this->IsGuest = true;
            return true;
        }
		
		return false;
	}
}

class NullUserSession extends UserSession
{
	public function __construct()
	{
		parent::__construct(0);
		$this->SessionToken = '';
		$this->Timezone = Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE);
	}
	
	public function IsLoggedIn()
	{
		return false;
	}
}
?>