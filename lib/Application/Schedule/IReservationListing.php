<?php

interface IDateReservationListing extends IResourceReservationListing
{
	/**
	 * @param int $resourceId
	 * @return IResourceReservationListing
	 */
	public function ForResource($resourceId);
}

interface IResourceReservationListing
{
	/**
	 * @return int
	 */
	public function Count();
	
	/**
	 * @return array|ReservationListItem[]
	 */
	public function Reservations();
}

interface IReservationListing extends IResourceReservationListing
{
	/**
	 * @param Date $date
	 * @return IReservationListing
	 */
	public function OnDate($date);

	/**
	 * @param int $resourceId
	 * @return IReservationListing
	 */
	public function ForResource($resourceId);

	/**
	 * @abstract
	 * @param Date $date
	 * @param int $resourceId
	 * @return array|ReservationListItem[]
	 */
	public function OnDateForResource(Date $date, $resourceId);
}

interface IMutableReservationListing extends IReservationListing
{
	/**
	 * @abstract
	 * @param ReservationItemView $reservation
	 * @return void
	 */
	public function Add($reservation);

	/**
	 * @abstract
	 * @param BlackoutItemView $blackout
	 * @return void
	 */
	public function AddBlackout($blackout);
}
?>