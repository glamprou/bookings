<?php

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');

class PersonalCalendarActions
{
    const ActionEnableSubscription = 'enable';
    const ActionDisableSubscription = 'disable';
}

class PersonalCalendarPresenter extends ActionPresenter
{
	/**
	 * @var \IPersonalCalendarPage
	 */
	private $page;

	/**
	 * @var \IReservationViewRepository
	 */
	private $repository;

	/**
	 * @var \ICalendarFactory
	 */
	private $calendarFactory;

    /**
     * @var ICalendarSubscriptionService
     */
    private $subscriptionService;

    /**
     * @var IUserRepository
     */
    private $userRepository;

	public function __construct(
        IPersonalCalendarPage $page,
        IReservationViewRepository $repository,
        ICalendarFactory $calendarFactory,
        ICalendarSubscriptionService $subscriptionService,
        IUserRepository $userRepository)
	{
        parent::__construct($page);

		$this->page = $page;
		$this->repository = $repository;
		$this->calendarFactory = $calendarFactory;
		$this->subscriptionService = $subscriptionService;
		$this->userRepository = $userRepository;

        $this->AddAction(PersonalCalendarActions::ActionEnableSubscription, 'EnableSubscription');
        $this->AddAction(PersonalCalendarActions::ActionDisableSubscription, 'DisableSubscription');
	}
	
	public function PageLoad($userId, $timezone)
	{
		$type = $this->page->GetCalendarType();

		$year = $this->page->GetYear();
		$month = $this->page->GetMonth();
		$day = $this->page->GetDay();

		$defaultDate = Date::Now()->ToTimezone($timezone);
		
		if (empty($year))
		{
			$year = $defaultDate->Year();
		}
		if (empty($month))
		{
			$month = $defaultDate->Month();
		}
		if (empty($day))
		{
			$day = $defaultDate->Day();
		}

		$calendar = $this->calendarFactory->Create($type, $year, $month, $day, $timezone);
		$reservations = $this->repository->GetReservationList($calendar->FirstDay(), $calendar->LastDay(), $userId, ReservationUserLevel::ALL);
		$calendar->AddReservations(CalendarReservation::FromViewList($reservations, $timezone));
		$this->page->BindCalendar($calendar);

		$this->page->SetDisplayDate($calendar->FirstDay());

        $details = $this->subscriptionService->ForUser($userId);
        $this->page->BindSubscription($details);
	}

    public function EnableSubscription()
    {
        $userId = ServiceLocator::GetServer()->GetUserSession()->UserId;
        Log::Debug('Enabling calendar subscription for userId: %s', $userId);

        $user = $this->userRepository->LoadById($userId);
        $user->EnableSubscription();
        $this->userRepository->Update($user);
    }

    public function DisableSubscription()
    {
        $userId = ServiceLocator::GetServer()->GetUserSession()->UserId;
        Log::Debug('Disabling calendar subscription for userId: %s', $userId);

        $user = $this->userRepository->LoadById($userId);
        $user->DisableSubscription();
        $this->userRepository->Update($user);
    }
}
?>