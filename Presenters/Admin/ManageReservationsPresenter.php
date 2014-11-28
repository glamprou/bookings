<?php

require_once(ROOT_DIR . 'Pages/Admin/ManageReservationsPage.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Admin/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');

class ManageReservationsPresenter extends ActionPresenter
{
	/**
	 * @var IManageReservationsPage
	 */
	private $page;

	/**
	 * @var IManageReservationsService
	 */
	private $manageReservationsService;

	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @var IAttributeService
	 */
	private $attributeService;

	public function __construct(
		IManageReservationsPage $page,
		IManageReservationsService $manageReservationsService,
		IScheduleRepository $scheduleRepository,
		IResourceRepository $resourceRepository,
		IAttributeService $attributeService)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->manageReservationsService = $manageReservationsService;
		$this->scheduleRepository = $scheduleRepository;
		$this->resourceRepository = $resourceRepository;
		$this->attributeService = $attributeService;
	}

	public function PageLoad($userTimezone)
	{
		$session = ServiceLocator::GetServer()->GetUserSession();

		$this->page->BindSchedules($this->scheduleRepository->GetAll());
		$this->page->BindResources($this->resourceRepository->GetResourceList());

		$startDateString = $this->page->GetStartDate();
		$endDateString = $this->page->GetEndDate();

		$startDate = $this->GetDate($startDateString, $userTimezone, -7);
		$endDate = $this->GetDate($endDateString, $userTimezone, 7);
		$referenceNumber = $this->page->GetReferenceNumber();
		$scheduleId = $this->page->GetScheduleId();
		$resourceId = $this->page->GetResourceId();
		$reservationStatusId = $this->page->GetReservationStatusId();
		$userId = $this->page->GetUserId();
		$userName = $this->page->GetUserName();
		$payment=$this->page->GetPayment();
		
		
		
		$this->page->SetStartDate($startDate);
		$this->page->SetEndDate($endDate);
		$this->page->SetReferenceNumber($referenceNumber);
		$this->page->SetScheduleId($scheduleId);
		$this->page->SetResourceId($resourceId);
		$this->page->SetUserId($userId);
		$this->page->SetUserName($userName);
		$this->page->SetReservationStatusId($reservationStatusId);
		$this->page->SetPayment($payment);
		
		$filter = new ReservationFilter($startDate, $endDate, $referenceNumber, $scheduleId, $resourceId, $userId, $reservationStatusId, $payment);

		$reservations = $this->manageReservationsService->LoadFiltered($this->page->GetPageNumber(),
																	   $this->page->GetPageSize(),
																	   $filter,
																	   $session);

		$reservationList = $reservations->Results();
		$this->page->BindReservations($reservationList);
		$this->page->BindPageInfo($reservations->PageInfo());

		$seriesIds = array();
		/** @var $reservationItemView ReservationItemView */
		foreach ($reservationList as $reservationItemView)
		{
			$seriesIds[] = $reservationItemView->SeriesId;
		}

		$attributeList = $this->attributeService->GetAttributes(CustomAttributeCategory::RESERVATION, $seriesIds);
		$this->page->SetAttributes($attributeList);

		if ($this->page->GetFormat() == 'csv')
		{
			$this->page->ShowCsv();
		}
		else
		{
			$this->page->ShowPage();
		}
	}

	private function GetDate($dateString, $timezone, $defaultDays)
	{
		$date = null;
		if (is_null($dateString)) {
			$date = Date::Now()->AddDays($defaultDays)->ToTimezone($timezone)->GetDate();

		}
		elseif (!empty($dateString))
		{
			$date = Date::Parse($dateString, $timezone);
		}

		return $date;
	}

}

?>