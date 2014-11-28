<?php

require_once(ROOT_DIR . 'Controls/Dashboard/DashboardItem.php');
require_once(ROOT_DIR . 'Presenters/Dashboard/UpcomingReservationsPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/ReservationViewRepository.php');

class UpcomingReservations extends DashboardItem implements IUpcomingReservationsControl
{
	/**
	 * @var UpcomingReservationsPresenter
	 */
	private $presenter;
	
	public function __construct(SmartyPage $smarty)
	{
		parent::__construct($smarty);
		$this->presenter = new UpcomingReservationsPresenter($this, new ReservationViewRepository());
	}
	
	public function PageLoad()
	{
        $this->Set('DefaultTitle', Resources::GetInstance()->GetString('NoTitleLabel'));
		$this->presenter->PageLoad();
		$this->Display('upcoming_reservations.tpl');
	}
	
	public function SetTimezone($timezone)
	{
		$this->Set('Timezone', $timezone);
	}
	
	public function SetTotal($total)
	{
		$this->Set('Total', $total);
	}

	public function SetUserId($userId)
	{
		$this->Set('UserId', $userId);
	}
	
	public function BindToday($reservations)
	{
		$this->Set('TodaysReservations', $reservations);
	}
	
	public function BindTomorrow($reservations)
	{
		$this->Set('TomorrowsReservations', $reservations);
	}
	
	public function BindThisWeek($reservations)
	{
		$this->Set('ThisWeeksReservations', $reservations);
	}
	
	public function BindNextWeek($reservations)
	{
		$this->Set('NextWeeksReservations', $reservations);
	}
}

interface IUpcomingReservationsControl
{
	function SetTimezone($timezone);
	function SetTotal($total);
	function SetUserId($userId);

	function BindToday($reservations);
	function BindTomorrow($reservations);
	function BindThisWeek($reservations);
	function BindNextWeek($reservations);
}

?>