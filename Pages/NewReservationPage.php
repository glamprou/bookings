<?php

require_once(ROOT_DIR . 'Pages/ReservationPage.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationPresenter.php');

interface INewReservationPage extends IReservationPage
{
	public function GetRequestedResourceId();
	
	public function GetRequestedScheduleId();
	
	/**
	 * @return Date
	 */
	public function GetReservationDate();
	
	/**
	 * @return Date
	 */
	public function GetStartDate();
	
	/**
	 * @return Date
	 */
	public function GetEndDate();
}

class NewReservationPage extends ReservationPage implements INewReservationPage
{
	public function __construct()
	{
		parent::__construct('CreateReservation');

		$this->SetParticipants(array());
		$this->SetInvitees(array());

        $this->handleOpenResCheckboxVisibility();
	}
	
	protected function GetPresenter()
	{
		return new ReservationPresenter(
			$this, 
			$this->initializationFactory,
			new NewReservationPreconditionService());
	}

	protected function GetTemplateName()
	{
		return 'Reservation/create.tpl';
	}
	
	protected function GetReservationAction()
	{
		return ReservationAction::Create;
	}
	
	public function GetRequestedResourceId()
	{
		return $this->server->GetQuerystring(QueryStringKeys::RESOURCE_ID);
	}
	
	public function GetRequestedScheduleId()
	{
		return $this->server->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
	}
	
	public function GetReservationDate()
	{
		$timezone = ServiceLocator::GetServer()->GetUserSession()->Timezone;
		$dateTimeString = $this->server->GetQuerystring(QueryStringKeys::RESERVATION_DATE);

		if (empty($dateTimeString))
		{
			return null;
		}
		return new Date($dateTimeString, $timezone);
	}
	
	public function GetStartDate()
	{
		$timezone = ServiceLocator::GetServer()->GetUserSession()->Timezone;
		$dateTimeString = $this->server->GetQuerystring(QueryStringKeys::START_DATE);

		if (empty($dateTimeString))
		{
			return null;
		}
		return new Date($dateTimeString, $timezone);
	}
	
	public function GetEndDate()
	{
		$timezone = ServiceLocator::GetServer()->GetUserSession()->Timezone;
		$dateTimeString = $this->server->GetQuerystring(QueryStringKeys::END_DATE);

		if (empty($dateTimeString))
		{
			return null;
		}
		return new Date($dateTimeString, $timezone);
	}
    
    public function handleCallSelection(){
        $userid=ServiceLocator::GetServer()->GetUserSession()->UserId;
        
        $calls=pdoq("select ca.call_id as callid, CONCAT(us.fname, ' ', us.lname) as opponent_name, us.user_id as opponent_id  from r_calls ca inner join users us on (ca.caller_user_id=us.user_id or ca.callee_user_id=us.user_id) where call_accepted=1 and match_date IS NULL and (ca.caller_user_id=? or ca.callee_user_id=?) and us.user_id!=? order by call_date asc", array($userid,$userid,$userid));
        if($calls){
            $this->Set('calls', $calls);
            if(isset($_GET['call'])){
                $defaultCall=pdoq("select call_id from r_calls where call_id=? and call_accepted=1 and match_date IS NULL and (caller_user_id=? OR callee_user_id=?)",array((int)$_GET['call'],$userid,$userid));
                if($defaultCall){
                    $this->Set('defCall', $defaultCall[0]->call_id);
                }
            }
        }
    }

    /**
     * Ean admin or twra einai prin tis 12 to mesimeri tin proigoumeni imera tis kratisis,
     * emfanizei to checkbox gia to ean i kratisi einai typou psaxnw paikti
     */
    public function handleOpenResCheckboxVisibility(){
        $visible=false;
        if(ServiceLocator::GetServer()->GetUserSession()->IsAdmin){//if admin always visible
            $visible=true;
        }

        $now = new Date('Europe/Athens');

        if(!$now->GreaterThan($this->GetStartDate()->ToTimezone('Europe/Athens')->RemoveMinutes(60*24)->SetTimeString('12:00:00'))){
            $visible=true;
        }

        if($visible){
            $this->Set('openResCheckBoxVisible',true);
        }
    }
}
?>