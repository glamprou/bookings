<?php

interface IReservationValidationService
{
	/**
	 * @param ReservationSeries|ExistingReservationSeries $series
	 * @return IReservationValidationResult
	 */
	public function Validate($series);
}
?>