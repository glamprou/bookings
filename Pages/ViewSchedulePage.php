<?php

require_once(ROOT_DIR . 'Pages/SchedulePage.php');
require_once(ROOT_DIR . 'Presenters/SchedulePresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/ViewSchedulePermissionServiceFactory.php');

class ViewSchedulePage extends SchedulePage
{
	public function __construct()
	{
		parent::__construct();
		$scheduleRepository = new ScheduleRepository();
		$resourceService = new ResourceService(new ResourceRepository(), new ViewSchedulePermissionService());
		$pageBuilder = new SchedulePageBuilder();
		$reservationService = new ReservationService(new ReservationViewRepository(), new ReservationListingFactory());
		$dailyLayoutFactory = new DailyLayoutFactory();

		$this->_presenter = new SchedulePresenter(
			$this,
			$scheduleRepository,
			$resourceService,
			$pageBuilder,
			$reservationService,
			$dailyLayoutFactory);
	}
	
	public function ProcessPageLoad()
	{
		$this->_presenter->PageLoad(new NullUserSession());
		$viewReservations = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_VIEW_RESERVATIONS, new BooleanConverter());
		$this->Set('DisplaySlotFactory', new DisplaySlotFactory());
		$this->Set('SlotLabelFactory', $viewReservations ? new SlotLabelFactory() : new NullSlotLabelFactory());
        $this->Set('viewSchedule', true);
		$this->Display('view-schedule.tpl');
	}

    public function ShowInaccessibleResources()
    {
        return true;
    }

	protected function GetShouldAutoLogout()
	{
		return false;
	}
}
?>