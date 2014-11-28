<?php

require_once(ROOT_DIR . 'lib/WebService/namespace.php');
require_once(ROOT_DIR . 'WebServices/Responses/RecurrenceRequestResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/ResourceItemResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/ReservationAccessoryResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/CustomAttributeResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/AttachmentResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/ReservationUserResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/ReminderRequestResponse.php');

class ReservationResponse extends RestResponse
{
	public $referenceNumber;
	public $startDateTime;
	public $endDateTime;
	public $title;
	public $description;
	public $requiresApproval;
	public $isRecurring;
	public $scheduleId;
	public $resourceId;
	/**
	 * @var ReservationUserResponse
	 */
	public $owner;
	/**
	 * @var array|ReservationUserResponse[]
	 */
	public $participants = array();
	/**
	 * @var array|ReservationUserResponse[]
	 */
	public $invitees = array();
	/**
	 * @var array|CustomAttributeResponse[]
	 */
	public $customAttributes = array();
	/**
	 * @var RecurrenceRequestResponse
	 */
	public $recurrenceRule;
	/**
	 * @var array|AttachmentResponse[]
	 */
	public $attachments = array();
	/**
	 * @var array|ResourceItemResponse[]
	 */
	public $resources = array();
	/**
	 * @var array|ReservationAccessoryResponse[]
	 */
	public $accessories = array();
	/**
	 * @var ReminderRequestResponse
	 */
	public $startReminder;
	/**
	 * @var ReminderRequestResponse
	 */
	public $endReminder;

	/**
	 * @param IRestServer $server
	 * @param ReservationView $reservation
	 * @param IPrivacyFilter $privacyFilter
	 * @param array|CustomAttribute[] $attributes
	 */
	public function __construct(IRestServer $server,
								ReservationView $reservation,
								IPrivacyFilter $privacyFilter,
								$attributes = array())
	{
		$this->owner = ReservationUserResponse::Masked();

		$canViewUser = $privacyFilter->CanViewUser($server->GetSession(), $reservation);
		$canViewDetails = $privacyFilter->CanViewDetails($server->GetSession(), $reservation);

		$this->referenceNumber = $reservation->ReferenceNumber;
		$this->startDateTime = $reservation->StartDate->ToIso();
		$this->endDateTime = $reservation->EndDate->ToIso();
		$this->requiresApproval = $reservation->RequiresApproval();
		$this->isRecurring = $reservation->IsRecurring();
		$repeatTerminationDate = $reservation->RepeatTerminationDate != null ? $reservation->RepeatTerminationDate->ToIso() : null;
		$this->recurrenceRule = new RecurrenceRequestResponse($reservation->RepeatType, $reservation->RepeatInterval, $reservation->RepeatMonthlyType, $reservation->RepeatWeekdays, $repeatTerminationDate);
		$this->resourceId = $reservation->ResourceId;
		$this->scheduleId = $reservation->ScheduleId;
		$this->AddService($server, WebServices::GetSchedule,
						  array(WebServiceParams::ScheduleId => $reservation->ScheduleId));

		foreach ($reservation->Resources as $resource)
		{
			$this->resources[] = new ResourceItemResponse($server, $resource->Id(), $resource->GetName());
		}

		foreach ($reservation->Accessories as $accessory)
		{
			$this->accessories[] = new ReservationAccessoryResponse($server, $accessory->AccessoryId, $accessory->Name, $accessory->QuantityReserved, $accessory->QuantityAvailable);
		}

		if ($canViewDetails)
		{
			$this->title = $reservation->Title;
			$this->description = $reservation->Description;
			foreach ($attributes as $attribute)
			{
				$this->customAttributes[] = new CustomAttributeResponse($server, $attribute->Id(),
																		$attribute->Label(),
																		$reservation->GetAttributeValue($attribute->Id()));
			}
			foreach ($reservation->Attachments as $attachment)
			{
				$this->attachments[] = new AttachmentResponse($server, $attachment->FileId(), $attachment->FileName(), $reservation->ReferenceNumber);
			}
		}

		if ($canViewUser)
		{
			$this->owner = new ReservationUserResponse($server, $reservation->OwnerId, $reservation->OwnerFirstName,
													   $reservation->OwnerLastName,
													   $reservation->OwnerEmailAddress);
			foreach ($reservation->Participants as $participant)
			{
				$this->participants[] = new ReservationUserResponse($server, $participant->UserId,
																	$participant->FirstName,
																	$participant->LastName, $participant->Email);
			}
			foreach ($reservation->Invitees as $invitee)
			{
				$this->invitees[] = new ReservationUserResponse($server, $invitee->UserId,
																$invitee->FirstName, $invitee->LastName,
																$invitee->Email);
			}
		}

		if ($reservation->StartReminder != null)
		{
			$this->startReminder = new ReminderRequestResponse($reservation->StartReminder->GetValue(), $reservation->StartReminder->GetInterval());
		}
		if ($reservation->EndReminder != null)
		{
			$this->endReminder = new ReminderRequestResponse($reservation->EndReminder->GetValue(), $reservation->EndReminder->GetInterval());
		}
	}


	/**
	 * @return ReservationResponse
	 */
	public static function Example()
	{
		return new ExampleReservationResponse();
	}
}

class ExampleReservationResponse extends ReservationResponse
{
	public function __construct()
	{
		$this->accessories = array(ReservationAccessoryResponse::Example());
		$this->attachments = array(AttachmentResponse::Example());
		$this->customAttributes = array(CustomAttributeResponse::Example());
		$this->description = 'reservation description';
		$this->endDateTime = Date::Now()->ToIso();
		$this->invitees = array(ReservationUserResponse::Example());
		$this->isRecurring = true;
		$this->owner = ReservationUserResponse::Example();
		$this->participants = array(ReservationUserResponse::Example());
		$this->recurrenceRule = RecurrenceRequestResponse::Example();
		$this->referenceNumber = 'refnum';
		$this->requiresApproval = true;
		$this->resourceId = 123;
		$this->resources = array(ResourceItemResponse::Example());
		$this->scheduleId = 123;
		$this->startDateTime = Date::Now()->ToIso();
		$this->title = 'reservation title';
		$this->startReminder = ReminderRequestResponse::Example();
		$this->endReminder = ReminderRequestResponse::Example();
	}
}

?>