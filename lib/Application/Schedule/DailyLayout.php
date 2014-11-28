<?php

require_once(ROOT_DIR . 'lib/Common/Helpers/StopWatch.php');
require_once(ROOT_DIR . 'Domain/ScheduleLayout.php');
require_once(ROOT_DIR . 'Domain/SchedulePeriod.php');

interface IDailyLayout
{
	/**
	 * @param Date $date
	 * @param int $resourceId
	 * @return array|IReservationSlot[]
	 */
	function GetLayout(Date $date, $resourceId);

	/**
	 * @param Date $date
	 * @return bool
	 */
	function IsDateReservable(Date $date);

	/**
	 * @param Date $displayDate
	 * @return string[]
	 */
	function GetLabels(Date $displayDate);

	/**
	 * @param Date $displayDate
	 * @return mixed
	 */
	function GetPeriods(Date $displayDate);
}

class DailyLayout implements IDailyLayout
{
	/**
	 * @var IReservationListing
	 */
	private $_reservationListing;
	/**
	 * @var IScheduleLayout
	 */
	private $_scheduleLayout;

	/**
	 * @param IReservationListing $listing
	 * @param IScheduleLayout $layout
	 */
	public function __construct(IReservationListing $listing, IScheduleLayout $layout)
	{
		$this->_reservationListing = $listing;
		$this->_scheduleLayout = $layout;
	}

	public function GetLayout(Date $date, $resourceId)
	{
		$hideBlocked = Configuration::Instance()->GetSectionKey(ConfigSection::SCHEDULE, ConfigKeys::SCHEDULE_HIDE_BLOCKED_PERIODS, new BooleanConverter());
		$sw = new StopWatch();
		$sw->Start();

		$items = $this->_reservationListing->OnDateForResource($date, $resourceId);
		$sw->Record('listing');
		$list = new ScheduleReservationList($items, $this->_scheduleLayout, $date, $hideBlocked);
		$slots = $list->BuildSlots();
		$sw->Record('slots');
		$sw->Stop();

//		Log::Debug("DailyLayout::GetLayout - For resourceId %s on date %s, took %s seconds to get reservation listing, %s to build the slots, %s total seconds for %s reservations",
//			$resourceId,
//			$date->ToString(),
//			$sw->GetRecordSeconds('listing'),
//			$sw->TimeBetween('slots', 'listing'),
//			$sw->GetTotalSeconds(),
//			count($items));


		return $slots;
	}

	public function IsDateReservable(Date $date)
	{
		return !$date->GetDate()->LessThan(Date::Now()->GetDate());
	}

	public function GetLabels(Date $displayDate)
	{
		$hideBlocked = Configuration::Instance()->GetSectionKey(ConfigSection::SCHEDULE, ConfigKeys::SCHEDULE_HIDE_BLOCKED_PERIODS, new BooleanConverter());

		$labels = array();

		$periods = $this->_scheduleLayout->GetLayout($displayDate, $hideBlocked);

		if ($periods[0]->BeginsBefore($displayDate))
		{
			$labels[] = $periods[0]->Label($displayDate->GetDate());
		}
		else
		{
			$labels[] = $periods[0]->Label();
		}

		for ($i = 1; $i < count($periods); $i++)
		{
			$labels[] = $periods[$i]->Label();
		}

		return $labels;
	}

	public function GetPeriods(Date $displayDate, $fitToHours = false)
	{
		$hideBlocked = Configuration::Instance()->GetSectionKey(ConfigSection::SCHEDULE, ConfigKeys::SCHEDULE_HIDE_BLOCKED_PERIODS, new BooleanConverter());

		$periods = $this->_scheduleLayout->GetLayout($displayDate, $hideBlocked);

		if (!$fitToHours)
		{
			return $periods;
		}

		/** @var $periodsToReturn SpanablePeriod[] */
		$periodsToReturn = array();

		for ($i = 0; $i < count($periods); $i++)
		{
			$span = 1;
			$currentPeriod = $periods[$i];
			$periodStart = $currentPeriod->BeginDate();
			$periodLength = $periodStart->GetDifference($currentPeriod->EndDate())->Hours();

			if (!$periods[$i]->IsLabelled() && ($periodStart->Minute() == 0 && $periodLength < 1))
			{
				$span = 0;
				$nextPeriodTime = $periodStart->AddMinutes(60);
				$tempPeriod = $currentPeriod;
				while ($tempPeriod != null && $tempPeriod->BeginDate()->LessThan($nextPeriodTime))
				{
					$span++;
					$i++;
					$tempPeriod = $periods[$i];
				}
				$i--;

			}
			$periodsToReturn[] = new SpanablePeriod($currentPeriod, $span);

		}
//var_dump($periodsToReturn); exit;
		return $periodsToReturn;
	}
}

interface IDailyLayoutFactory
{
	/**
	 * @param IReservationListing $listing
	 * @param IScheduleLayout $layout
	 * @return IDailyLayout
	 */
	function Create(IReservationListing $listing, IScheduleLayout $layout);
}

class DailyLayoutFactory implements IDailyLayoutFactory
{
	public function Create(IReservationListing $listing, IScheduleLayout $layout)
	{
		return new DailyLayout($listing, $layout);
	}
}

class SpanablePeriod extends SchedulePeriod
{
	private $span = 1;
	private $period;

	public function __construct(SchedulePeriod $period, $span = 1)
	{
		$this->span = $span;
		$this->period = $period;
		parent::__construct($period->BeginDate(), $period->EndDate(), $period->_label);

	}

	public function Span()
	{
		return $this->span;
	}

	public function SetSpan($span)
	{
		$this->span = $span;
	}

	public function IsReservable()
	{
		return $this->period->IsReservable();
	}
}

?>