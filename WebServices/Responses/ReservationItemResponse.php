<?php

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class ReservationItemResponse extends RestResponse
{
	public $referenceNumber;
	public $startDate;
	public $endDate;
	public $firstName;
	public $lastName;
	public $resourceName;
	public $title;
	public $description;
	public $requiresApproval;
	public $isRecurring;
	public $scheduleId;
	public $userId;
	public $resourceId;

	public function __construct(ReservationItemView $reservationItemView, IRestServer $server, $showUser, $showDetails)
	{
		$this->referenceNumber = $reservationItemView->ReferenceNumber;
		$this->startDate = $reservationItemView->StartDate->ToIso();
		$this->endDate = $reservationItemView->EndDate->ToIso();
		$this->resourceName = $reservationItemView->ResourceName;

		if ($showUser)
		{
			$this->firstName = $reservationItemView->FirstName;
			$this->lastName = $reservationItemView->LastName;
		}

		if ($showDetails)
		{
			$this->title = $reservationItemView->Title;
			$this->description = $reservationItemView->Description;
		}

		$this->requiresApproval = $reservationItemView->RequiresApproval;
		$this->isRecurring = $reservationItemView->IsRecurring;

		$this->scheduleId = $reservationItemView->ScheduleId;
		$this->userId = $reservationItemView->UserId;
		$this->resourceId = $reservationItemView->ResourceId;

		$this->AddService($server, WebServices::GetResource,
						  array(WebServiceParams::ResourceId => $reservationItemView->ResourceId));
		$this->AddService($server, WebServices::GetReservation,
						  array(WebServiceParams::ReferenceNumber => $reservationItemView->ReferenceNumber));
		$this->AddService($server, WebServices::GetUser,
						  array(WebServiceParams::UserId => $reservationItemView->UserId));
		$this->AddService($server, WebServices::GetSchedule,
						  array(WebServiceParams::ScheduleId => $reservationItemView->ScheduleId));

	}

	public static function Example()
	{
		return new ExampleReservationItemResponse();
	}

}

class ExampleReservationItemResponse extends ReservationItemResponse
{
	public function __construct()
	{
		$this->description = 'reservation description';
		$this->endDate = Date::Now()->ToIso();
		$this->firstName = 'first';
		$this->isRecurring = true;
		$this->lastName = 'last';
		$this->referenceNumber = 'refnum';
		$this->requiresApproval = true;
		$this->resourceId = 123;
		$this->resourceName = 'resourcename';
		$this->scheduleId = 22;
		$this->startDate = Date::Now()->ToIso();
		$this->title = 'reservation title';
		$this->userId = 11;
	}
}

?>