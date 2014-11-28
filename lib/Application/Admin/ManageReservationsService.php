<?php

interface IManageReservationsService
{
	/**
	 * @abstract
	 * @param $pageNumber int
	 * @param $pageSize int
	 * @param $filter ReservationFilter
	 * @param $user UserSession
	 * @return PageableData|ReservationItemView[]
	 */
	public function LoadFiltered($pageNumber, $pageSize, $filter, $user);
}

class ManageReservationsService implements IManageReservationsService
{
	/**
	 * @var IReservationViewRepository
	 */
	private $reservationViewRepository;

	public function __construct(IReservationViewRepository $reservationViewRepository)
	{
		$this->reservationViewRepository = $reservationViewRepository;
	}

	public function LoadFiltered($pageNumber, $pageSize, $filter, $user)
	{
		return $this->reservationViewRepository->GetList($pageNumber, $pageSize, null, null, $filter->GetFilter());
	}
}

?>