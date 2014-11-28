<?php

require_once(ROOT_DIR . 'lib/WebService/namespace.php');
require_once(ROOT_DIR . 'WebServices/Responses/ReservationItemResponse.php');

class ReservationsResponse extends RestResponse
{
	/**
	 * @var array|ReservationItemResponse[]
	 */
	public $reservations = array();

	/**
	 * @param IRestServer $server
	 * @param array|ReservationItemView[] $reservations
	 * @param IPrivacyFilter $privacyFilter
	 */
	public function __construct(IRestServer $server, $reservations, IPrivacyFilter $privacyFilter)
	{
		$user = $server->GetSession();
		foreach ($reservations as $reservation)
		{
			$showUser = $privacyFilter->CanViewUser($user, null, $reservation->UserId);
			$showDetails = $privacyFilter->CanViewDetails($user, null, $reservation->UserId);

			$this->reservations[] = new ReservationItemResponse($reservation, $server, $showUser, $showDetails);
		}
	}

	public static function Example()
	{
		return new ExampleReservationsResponse();
	}
}

class ExampleReservationsResponse extends ReservationsResponse
{
	public function __construct()
	{
		$this->reservations = array(ReservationItemResponse::Example());
	}
}

?>