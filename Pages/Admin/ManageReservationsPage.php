<?php

require_once(ROOT_DIR . 'Pages/IPageable.php');
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Pages/Ajax/AutoCompletePage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageReservationsPresenter.php');

interface IManageReservationsPage extends IPageable, IActionPage
{
	/**
	 * @abstract
	 * @param array|ReservationItemView[] $reservations
	 * @return void
	 */
	public function BindReservations($reservations);

	/**
	 * @abstract
	 * @return string
	 */
	public function GetStartDate();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetEndDate();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetUserId();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetUserName();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetScheduleId();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetResourceId();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetReferenceNumber();

	/**
	 * @abstract
	 * @param Date $date|null
	 * @return void
	 */
	public function SetStartDate($date);

	/**
	 * @abstract
	 * @param Date $date|null
	 * @return void
	 */
	public function SetEndDate($date);

	/**
	 * @abstract
	 * @param int $userId
	 * @return void
	 */
	public function SetUserId($userId);

	/**
	 * @abstract
	 * @param string $userName
	 * @return void
	 */
	public function SetUserName($userName);

	/**
	 * @abstract
	 * @param int $scheduleId
	 * @return void
	 */
	public function SetScheduleId($scheduleId);

	/**
	 * @abstract
	 * @param int $resourceId
	 * @return void
	 */
	public function SetResourceId($resourceId);


	/**
	 * @abstract
	 * @param string $referenceNumber
	 * @return void
	 */
	public function SetReferenceNumber($referenceNumber);

	/**
	 * @abstract
	 * @param array|Schedule[] $schedules
	 * @return void
	 */
	public function BindSchedules($schedules);

	/**
	 * @abstract
	 * @param array|BookableResource[] $resources
	 * @return void
	 */
	public function BindResources($resources);

	/**
	 * @abstract
	 * @return string
	 */
	public function GetDeleteReferenceNumber();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetDeleteScope();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetReservationStatusId();

	/**
	 * @abstract
	 * @param $reservationStatusId int
	 * @return void
	 */
	public function SetReservationStatusId($reservationStatusId);

	/**
	 * @abstract
	 * @return string
	 */
	public function GetApproveReferenceNumber();

	/**
	 * @abstract
	 * @return void
	 */
	public function ShowPage();

	/**
	 * @abstract
	 * @return void
	 */
	public function ShowCsv();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetFormat();

	/**
	 * @abstract
	 * @param $attributeList AttributeList
	 */
	public function SetAttributes($attributeList);
}

class ManageReservationsPage extends ActionPage implements IManageReservationsPage
{
	/**
	 * @var \ManageReservationsPresenter
	 */
	protected $presenter;

	/**
	 * @var \PageablePage
	 */
	protected $pageablePage;

	public function __construct()
	{
	    parent::__construct('ManageReservations', 1);

		$this->presenter = new ManageReservationsPresenter($this,
			new ManageReservationsService(new ReservationViewRepository()),
			new ScheduleRepository(),
			new ResourceRepository(),
			new AttributeService(new AttributeRepository()));

		$this->pageablePage = new PageablePage($this);
	}
	
	public function ProcessAction()
	{
		$this->presenter->ProcessAction();
	}

	public function ProcessPageLoad()
	{
		$userTimezone = $this->server->GetUserSession()->Timezone;

		$this->Set('Timezone', $userTimezone);
		$this->Set('CsvExportUrl', ServiceLocator::GetServer()->GetUrl() . '&' . QueryStringKeys::FORMAT . '=csv');
		$this->presenter->PageLoad($userTimezone);
	}

	public function ShowPage()
	{
		$this->Display('Admin/Reservations/manage_reservations.tpl');
	}

	public function ShowCsv()
	{
		$this->DisplayCsv('Admin/Reservations/reservations_csv.tpl', 'reservations.csv');
	}

	public function BindReservations($reservations)
	{
		$this->Set('reservations', $reservations);
	}

	/**
	 * @return string
	 */
	public function GetStartDate()
	{
		return $this->server->GetQuerystring(QueryStringKeys::START_DATE);
	}

	/**
	 * @return string
	 */
	public function GetEndDate()
	{
		return $this->server->GetQuerystring(QueryStringKeys::END_DATE);
	}

	/**
	 * @param Date $date
	 * @return void
	 */
	public function SetStartDate($date)
	{
		$this->Set('StartDate', $date);
	}

	/**
	 * @param Date $date
	 * @return void
	 */
	public function SetEndDate($date)
	{
		$this->Set('EndDate', $date);
	}

	/**
	 * @return int
	 */
	public function GetUserId()
	{
		return $this->GetQuerystring(QueryStringKeys::USER_ID);
	}

	/**
	 * @return string
	 */
	public function GetUserName()
	{
		return $this->GetQuerystring(QueryStringKeys::USER_NAME);
	}

	/**
	 * @return int
	 */
	public function GetScheduleId()
	{
		return $this->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
	}

	/**
	 * @return int
	 */
	public function GetResourceId()
	{
		return $this->GetQuerystring(QueryStringKeys::RESOURCE_ID);
	}
	
	public function GetPayment()
	{
		return $this->server->GetQuerystring(QueryStringKeys::PAYMENT);
	}

	/**
	 * @param int $userId
	 * @return void
	 */
	public function SetUserId($userId)
	{
		$this->Set('UserIdFilter', $userId);
	}

	/**
	 * @param string $userName
	 * @return void
	 */
	public function SetUserName($userName)
	{
		$this->Set('UserNameFilter', $userName);
	}

	/**
	 * @param int $scheduleId
	 * @return void
	 */
	public function SetScheduleId($scheduleId)
	{
		$this->Set('ScheduleId', $scheduleId);
	}
	
	public function SetPayment($payment)
	{
		if($payment==''){
			$payment=-2;
		}
		$this->Set('payment', $payment);
	}

	/**
	 * @param int $resourceId
	 * @return void
	 */
	public function SetResourceId($resourceId)
	{
		$this->Set('ResourceId', $resourceId);
	}

	public function BindSchedules($schedules)
	{
		$this->Set('Schedules', $schedules);
	}

	public function BindResources($resources)
	{
		$this->Set('Resources', $resources);
	}

	/**
	 * @return string
	 */
	public function GetReferenceNumber()
	{
		return $this->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER);
	}

	/**
	 * @param string $referenceNumber
	 * @return void
	 */
	public function SetReferenceNumber($referenceNumber)
	{
		$this->Set('ReferenceNumber', $referenceNumber);
	}

	/**
	 * @return int
	 */
	function GetPageNumber()
	{
		return $this->pageablePage->GetPageNumber();
	}

	/**
	 * @return int
	 */
	function GetPageSize()
	{
		return $this->pageablePage->GetPageSize();
	}

	/**
	 * @param PageInfo $pageInfo
	 * @return void
	 */
	function BindPageInfo(PageInfo $pageInfo)
	{
		$this->pageablePage->BindPageInfo($pageInfo);
	}

	/**
	 * @return string
	 */
	public function GetDeleteReferenceNumber()
	{
		return $this->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER);
	}

	/**
	 * @return string
	 */
	public function GetDeleteScope()
	{
		return $this->GetForm(FormKeys::SERIES_UPDATE_SCOPE);
	}

	/**
	 * @return int
	 */
	public function GetReservationStatusId()
	{
		return $this->GetQuerystring(QueryStringKeys::RESERVATION_STATUS_ID);
	}

	/**
	 * @param $reservationStatusId int
	 * @return void
	 */
	public function SetReservationStatusId($reservationStatusId)
	{
		$this->Set('ReservationStatusId', $reservationStatusId);
	}

	/**
	 * @return string
	 */
	public function GetApproveReferenceNumber()
	{
		return $this->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER);
	}

	/**
	 * @return string
	 */
	public function GetFormat()
	{
		return $this->GetQuerystring(QueryStringKeys::FORMAT);
	}

	/**
	 * @return void
	 */
	public function ProcessDataRequest($dataRequest)
	{
		// no-op
	}

	/**
	 * @param $attributeList AttributeList
	 */
	public function SetAttributes($attributeList)
	{
		$this->Set('AttributeList', $attributeList);
	}
}
?>