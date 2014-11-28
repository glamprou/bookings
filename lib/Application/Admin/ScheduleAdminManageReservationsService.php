<?php


class ScheduleAdminManageReservationsService implements IManageReservationsService
{
	/**
	 * @var IReservationViewRepository
	 */
	private $reservationViewRepository;

	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	public function __construct(IReservationViewRepository $reservationViewRepository, IUserRepository $userRepository)
	{
		$this->reservationViewRepository = $reservationViewRepository;
		$this->userRepository = $userRepository;
	}

	/**
	 * @param $pageNumber int
	 * @param $pageSize int
	 * @param $filter ReservationFilter
	 * @param $user UserSession
	 * @return PageableData|ReservationItemView[]
	 */
	public function LoadFiltered($pageNumber, $pageSize, $filter, $user)
	{
		$groupIds = array();
		$groups = $this->userRepository->LoadGroups($user->UserId, RoleLevel::SCHEDULE_ADMIN);
		foreach ($groups as $group)
		{
			$groupIds[] = $group->GroupId;
		}

		$filter->_And(new SqlFilterIn(new SqlFilterColumn(TableNames::SCHEDULES, ColumnNames::SCHEDULE_ADMIN_GROUP_ID), $groupIds));
		return $this->reservationViewRepository->GetList($pageNumber, $pageSize, null, null, $filter->GetFilter());
	}
}

?>