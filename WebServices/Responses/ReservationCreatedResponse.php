<?php

class ReservationCreatedResponse extends RestResponse
{
	public $referenceNumber;

	public function __construct(IRestServer $server, $referenceNumber)
	{
		$this->message = 'The reservation was created';
		$this->referenceNumber = $referenceNumber;
		$this->AddService($server, WebServices::GetReservation, array(WebServiceParams::ReferenceNumber => $referenceNumber));
		$this->AddService($server, WebServices::UpdateReservation, array(WebServiceParams::ReferenceNumber => $referenceNumber));
	}

	public static function Example()
	{
		return new ExampleReservationCreatedResponse();
	}
}

class ReservationUpdatedResponse extends RestResponse
{
	public $referenceNumber;

	public function __construct(IRestServer $server, $referenceNumber)
	{
		$this->message = 'The reservation was updated';
		$this->referenceNumber = $referenceNumber;
		$this->AddService($server, WebServices::GetReservation, array(WebServiceParams::ReferenceNumber => $referenceNumber));
	}

	public static function Example()
	{
		return new ExampleReservationCreatedResponse();
	}
}

class ExampleReservationCreatedResponse extends ReservationCreatedResponse
{
	public function __construct()
	{
		$this->referenceNumber = 'referenceNumber';
		$this->AddLink('http://url/to/reservation', WebServices::GetReservation);
		$this->AddLink('http://url/to/update/reservation', WebServices::UpdateReservation);
	}
}
?>