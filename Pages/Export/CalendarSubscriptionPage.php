<?php

require_once(ROOT_DIR . 'Presenters/CalendarSubscriptionPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

interface ICalendarSubscriptionPage
{
	/**
	 * @abstract
	 * @return string
	 */
	function GetSubscriptionKey();

	/**
	 * @abstract
	 * @return string
	 */
	function GetUserId();

	/**
	 * @abstract
	 * @param array|iCalendarReservationView[] $reservations
	 */
	function SetReservations($reservations);

	/**
	 * @abstract
	 * @return int
	 */
	function GetScheduleId();

	/**
	 * @abstract
	 * @return int
	 */
	function GetResourceId();

	/**
	 * @abstract
	 * @return int
	 */
	function GetAccessoryIds();
}

class CalendarSubscriptionPage extends Page implements ICalendarSubscriptionPage
{
	/**
	 * @var CalendarSubscriptionPresenter
	 */
	private $presenter;

	public function __construct()
	{
		$authorization = new ReservationAuthorization(PluginManager::Instance()->LoadAuthorization());
		$service = new CalendarSubscriptionService(new UserRepository(), new ResourceRepository(), new ScheduleRepository());
		$icalSubscriptionValidator = new CalendarSubscriptionValidator($this, $service);
		$this->presenter = new CalendarSubscriptionPresenter($this,
															 new ReservationViewRepository(),
															 $icalSubscriptionValidator,
															 $service,
															 new PrivacyFilter($authorization));
		parent::__construct('', 1);
	}

	public function GetSubscriptionKey()
	{
		return $this->GetQuerystring(QueryStringKeys::SUBSCRIPTION_KEY);
	}

	/**
	 * @return string
	 */
	public function GetUserId()
	{
		return $this->GetQuerystring(QueryStringKeys::USER_ID);
	}

	public function PageLoad()
	{
		$this->presenter->PageLoad();

		header("Content-Type: text/Calendar");
		header("Content-Disposition: inline; filename=calendar.ics");

		$config = Configuration::Instance();

		$this->Set('phpScheduleItVersion', $config->GetKey(ConfigKeys::VERSION));
		$this->Set('DateStamp', Date::Now());

		/*
				   ScriptUrl is used to generate iCal UID's. As a workaround to this bug
				   https://bugzilla.mozilla.org/show_bug.cgi?id=465853
				   we need to avoid using any slashes "/"
		 */
		$url = $config->GetScriptUrl();
		$this->Set('ScriptUrl', parse_url($url, PHP_URL_HOST));

		$this->Display('Export/ical.tpl');
	}

	/**
	 * @param array|iCalendarReservationView[] $reservations
	 */
	public function SetReservations($reservations)
	{
		$this->Set('Reservations', $reservations);
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

	// Copyright 2012, Alois Schloegl, IST Austria
	/**
	 * @return int
	 */
	public function GetAccessoryIds()
	{
		return $this->GetQuerystring(QueryStringKeys::ACCESSORY_ID);
	}
}

?>
