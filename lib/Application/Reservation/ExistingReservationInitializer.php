<?php

require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationInitializerBase.php');
require_once(ROOT_DIR . 'Pages/ExistingReservationPage.php');

class ExistingReservationInitializer extends ReservationInitializerBase implements IReservationComponentInitializer
{
	/**
	 * @var IExistingReservationPage
	 */
	private $page;
	
	/**
	 * @var ReservationView 
	 */
	private $reservationView;

	/**
	 * @var IExistingReservationComponentBinder
	 */
	private $reservationBinder;

	/**
	 * @param IExistingReservationPage $page
	 * @param IReservationComponentBinder $userBinder
	 * @param IReservationComponentBinder $dateBinder
	 * @param IReservationComponentBinder $resourceBinder
	 * @param IReservationComponentBinder $reservationBinder
	 * @param IReservationComponentBinder $attributeBinder
	 * @param ReservationView $reservationView
	 * @param UserSession $userSession
	 */
	public function __construct(
		IExistingReservationPage $page, 
		IReservationComponentBinder $userBinder,
		IReservationComponentBinder $dateBinder,
		IReservationComponentBinder $resourceBinder,
		IReservationComponentBinder $reservationBinder,
		IReservationComponentBinder $attributeBinder,
		ReservationView $reservationView,
		UserSession $userSession
		)
	{
		$this->page = $page;
		$this->reservationView = $reservationView;
		$this->reservationBinder = $reservationBinder;

		parent::__construct(
						$page, 
						$userBinder,
						$dateBinder,
						$resourceBinder,
						$attributeBinder,
						$userSession);
	}
	
	public function Initialize()
	{
		parent::Initialize();

		$this->reservationBinder->Bind($this, $this->page, $this->reservationView);
	}

	protected function SetSelectedDates(Date $startDate, Date $endDate, $startPeriods, $endPeriods)
	{
		$timezone = $this->GetTimezone();		
		$startDate = $this->reservationView->StartDate->ToTimezone($timezone);
		$endDate = $this->reservationView->EndDate->ToTimezone($timezone);

		parent::SetSelectedDates($startDate, $endDate, $startPeriods, $endPeriods);
	}
	
	public function GetOwnerId()
	{
		return $this->reservationView->OwnerId;
	}
	
	public function GetResourceId()
	{
		return $this->reservationView->ResourceId;
	}
	
	public function GetScheduleId()
	{
		return $this->reservationView->ScheduleId;
	}
	
	public function GetReservationDate()
	{
		return $this->reservationView->StartDate;
	}
	
	public function GetStartDate()
	{
		return $this->reservationView->StartDate;
	}
	
	public function GetEndDate()
	{
		return $this->reservationView->EndDate;
	}
	
	public function GetTimezone()
	{
		return ServiceLocator::GetServer()->GetUserSession()->Timezone;
	}
}
?>