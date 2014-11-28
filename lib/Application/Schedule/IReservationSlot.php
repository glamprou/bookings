<?php

interface IReservationSlot
{
	/**
	 * @return Time
	 */
	public function Begin();
	
	/**
	 * @return Time
	 */
	public function End();
	
	/**
	 * @return Date
	 */
	public function BeginDate();
	
	/**
	 * @return Date
	 */
	public function EndDate();
	
	/**
	 * @return Date
	 */
	public function Date();
	
	/**
	 * @return int
	 *
	 */
	public function PeriodSpan();	
	
	/**
	 * @return string
	 */
	public function Label();
	
	/**
	 * @return bool
	 */
	public function IsReservable();
	
	/**
	 * @return bool
	 */
	public function IsReserved();

	/**
	 * @return bool
	 */
	public function IsPending();
	
	/**
	 * @param $date Date
	 * @return bool
	 */
	public function IsPastDate(Date $date, $resource);
	
	/**
	 * @param string $timezone
	 * @return IReservationSlot
	 */
	public function ToTimezone($timezone);

	/**
	 * @param UserSession $session
	 * @return bool
	 */
	public function IsOwnedBy(UserSession $session);

	/**
	 * @param UserSession $session
	 * @return bool
	 */
	public function IsParticipating(UserSession $session);

	/**
	 * @return string
	 */
	public function BeginSlotId();

	/**
	 * @return string
	 */
	public function EndSlotId();
}

?>