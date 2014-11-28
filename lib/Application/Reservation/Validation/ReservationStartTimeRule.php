<?php

require_once(ROOT_DIR . 'Domain/Values/ReservationStartTimeConstraint.php');

class ReservationStartTimeRule implements IReservationValidationRule
{
    public function __construct(IScheduleRepository $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
        $constraint = Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_START_TIME_CONSTRAINT);

        if (empty($constraint))
        {
            $constraint = ReservationStartTimeConstraint::_DEFAULT;
        }

        if ($constraint == ReservationStartTimeConstraint::NONE)
        {
            return new ReservationRuleResult();
        }

        $currentInstance = $reservationSeries->CurrentInstance();

        $dateThatShouldBeLessThanNow = $currentInstance->StartDate();
        if ($constraint == ReservationStartTimeConstraint::CURRENT)
        {
            $timezone = $dateThatShouldBeLessThanNow->Timezone();
            /** @var $currentPeriod SchedulePeriod */
			$currentPeriod = $this->scheduleRepository
					->GetLayout($reservationSeries->ScheduleId(), new ScheduleLayoutFactory($timezone))
					->GetPeriod($currentInstance->EndDate());
            $dateThatShouldBeLessThanNow = $currentPeriod->BeginDate();
        }
		Log::Debug("Start Time Rule: Comparing %s to %s", $dateThatShouldBeLessThanNow, Date::Now());

		$startIsInFuture = $dateThatShouldBeLessThanNow->Compare(Date::Now()) >= 0;
		return new ReservationRuleResult($startIsInFuture, Resources::GetInstance()->GetString('StartIsInPast'));
	}
}
?>