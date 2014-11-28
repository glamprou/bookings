<?php

class BlackoutSlot implements IReservationSlot
{
	/**
	 * @var Date
	 */
	protected $begin;

	/**
	 * @var Date
	 */
	protected $end;

	/**
	 * @var Date
	 */
	protected $displayDate;

	/**
	 * @var int
	 */
	protected $periodSpan;

	/**
	 * @var BlackoutItemView
	 */
	private $blackout;

	/**
	 * @var string
	 */
	protected $beginSlotId;

	/**
	 * @var string
	 */
	protected $endSlotId;

	/**
	 * @param SchedulePeriod $begin
	 * @param SchedulePeriod $end
	 * @param Date $displayDate
	 * @param int $periodSpan
	 * @param BlackoutItemView $blackout
	 */
	public function __construct(SchedulePeriod $begin, SchedulePeriod $end, Date $displayDate, $periodSpan, BlackoutItemView $blackout)
	{
		$this->blackout = $blackout;
		$this->begin = $begin->BeginDate();
		$this->displayDate = $displayDate;
		$this->end = $end->EndDate();
		$this->periodSpan = $periodSpan;
		$this->beginSlotId = $begin->Id();
		$this->endSlotId = $end->Id();
	}
	
	/**
	 * @return Time
	 */
	public function Begin()
	{
		return $this->begin->GetTime();
	}

	/**
	 * @return Date
	 */
	public function BeginDate()
	{
		return $this->begin;
	}

	/**
	 * @return Time
	 */
	public function End()
	{
		return $this->end->GetTime();
	}

	/**
	 * @return Date
	 */
	public function EndDate()
	{
		return $this->end;
	}

	/**
	 * @return Date
	 */
	public function Date()
	{
		return $this->displayDate;
	}

	/**
	 * @return int
	 */
	public function PeriodSpan()
	{
		return $this->periodSpan;
	}

	/**
	 * @return string
	 */
	public function Label()
	{
		return $this->blackout->Title;
	}

	public function IsReservable()
	{
		return false;
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
		return $this->displayDate->SetTime($this->Begin())->LessThan($date);
	}

	public function ToTimezone($timezone)
	{
		return new BlackoutSlot($this->BeginDate()->ToTimezone($timezone), $this->EndDate()->ToTimezone($timezone), $this->Date(), $this->PeriodSpan(), $this->blackout);
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
		return $this->beginSlotId;
	}

	public function EndSlotId()
	{
		return $this->endSlotId;
	}
}
?>