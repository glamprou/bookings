<?php

class ReservationInitializerFactory implements IReservationInitializerFactory
{
	/**
	 * @var ReservationUserBinder
	 */
	private $userBinder;

	/**
	 * @var ReservationDateBinder
	 */
	private $dateBinder;

	/**
	 * @var ReservationResourceBinder
	 */
	private $resourceBinder;

	/**
	 * @var UserSession
	 */
	private $user;

	/**
	 * @var IReservationAuthorization
	 */
	private $reservationAuthorization;

	/**
	 * @var IAttributeRepository
	 */
	private $attributeRepository;

	public function __construct(
		IScheduleRepository $scheduleRepository,
		IUserRepository $userRepository,
		IResourceService $resourceService,
		IReservationAuthorization $reservationAuthorization,
		IAttributeRepository $attributeRepository,
		UserSession $userSession
	)
	{
		$this->user = $userSession;
		$this->reservationAuthorization = $reservationAuthorization;
		$this->attributeRepository = $attributeRepository;

		$this->userBinder = new ReservationUserBinder($userRepository, $reservationAuthorization);
		$this->dateBinder = new ReservationDateBinder($scheduleRepository);
		$this->resourceBinder = new ReservationResourceBinder($resourceService);
	}

	public function GetNewInitializer(INewReservationPage $page)
	{
		return new NewReservationInitializer($page,
			$this->userBinder,
			$this->dateBinder,
			$this->resourceBinder,
			new ReservationCustomAttributeBinder($this->attributeRepository),
			$this->user);
	}

	public function GetExisitingInitializer(IExistingReservationPage $page, ReservationView $reservationView)
	{
		return new ExistingReservationInitializer($page,
			$this->userBinder,
			$this->dateBinder,
			$this->resourceBinder,
			new ReservationDetailsBinder($this->reservationAuthorization, $page, $reservationView, new PrivacyFilter($this->reservationAuthorization)),
			new ReservationCustomAttributeValueBinder($this->attributeRepository, $reservationView),
			$reservationView,
			$this->user);
	}
}

?>