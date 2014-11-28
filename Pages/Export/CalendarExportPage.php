<?php

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/CalendarExportPresenter.php');

interface ICalendarExportPage
{
	/**
	 * @abstract
	 * @return string
	 */
	public function GetReferenceNumber();

	/**
	 * @abstract
	 * @param array|iCalendarReservationView[] $reservations
	 */
	public function SetReservations($reservations);

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
	 * @return int
	 */
	public function GetAccessoryName();
}

class CalendarExportPage extends Page implements ICalendarExportPage
{
	/**
	 * @var \CalendarExportPresenter
	 */
	private $presenter;

	public function __construct()
	{
		$authorization = new ReservationAuthorization(PluginManager::Instance()->LoadAuthorization());
		$this->presenter = new CalendarExportPresenter($this,
													   new ReservationViewRepository(),
													   new NullCalendarExportValidator(),
													   new PrivacyFilter($authorization));
		parent::__construct('', 1);
	}

	public function PageLoad()
	{
		$this->presenter->PageLoad(ServiceLocator::GetServer()->GetUserSession());

		header("Content-Type: text/Calendar");
		header("Content-Disposition: inline; filename=calendar.ics");

		$config = Configuration::Instance();

		$this->Set('phpScheduleItVersion', $config->GetKey(ConfigKeys::VERSION));
		$this->Set('DateStamp', Date::Now());

		/**
		 * ScriptUrl is used to generate iCal UID's. As a workaround to this bug
		 * https://bugzilla.mozilla.org/show_bug.cgi?id=465853
		 * we need to avoid using any slashes "/"
		 */
		$url = $config->GetScriptUrl();
		$this->Set('ScriptUrl', parse_url($url, PHP_URL_HOST));

		$this->Display('Export/ical.tpl');
	}

	public function GetReferenceNumber()
	{
		return $this->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER);
	}

	public function SetReservations($reservations)
	{
		$this->Set('Reservations', $reservations);
	}

	public function GetScheduleId()
	{
		return $this->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
	}

	public function GetResourceId()
	{
		return $this->GetQuerystring(QueryStringKeys::RESOURCE_ID);
	}

	public function GetAccessoryName()
	{
		return $this->GetQuerystring(QueryStringKeys::ACCESSORY_NAME);
	}
}

class NullCalendarExportValidator implements ICalendarExportValidator
{
	function IsValid()
	{
		return true;
	}
}

?>