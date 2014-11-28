<?php

class ScheduleItemResponse extends RestResponse
{
	public $daysVisible;
	public $id;
	public $isDefault;
	public $name;
	public $timezone;
	public $weekdayStart;

	public function __construct(IRestServer $server, Schedule $schedule)
	{
		$this->daysVisible = $schedule->GetDaysVisible();
		$this->id = $schedule->GetId();
		$this->isDefault = $schedule->GetIsDefault();
		$this->name = $schedule->GetName();
		$this->timezone = $schedule->GetTimezone();
		$this->weekdayStart = $schedule->GetWeekdayStart();

		$this->AddService($server, WebServices::GetSchedule, array(WebServiceParams::ScheduleId => $schedule->GetId()));
	}

	public static function Example()
	{
		return new ExampleScheduleItemResponse();
	}
}

class ExampleScheduleItemResponse extends ScheduleItemResponse
{
	public function __construct()
	{
		$this->daysVisible = 5;
		$this->id = 123;
		$this->isDefault = true;
		$this->name = 'schedule name';
		$this->timezone = 'timezone_name';
		$this->weekdayStart = 0;
	}
}

?>