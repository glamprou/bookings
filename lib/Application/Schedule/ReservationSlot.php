<?php

require_once(ROOT_DIR . 'lib/Application/Schedule/SlotLabelFactory.php');

class ReservationSlot implements IReservationSlot
{
	/**
	 * @var Date
	 */
	protected $_begin;

	/**
	 * @var Date
	 */
	protected $_end;

	/**
	 * @var Date
	 */
	protected $_displayDate;

	/**
	 * @var int
	 */
	protected $_periodSpan;

	/**
	 * @var ReservationItemView
	 */
	private $_reservation;

	/**
	 * @var string
	 */
	protected $_beginSlotId;

	/**
	 * @var string
	 */
	protected $_endSlotId;
	
	public $num_of_players;

	/**
	 * @param SchedulePeriod $begin
	 * @param SchedulePeriod $end
	 * @param Date $displayDate
	 * @param int $periodSpan
	 * @param ReservationItemView $reservation
	 */
	public function __construct(SchedulePeriod $begin, SchedulePeriod $end, Date $displayDate, $periodSpan,
								ReservationItemView $reservation)
	{
		$this->_reservation = $reservation;
		$this->_begin = $begin->BeginDate();
		$this->_displayDate = $displayDate;
		$this->_end = $end->EndDate();
		$this->_periodSpan = $periodSpan;

		$this->_beginSlotId = $begin->Id();
		$this->_endSlotId = $end->Id();
		
		
		//apothikefsi arithmou simmetexontwn		
		$rows=pdoq("select count(user_id) as total from reservation_users where reservation_instance_id=?",$reservation->ReservationId);
		if($rows && ($rows[0]->total>2 || isTraining($reservation->SeriesId))){
            if(!isTraining($reservation->SeriesId)){
                $this->num_of_players='('.$rows[0]->total.')';
            }
            else{
                $this->num_of_players='('. --$rows[0]->total.')';
            }
        }
		else{
            $this->num_of_players='';
        }
		//telos apothikefsis
	}

	/**
	 * @return Time
	 */
	public function Begin()
	{
		return $this->_begin->GetTime();
	}

	/**
	 * @return Date
	 */
	public function BeginDate()
	{
		return $this->_begin;
	}

	/**
	 * @return Time
	 */
	public function End()
	{
		return $this->_end->GetTime();
	}

	/**
	 * @return Date
	 */
	public function EndDate()
	{
		return $this->_end;
	}

	/**
	 * @return Date
	 */
	public function Date()
	{
		return $this->_displayDate;
	}

	/**
	 * @return int
	 */
	public function PeriodSpan()
	{
		return $this->_periodSpan;
	}

	public function Label($factory = null)
	{
		if (empty($factory))
		{
			return SlotLabelFactory::Create($this->_reservation);
		}
		return $factory->Format($this->_reservation);
	}

	public function IsReservable()
	{
		return false;
	}

	public function IsReserved()
	{
		return true;
	}

	public function IsPending()
	{
		return $this->_reservation->RequiresApproval;
	}

	public function IsPastDate(Date $date, $resource)
	{
		return $this->_displayDate->SetTime($this->Begin())->LessThan($date);
	}

	public function ToTimezone($timezone)
	{
		return new ReservationSlot($this->BeginDate()->ToTimezone($timezone), $this->EndDate()->ToTimezone($timezone), $this->Date(), $this->PeriodSpan(), $this->_reservation);
	}

	public function Id()
	{
		return $this->_reservation->ReferenceNumber;
	}

	public function IsOwnedBy(UserSession $user)
	{
		return $this->_reservation->UserId == $user->UserId;
	}

	public function IsParticipating(UserSession $session)
	{
		return $this->_reservation->IsUserParticipating($session->UserId) || $this->_reservation->IsUserInvited($session->UserId);
	}

	public function __toString()
	{
		return sprintf("Start: %s, End: %s, Span: %s", $this->Begin(), $this->End(), $this->PeriodSpan());
	}

	/**
	 * @return string
	 */
	public function BeginSlotId()
	{
		return $this->_beginSlotId;
	}

	/**
	 * @return string
	 */
	public function EndSlotId()
	{
		return $this->_beginSlotId;
	}
    
    /**
     * true if current slot is game, false if not
     * @return boolean
     */
    public function isGame() {
        $exists=pdoq("select * from r_calls where reference_number=?",$this->Id());
        if($exists)
            return TRUE;
        
        return FALSE;
    }

    /**
     * epistrefei true an i kratisi einai plirwmeni KAI
     * einai o admin, ara emfanisi me allo xrwma. Diaforetika epistrefei false
     * @return boolean
     */
    public function diplayAsPaid() {
        $userSession=ServiceLocator::GetServer()->GetUserSession();
        if($userSession->IsAdmin){
            $exists=pdoq("select ca.attribute_value from custom_attribute_values ca inner join reservation_instances ri on ri.series_id=ca.entity_id where custom_attribute_id=6 and ri.reference_number=?",$this->Id());
            if($exists && $exists[0]->attribute_value==1){
                return TRUE;
            }
        }

        return FALSE;
    }
}

?>