<?php

class ReservationListItem
{
	/**
	 * @var IReservedItemView
	 */
	protected $item;
	
	public function __construct(IReservedItemView $reservedItem)
	{
		$this->item = $reservedItem;
	}

	/**
	 * @return Date
	 */
	public function StartDate()
	{
		return $this->item->GetStartDate();
	}

	/**
	 * @return Date
	 */
	public function EndDate()
	{
		return $this->item->GetEndDate();
	}

	public function OccursOn(Date $date)
	{
		return $this->item->OccursOn($date);
	}

	/**
	 * @param SchedulePeriod $start
	 * @param SchedulePeriod $end
	 * @param Date $displayDate
	 * @param int $span
	 * @return IReservationSlot
	 */
	public function BuildSlot(SchedulePeriod $start, SchedulePeriod $end, Date $displayDate, $span)
	{
		return new ReservationSlot($start, $end, $displayDate, $span, $this->item);
	}

	/**
	 * @return int
	 */
	public function ResourceId()
	{
		return $this->item->GetResourceId();
	}

	/**
	 * @return int
	 */
	public function Id()
	{
		return $this->item->GetId();
	}
}

class BlackoutListItem extends ReservationListItem
{
	/**
	 * @param SchedulePeriod $start
	 * @param SchedulePeriod $end
	 * @param Date $displayDate
	 * @param int $span
	 * @return IReservationSlot
	 */
	public function BuildSlot(SchedulePeriod $start, SchedulePeriod $end, Date $displayDate, $span)
	{
		return new BlackoutSlot($start, $end, $displayDate, $span, $this->item);
	}
}
?>