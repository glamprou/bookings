<?php

require_once(ROOT_DIR . 'WebServices/Requests/ReservationAccessoryRequest.php');
require_once(ROOT_DIR . 'WebServices/Requests/AttributeValueRequest.php');
require_once(ROOT_DIR . 'WebServices/Responses/RecurrenceRequestResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/ReminderRequestResponse.php');

class ReservationRequest
{
	/**
	 * @var array|ReservationAccessoryRequest[]
	 */
	public $accessories = array();
	/**
	 * @var array|AttributeValueRequest[]
	 */
	public $customAttributes = array();
	public $description;
	public $endDateTime;
	/**
	 * @var array|int[]
	 */
	public $invitees = array();
	/**
	 * @var array|int[]
	 */
	public $participants = array();
	/**
	 * @var RecurrenceRequestResponse
	 */
	public $recurrenceRule;
	public $resourceId;
	/**
	 * @var array|int[]
	 */
	public $resources = array();
	public $startDateTime;
	public $title;
	public $userId;
	/**
	 * @var ReminderRequestResponse
	 */
	public $startReminder;
	/**
	 * @var ReminderRequestResponse
	 */
	public $endReminder;

	public static function Example()
	{
		$date = Date::Now()->ToIso();
		$request = new ReservationRequest();
		$request->accessories = array(new ReservationAccessoryRequest(1, 2));
		$request->customAttributes = array(new AttributeValueRequest(2, 'some value'));
		$request->description = 'reservation description';
		$request->endDateTime = $date;
		$request->invitees = array(1, 2, 3);
		$request->participants = array(1, 2);
		$request->recurrenceRule = RecurrenceRequestResponse::Example();
		$request->resourceId = 1;
		$request->resources = array(2, 3);
		$request->startDateTime = $date;
		$request->title = 'reservation title';
		$request->userId = 1;
		$request->startReminder = ReminderRequestResponse::Example();

		return $request;
	}
}

?>