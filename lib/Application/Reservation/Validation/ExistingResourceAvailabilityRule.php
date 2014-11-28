<?php

class ExistingResourceAvailabilityRule extends ResourceAvailabilityRule implements IUpdateReservationValidationRule
{
	/**
	 * @param ReservationSeries|ExistingReservationSeries $series
	 * @return ReservationRuleResult
	 */
	public function Validate($series)
	{
		return parent::Validate($series);
	}

	/**
	 * @param Reservation $instance
	 * @param ReservationSeries|ExistingReservationSeries $series
	 * @param IReservedItemView $existingItem
	 * @return bool
	 */
	protected function IsInConflict(Reservation $instance, ReservationSeries $series, IReservedItemView $existingItem)
	{
		if ($existingItem->GetId() == $instance->ReservationId() ||
			$series->IsMarkedForDelete($existingItem->GetId()) ||
			$series->IsMarkedForUpdate($existingItem->GetId())
		)
		{
			return false;
		}
		
		return ($existingItem->GetResourceId() == $series->ResourceId()) ||
			(false !== array_search($existingItem->GetResourceId(), $series->AllResourceIds()));
	}
}
?>