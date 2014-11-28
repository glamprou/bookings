<?php
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class CalendarSubscriptionPresenter
{
	/**
	 * @var ICalendarExportPage
	 */
	private $page;

	/**
	 * @var IReservationViewRepository
	 */
	private $reservationViewRepository;

	/**
	 * @var ICalendarExportValidator
	 */
	private $validator;

	/**
	 * @var ICalendarSubscriptionService
	 */
	private $subscriptionService;

	/**
	 * @var IPrivacyFilter
	 */
	private $privacyFilter;

	public function __construct(ICalendarSubscriptionPage $page,
								IReservationViewRepository $reservationViewRepository,
								ICalendarExportValidator $validator,
								ICalendarSubscriptionService $subscriptionService,
								IPrivacyFilter $filter)
	{
		$this->page = $page;
		$this->reservationViewRepository = $reservationViewRepository;
		$this->validator = $validator;
		$this->subscriptionService = $subscriptionService;
		$this->privacyFilter = $filter;
	}

	public function PageLoad()
	{
		if (!$this->validator->IsValid())
		{
			return;
		}

		$userId = $this->page->GetUserId();
		$scheduleId = $this->page->GetScheduleId();
		$resourceId = $this->page->GetResourceId();
		$accessoryIds = $this->page->GetAccessoryIds();

		$weekAgo = Date::Now()->AddDays(-7);
		$nextYear = Date::Now()->AddDays(365);

		$sid = null;
		$rid = null;
		$uid = null;
		$aid = null;

		$reservations = array();
		$res = array();
		if (!empty($scheduleId))
		{
			$schedule = $this->subscriptionService->GetSchedule($scheduleId);
			$sid = $schedule->GetId();
		}
		if (!empty($resourceId))
		{
			$resource = $this->subscriptionService->GetResource($resourceId);
			$rid = $resource->GetId();
		}
		if (!empty($accessoryIds))
		{
			## No transformation is implemented. It is assumed the accessoryIds is provided as AccessoryName 
			## filter is defined by LIKE "PATTERN%"  
			$aid = $accessoryIds;
		}
		if (!empty($userId))
		{
			$user = $this->subscriptionService->GetUser($userId);
			$uid = $user->Id();
		}

		if (!empty($uid) || !empty($sid) || !empty($rid))
		{
			$res = $this->reservationViewRepository->GetReservationList($weekAgo, $nextYear, $uid, null, $sid, $rid);
		}
		elseif (!empty($aid))
		{
			throw new Exception('need to give an accessory a public id, allow subscriptions');
			$res = $this->reservationViewRepository->GetAccessoryReservationList($weekAgo, $nextYear, $accessoryIds);
		}

		Log::Debug('Loading calendar subscription for userId %s, scheduleId %s, resourceId %s. Found %s reservations.',
				   $userId, $scheduleId, $resourceId, count($res));

		foreach ($res as $r)
		{
			$reservations[] = new iCalendarReservationView($r,
														   ServiceLocator::GetServer()->GetUserSession(),
														   $this->privacyFilter);
		}

		$this->page->SetReservations($reservations);
	}
}

?>