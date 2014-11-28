<?php

require_once(ROOT_DIR . 'Domain/Values/ReservationStartTimeConstraint.php');

class EmptyReservationSlot implements IReservationSlot
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
	protected $_date;

	/**
	 * @var $_isReservable
	 */
	protected $_isReservable;

	/**
	 * @var int
	 */
	protected $_periodSpan;

	protected $_beginDisplayTime;
	protected $_endDisplayTime;

	protected $_beginSlotId;
	protected $_endSlotId;

	public function __construct(SchedulePeriod $begin, SchedulePeriod $end, Date $displayDate, $isReservable)
	{
		$this->_begin = $begin->BeginDate();
		$this->_end = $end->EndDate();
		$this->_date = $displayDate;
		$this->_isReservable = $isReservable;

		$this->_beginDisplayTime = $this->_begin->GetTime();
		if (!$this->_begin->DateEquals($displayDate))
		{
			$this->_beginDisplayTime = $displayDate->GetDate()->GetTime();
		}

		$this->_endDisplayTime = $this->_end->GetTime();
		if (!$this->_end->DateEquals($displayDate))
		{
			$this->_endDisplayTime = $displayDate->GetDate()->GetTime();
		}

		$this->_beginSlotId = $begin->Id();
		$this->_endSlotId = $end->Id();
	}

	/**
	 * @return Time
	 */
	public function Begin()
	{
		return $this->_beginDisplayTime;
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
		return $this->_endDisplayTime;
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
		return $this->_date;
	}

	/**
	 * @return int
	 */
	public function PeriodSpan()
	{
		return 1;
	}

	public function Label()
	{
		return '';
	}

	public function IsReservable()
	{
		return $this->_isReservable;
	}

	public function IsReserved()
	{
		return false;
	}

	public function IsPending()
	{
		return false;
	}

	public function IsPastDate(Date $date, $resource)
	{ 
		$constraint = Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION,
															   ConfigKeys::RESERVATION_START_TIME_CONSTRAINT);
		
		//ypologismos diathesimwn slots analogws me to an iparxei orio, px no more than 2 days from now..
		$rows=pdoq("select max_notice_time from resources where resource_id=?",$resource->GetId());
		
		if (empty($constraint))
		{
			$constraint = ReservationStartTimeConstraint::_DEFAULT;
		}

		if ($constraint == ReservationStartTimeConstraint::NONE)
		{
			return false;
		}

		if ($constraint == ReservationStartTimeConstraint::CURRENT)
		{
			if($rows[0]->max_notice_time>0){
				$endTimeUTC=new Date(date("Y-m-d H:i:s",strtotime("+".$rows[0]->max_notice_time." seconds",strtotime($date))),'UTC');
				$userSession = ServiceLocator::GetServer()->GetUserSession();
				return $this->_date->SetTime($this->End(), true)->LessThan($date) || ($this->_date->SetTime($this->Begin())->GreaterThan($endTimeUTC->ToTimezone('Europe/Athens')) && !$userSession->IsCoach());
			}
			
			return $this->_date->SetTime($this->End(), true)->LessThan($date);
		}
		
		
		if($rows[0]->max_notice_time>0){
			$endTimeUTC=new Date(date("Y-m-d H:i:s",strtotime("+".$rows[0]->max_notice_time." seconds",strtotime($date))),'UTC');
			$userSession = ServiceLocator::GetServer()->GetUserSession();
			return $this->_date->SetTime($this->Begin())->LessThan($date) || ($this->_date->SetTime($this->Begin())->GreaterThan($endTimeUTC->ToTimezone('Europe/Athens')) && !$userSession->IsCoach());
		}
		//telos
		return $this->_date->SetTime($this->Begin())->LessThan($date);
	}

	public function ToTimezone($timezone)
	{
		return new EmptyReservationSlot($this->BeginDate()->ToTimezone($timezone), $this->End()->ToTimezone($timezone), $this->Date(), $this->_isReservable);
	}

	public function IsOwnedBy(UserSession $session)
	{
		return false;
	}

	public function IsParticipating(UserSession $session)
	{
		return false;
	}

	public function BeginSlotId()
	{
		return $this->_beginSlotId;
	}

	public function EndSlotId()
	{
		return $this->_endSlotId;
	}
}

?>