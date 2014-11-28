<?php
 

interface IReservationInitializerFactory
{
	/**
	 * @param INewReservationPage $page
	 * @return IReservationInitializer
	 */
	public function GetNewInitializer(INewReservationPage $page);

	/**
	 * @param IExistingReservationPage $page
	 * @param ReservationView $reservationView
	 * @return IReservationInitializer
	 */
	public function GetExisitingInitializer(IExistingReservationPage $page, ReservationView $reservationView);
}

?>