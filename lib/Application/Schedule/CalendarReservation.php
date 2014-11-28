<?php

class CalendarReservation
{
	/**
	 * @var Date
	 */
	public $StartDate;

	/**
	 * @var Date
	 */
	public $EndDate;

	/**
	 * @var string
	 */
	public $ResourceName;

	/**
	 * @var string
	 */
	public $ReferenceNumber;

	/**
	 * @var string
	 */
	public $Title;

	/**
	 * @var string
	 */
	public $Description;

	/**
	 * @var bool
	 */
	public $Invited;

	/**
	 * @var bool
	 */
	public $Participant;

	/**
	 * @var bool
	 */
	public $Owner;

	/**
	 * @var string
	 */
	public $OwnerName;

	/**
	 * @var string
	 */
	public $OwnerFirst;

	/**
	 * @var string
	 */
	public $OwnerLast;

	/**
	 * @var string
	 */
	public $DisplayTitle;

	private function __construct(Date $startDate, Date $endDate, $resourceName, $referenceNumber)
	{
		$this->StartDate = $startDate;
		$this->EndDate = $endDate;
		$this->ResourceName = $resourceName;
		$this->ReferenceNumber = $referenceNumber;
	}

	/**
	 * @param $reservations array|ReservationItemView[]
	 * @param $timezone string
	 * @return array|CalendarReservation[]
	 */
	public static function FromViewList($reservations, $timezone)
	{
		$results = array();

		foreach ($reservations as $reservation)
		{
			$results[] = self::FromView($reservation, $timezone);
		}
		return $results;
	}

	/**
	 * @param $reservation ReservationItemView
	 * @param $timezone string
	 * @return CalendarReservation
	 */
	public static function FromView($reservation, $timezone)
	{
		$start = $reservation->StartDate->ToTimezone($timezone);
		$end = $reservation->EndDate->ToTimezone($timezone);
		$resourceName = $reservation->ResourceName;
		$referenceNumber = $reservation->ReferenceNumber;

		$res = new CalendarReservation($start, $end, $resourceName, $referenceNumber);

		$res->Title = $reservation->Title;
		$res->Description = $reservation->Description;

		$res->Invited = $reservation->UserLevelId == ReservationUserLevel::INVITEE;
		$res->Participant = $reservation->UserLevelId == ReservationUserLevel::PARTICIPANT;
		$res->Owner = $reservation->UserLevelId == ReservationUserLevel::OWNER;
		return $res;
	}

	/**
	 * @static
	 * @param array|ReservationItemView[] $reservations
	 * @param array|ResourceDto[] $resources
	 * @param UserSession $userSession
	 * @param IPrivacyFilter $privacyFilter
	 * @return array|CalendarReservation[]
	 */
	public static function FromScheduleReservationList($reservations, $resources, UserSession $userSession,
													   IPrivacyFilter $privacyFilter)
	{
		$resourceMap = array();
		/** @var $resource ResourceDto */
		foreach ($resources as $resource)
		{
			$resourceMap[$resource->GetResourceId()] = $resource->GetName();
		}

		$res = array();
		foreach ($reservations as $reservation)
		{
			if (!array_key_exists($reservation->ResourceId, $resourceMap))
			{
				continue;
			}

			$timezone = $userSession->Timezone;
			$start = $reservation->StartDate->ToTimezone($timezone);
			$end = $reservation->EndDate->ToTimezone($timezone);
			$referenceNumber = $reservation->ReferenceNumber;

			$cr = new CalendarReservation($start, $end, $resourceMap[$reservation->ResourceId], $referenceNumber);
			$cr->Title = $reservation->Title;
			$cr->OwnerName = new FullName($reservation->FirstName, $reservation->LastName);
			$cr->OwnerFirst = $reservation->FirstName;
			$cr->OwnerLast = $reservation->LastName;
			$cr->DisplayTitle = 'Private';

			if ($privacyFilter->CanViewUser($userSession, null, $reservation->UserId))
			{
				$cr->DisplayTitle = $cr->OwnerName;
			}

			if ($privacyFilter->CanViewDetails($userSession, null, $reservation->UserId))
			{
				$cr->DisplayTitle .= ' ' . $reservation->Title;
			}
			$res[] = $cr;
		}

		return $res;
	}
}

?>