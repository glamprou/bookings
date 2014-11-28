<?php
 
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Pages/NewReservationPage.php');

class NewReservationPreconditionService implements INewReservationPreconditionService
{
	public function CheckAll(INewReservationPage $page, UserSession $user)
	{
		$requestedScheduleId = $page->GetRequestedScheduleId();
		
		if (empty($requestedScheduleId))
		{
			$page->RedirectToError(ErrorMessages::MISSING_SCHEDULE);
			return;
		}
	}
}

class EditReservationPreconditionService
{
	public function CheckAll(IExistingReservationPage $page, UserSession $user, ReservationView $reservationView)
	{
		if (!$reservationView->IsDisplayable())
		{
			$page->RedirectToError(ErrorMessages::RESERVATION_NOT_FOUND);
			return;
		}
	}
}

abstract class ReservationPreconditionService implements IReservationPreconditionService
{
}
?>