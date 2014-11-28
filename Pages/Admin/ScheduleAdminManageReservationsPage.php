<?php

require_once(ROOT_DIR . 'Pages/Admin/ManageReservationsPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageReservationsPresenter.php');

class ScheduleAdminManageReservationsPage extends ManageReservationsPage
{
	public function __construct()
		{
			parent::__construct();

			$userRepository = new UserRepository();
			$this->presenter = new ManageReservationsPresenter($this,
						new ScheduleAdminManageReservationsService(new ReservationViewRepository(), $userRepository),
						new ScheduleAdminScheduleRepository($userRepository, ServiceLocator::GetServer()->GetUserSession()),
						new ResourceAdminResourceRepository($userRepository, ServiceLocator::GetServer()->GetUserSession()),
						new AttributeService(new AttributeRepository()));
		}
}
?>