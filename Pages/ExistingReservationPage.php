<?php

require_once(ROOT_DIR . 'Pages/ReservationPage.php');

interface IExistingReservationPage extends IReservationPage
{
	function GetReferenceNumber();

	/**
	 * @param $additionalResourceIds int[]
	 */
	function SetAdditionalResources($additionalResourceIds);

	/**
	 * @param $title string
	 */
	function SetTitle($title);

	/**
	 * @param $description string
	 */
	function SetDescription($description);

	/**
	 * @param $repeatType string
	 */
	function SetRepeatType($repeatType);

	/**
	 * @param $repeatInterval string
	 */
	function SetRepeatInterval($repeatInterval);

	/**
	 * @param $repeatMonthlyType string
	 */
	function SetRepeatMonthlyType($repeatMonthlyType);

	/**
	 * @param $repeatWeekdays int[]
	 */
	function SetRepeatWeekdays($repeatWeekdays);

	/**
	 * @param $referenceNumber string
	 */
	function SetReferenceNumber($referenceNumber);

	/**
	 * @param $reservationId int
	 */
	function SetReservationId($reservationId);

	/**
	 * @param $isRecurring bool
	 */
	function SetIsRecurring($isRecurring);

	/**
	 * @param $canBeEdited bool
	 */
	function SetIsEditable($canBeEdited);

	/**
	 * @abstract
	 * @param $canBeApproved bool
	 * @return void
	 */
	function SetIsApprovable($canBeApproved);

	/**
	 * @param $amIParticipating
	 */
	function SetCurrentUserParticipating($amIParticipating);

	/**
	 * @param $amIInvited
	 */
	function SetCurrentUserInvited($amIInvited);

	/**
	 * @param int $reminderValue
	 * @param ReservationReminderInterval $reminderInterval
	 */
	public function SetStartReminder($reminderValue, $reminderInterval);

	/**
	 * @param int $reminderValue
	 * @param ReservationReminderInterval $reminderInterval
	 */
	public function SetEndReminder($reminderValue, $reminderInterval);
}

class ExistingReservationPage extends ReservationPage implements IExistingReservationPage
{
	public $IsEditable = false;
	public $IsApprovable = false;

	public function __construct()
	{
		parent::__construct();
	}

	public function PageLoad()
	{
        $reference_number=$this->GetReferenceNumber();
        $reservation_repository=new ReservationRepository();
        $series=$reservation_repository->LoadByReferenceNumber($reference_number);

        if(isTraining($series->SeriesId())){
            $this->Set('checkisTrainingCheckbox', TRUE);
        }

        $this->Set('isCancelledTraining', isCancelledTraining($series->SeriesId()));

        if(isOpenRes($reference_number)){
            $this->Set('checkisOpenCheckbox', TRUE);
        }

        $this->Set('ownerPhone', "");

        $userSession=ServiceLocator::GetServer()->GetUserSession();
        if($userSession->IsAdmin){
            $row= pdoq("select us.phone
                        from reservation_instances ri
                        inner join reservation_series rs on ri.series_id=rs.series_id
                        inner join users us  on us.user_id=rs.owner_id
                        where ri.reference_number=?",$reference_number);
            if($row && !empty($row[0]->phone)){
                $this->Set('ownerPhone', $row[0]->phone);
            }
        }

        $this->handleOpenResCheckboxVisibility($series);

		parent::PageLoad();
	}

	protected function GetPresenter()
	{
		$preconditionService = new EditReservationPreconditionService($this->permissionServiceFactory);
		$reservationViewRepository = new ReservationViewRepository();

		return new EditReservationPresenter($this,
											$this->initializationFactory,
											$preconditionService,
											$reservationViewRepository);
	}

	protected function GetTemplateName()
	{

		if ($this->IsApprovable)
		{
			return 'Reservation/approve.tpl';
		}
		//elaxistos xronos enarksis tis kratisis apo twra, gia na einai 	
		$reference_number=$this->GetReferenceNumber();
		$reservation_repository=new ReservationRepository();
		$series=$reservation_repository->LoadByReferenceNumber($reference_number);
		$reservation=$series->GetInstance($reference_number);
		$user = ServiceLocator::GetServer()->GetUserSession();
		
		if ($this->IsEditable && (($reservation->StartDate()->ToTimezone(Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE))->Timestamp()-strtotime('now'))>sp_get_min_edit_time_seconds(true) || $user->IsAdmin))
		{
			return 'Reservation/edit.tpl';
		}
		return 'Reservation/view.tpl';
	}

	protected function GetReservationAction()
	{
		return ReservationAction::Update;
	}

	public function GetReferenceNumber()
	{
		return $this->server->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER);
	}

	public function SetAdditionalResources($additionalResourceIds)
	{
		$this->Set('AdditionalResourceIds', $additionalResourceIds);
	}

	public function SetTitle($title)
	{
		$this->Set('ReservationTitle', $title);
	}

	public function SetDescription($description)
	{
		$this->Set('Description', $description);
	}

	public function SetRepeatType($repeatType)
	{
		$this->Set('RepeatType', $repeatType);
	}

	public function SetRepeatInterval($repeatInterval)
	{
		$this->Set('RepeatInterval', $repeatInterval);
	}

	public function SetRepeatMonthlyType($repeatMonthlyType)
	{
		$this->Set('RepeatMonthlyType', $repeatMonthlyType);
	}

	public function SetRepeatWeekdays($repeatWeekdays)
	{
		$this->Set('RepeatWeekdays', $repeatWeekdays);
	}

	public function SetReferenceNumber($referenceNumber)
	{
		$this->Set('ReferenceNumber', $referenceNumber);
	}

	public function SetReservationId($reservationId)
	{
		$this->Set('ReservationId', $reservationId);
	}

	public function SetIsRecurring($isRecurring)
	{
		$this->Set('IsRecurring', $isRecurring);
	}

	public function SetIsEditable($canBeEdited)
	{
		$this->IsEditable = $canBeEdited;
	}

	/**
	 * @param $amIParticipating
	 */
	public function SetCurrentUserParticipating($amIParticipating)
	{
		$this->Set('IAmParticipating', $amIParticipating);
	}

	/**
	 * @param $amIInvited
	 */
	public function SetCurrentUserInvited($amIInvited)
	{
		$this->Set('IAmInvited', $amIInvited);
	}

	/**
	 * @param $canBeApproved bool
	 * @return void
	 */
	public function SetIsApprovable($canBeApproved)
	{
		$this->IsApprovable = $canBeApproved;
	}

	/**
	 * @param int $reminderValue
	 * @param ReservationReminderInterval $reminderInterval
	 */
	public function SetStartReminder($reminderValue, $reminderInterval)
	{
		$this->Set('ReminderTimeStart', $reminderValue);
		$this->Set('ReminderIntervalStart', $reminderInterval);
	}

	/**
	 * @param int $reminderValue
	 * @param ReservationReminderInterval $reminderInterval
	 */
	public function SetEndReminder($reminderValue, $reminderInterval)
	{
		$this->Set('ReminderTimeEnd', $reminderValue);
		$this->Set('ReminderIntervalEnd', $reminderInterval);
	}
    
    /**
     * Settarei to select box twn games
     */
    public function handleCallSelection(){
        $userid=ServiceLocator::GetServer()->GetUserSession()->UserId;
        $this->setOpenGames($userid);
        if($this->isGame()){
            $this->setCurrentGame($userid);
        }
    }
    
    /**
     * true if reservation is game, else false
     * @return boolean
     */
    public function isGame() {
        $rn=$this->GetReferenceNumber();
        $exists=pdoq('select call_id from r_calls where reference_number=?',$rn);

        return ($exists ? TRUE : FALSE);
    }
    /**
     * Settarei sto select box twn games ta anoixta games + to current game
     * @param int $userid
     */
    public function setOpenGames($userid) {
        $calls=pdoq("select ca.call_id as callid, CONCAT(us.fname, ' ', us.lname) as opponent_name, us.user_id as opponent_id  from r_calls ca inner join users us on (ca.caller_user_id=us.user_id or ca.callee_user_id=us.user_id) where ((call_accepted=1 and match_date IS NULL and (ca.caller_user_id=? or ca.callee_user_id=?)) or (ca.reference_number=?)) and us.user_id!=? order by call_date asc", array($userid,$userid,$this->GetReferenceNumber(),$userid));
        if($calls){
            $this->Set('calls', $calls);
        }
    }
    /**
     * Settarei ws checked sto select box twn games to sygkekrimeno (kleismeno) game
     * @param int $userid
     */
    public function setCurrentGame($userid) {
        $def=pdoq("select ca.call_id as callid, CONCAT(us.fname, ' ', us.lname) as opponent_name, us.user_id as opponent_id  from r_calls ca inner join users us on (ca.caller_user_id=us.user_id or ca.callee_user_id=us.user_id) where ca.reference_number=? and us.user_id!=? order by call_date asc", array($this->GetReferenceNumber(),$userid));
        if($def){
            $this->Set('defCall', $def[0]->callid);
        }
    }

    /**
     * Ean admin or twra einai prin tis 12 to mesimeri tin proigoumeni imera tis kratisis,
     * emfanizei to checkbox gia to ean i kratisi einai typou psaxnw paikti
     * @param ReservationSeries $series
     */
    public function handleOpenResCheckboxVisibility($series){
        $visible=false;
        if(ServiceLocator::GetServer()->GetUserSession()->IsAdmin){//if admin always visible
            $visible=true;
        }

        $now = new Date('Europe/Athens');

        if(!$now->GreaterThan($series->CurrentInstance()->StartDate()->ToTimezone('Europe/Athens')->RemoveMinutes(60*24)->SetTimeString('12:00:00'))){
            $visible=true;
        }

        if($visible){
            $this->Set('openResCheckBoxVisible',true);
        }
    }
}

?>