<?php
 
require_once(ROOT_DIR . 'Pages/NewReservationPage.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationInitializerBase.php');

class NewReservationInitializer extends ReservationInitializerBase
{	
	/**
	 * @var INewReservationPage
	 */
	private $_page;
	
	public function __construct(
		INewReservationPage $page, 
		IReservationComponentBinder $userBinder,
		IReservationComponentBinder $dateBinder,
		IReservationComponentBinder $resourceBinder,
		IReservationComponentBinder $attributeBinder,
		UserSession $userSession
		)
	{
		$this->_page = $page;
		
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
	}

	protected function SetSelectedDates(Date $startDate, Date $endDate, $startPeriods, $endPeriods)
	{
		parent::SetSelectedDates($startDate, $endDate, $startPeriods, $endPeriods);
		$this->basePage->SetRepeatTerminationDate($endDate);
	}
	
	public function GetOwnerId()
	{
		return ServiceLocator::GetServer()->GetUserSession()->UserId;
	}
	
	public function GetResourceId()
	{
		return $this->_page->GetRequestedResourceId();
	}
	
	public function GetScheduleId()
	{
		return $this->_page->GetRequestedScheduleId();
	}
	
	public function GetReservationDate()
	{
		return $this->_page->GetReservationDate();
	}
	
	public function GetStartDate()
	{
		return $this->_page->GetStartDate();
	}
	
	public function GetEndDate()
	{
		return $this->_page->GetEndDate();
	}
	
	public function GetTimezone()
	{
		return ServiceLocator::GetServer()->GetUserSession()->Timezone;
	}
}

class BindableResourceData
{
	/**
	 * @var ResourceDto
	 */
	public $ReservationResource;

	/**
	 * @var array|ResourceDto[]
	 */
	public $AvailableResources;

	/**
	 * @var int
	 */
	public $NumberAccessible = 0;
	
	public function __construct()
	{
		$this->ReservationResource = new NullScheduleResource();
		$this->AvailableResources = array();
	}

	/**
	 * @param $resource ResourceDto
	 * @return void
	 */
	public function SetReservationResource($resource)
	{
		$this->ReservationResource = $resource;
	}

	/**
	 * @param $resource ResourceDto
	 * @return void
	 */
	public function AddAvailableResource($resource)
	{
		if ($resource->CanAccess)
		{
			$this->NumberAccessible++;
		}
		$this->AvailableResources[] = $resource;	
	}
}

?>