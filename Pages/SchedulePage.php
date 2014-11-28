<?php

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/SchedulePresenter.php');

interface ISchedulePage extends IActionPage
{
	/**
	 * Bind schedules to the page
	 *
	 * @param array|Schedule[] $schedules
	 */
	public function SetSchedules($schedules);

	/**
	 * Bind resources to the page
	 *
	 * @param arrayResourceDto[] $resources
	 */
	public function SetResources($resources);

	/**
	 * Bind layout to the page for daily time slot layouts
	 *
	 * @param IDailyLayout $dailyLayout
	 */
	public function SetDailyLayout($dailyLayout);

	/**
	 * Returns the currently selected scheduleId
	 * @return int
	 */
	public function GetScheduleId();

	/**
	 * @param int $scheduleId
	 */
	public function SetScheduleId($scheduleId);

	/**
	 * @param string $scheduleName
	 */
	public function SetScheduleName($scheduleName);

	/**
	 * @param int $firstWeekday
	 */
	public function SetFirstWeekday($firstWeekday);

	/**
	 * Sets the dates to be displayed for the schedule, adjusted for timezone if necessary
	 *
	 * @param DateRange $dates
	 */
	public function SetDisplayDates($dates);

	/**
	 * @param Date $previousDate
	 * @param Date $nextDate
	 */
	public function SetPreviousNextDates($previousDate, $nextDate);

	/**
	 * @return string
	 */
	public function GetSelectedDate();

	/**
	 * @abstract
	 */
	public function ShowInaccessibleResources();

	/**
	 * @abstract
	 * @param bool $showShowFullWeekToggle
	 */
	public function ShowFullWeekToggle($showShowFullWeekToggle);

	/**
	 * @abstract
	 * @return bool
	 */
	public function GetShowFullWeek();

	/**
	 * @param ScheduleLayoutSerializable $layoutResponse
	 */
	public function SetLayoutResponse($layoutResponse);

	/**
	 * @return string
	 */
	public function GetLayoutDate();

	/**
	 * @param int $scheduleId
	 * @return string|ScheduleDirection
	 */
	public function GetScheduleDirection($scheduleId);

	/**
	 * @param string|ScheduleDirection Direction
	 */
	public function SetScheduleDirection($direction);
}

class ScheduleDirection
{
	const vertical = 'vertical';
	const horizontal = 'horizontal';
}

class SchedulePage extends ActionPage implements ISchedulePage
{
	protected $scheduleDirection = ScheduleDirection::horizontal;

	/**
	 * @var SchedulePresenter
	 */
	protected $_presenter;

	public function __construct()
	{
		parent::__construct('Schedule');

		$permissionServiceFactory = new PermissionServiceFactory();
		$scheduleRepository = new ScheduleRepository();
		$resourceService = new ResourceService(new ResourceRepository(), $permissionServiceFactory->GetPermissionService());
		$pageBuilder = new SchedulePageBuilder();
		$reservationService = new ReservationService(new ReservationViewRepository(), new ReservationListingFactory());
		$dailyLayoutFactory = new DailyLayoutFactory();
		$this->_presenter = new SchedulePresenter($this, $scheduleRepository, $resourceService, $pageBuilder, $reservationService, $dailyLayoutFactory);
	}

	public function ProcessPageLoad()
	{
		$start = microtime(true);

		$user = ServiceLocator::GetServer()->GetUserSession();

		$this->_presenter->PageLoad($user);

		$endLoad = microtime(true);
		
		$this->SetImportantAnnouncements();
		
		$this->SetWeather();
        
        $this->IsCallRes();
		
		$this->Set('SlotLabelFactory', $user->IsAdmin ? new AdminSlotLabelFactory() : new SlotLabelFactory());
		$this->Set('DisplaySlotFactory', new DisplaySlotFactory());
		if ($this->scheduleDirection == ScheduleDirection::horizontal)
		{
			$this->Display('schedule.tpl');
		}
		else
		{
			$this->Display('schedule-flipped.tpl');
		}

		$endDisplay = microtime(true);

		$load = $endLoad - $start;
		$display = $endDisplay - $endLoad;
		Log::Debug('Schedule took %s sec to load, %s sec to render', $load, $display);
	}

	public function ProcessDataRequest($dataRequest)
	{
		$this->_presenter->GetLayout(ServiceLocator::GetServer()->GetUserSession());
	}

	public function GetScheduleId()
	{
		return $this->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
	}

	public function SetScheduleId($scheduleId)
	{
		$this->Set('ScheduleId', $scheduleId);
	}

	public function SetScheduleName($scheduleName)
	{
		$this->Set('ScheduleName', $scheduleName);
	}

	public function SetSchedules($schedules)
	{
		$this->Set('Schedules', $schedules);
	}
	
	public function SetFirstWeekday($firstWeekday)
	{
		$this->Set('FirstWeekday', $firstWeekday);
	}

	public function SetResources($resources)
	{
		$this->Set('Resources', $resources);
	}

	public function SetDailyLayout($dailyLayout)
	{
		$this->Set('DailyLayout', $dailyLayout);
	}

	public function SetDisplayDates($dateRange)
	{
		$this->Set('DisplayDates', $dateRange);
		$this->Set('BoundDates', $dateRange->Dates());
	}

	public function SetPreviousNextDates($previousDate, $nextDate)
	{
		$this->Set('PreviousDate', $previousDate);
		$this->Set('NextDate', $nextDate);
	}

	public function GetSelectedDate()
	{
		// TODO: Clean date
		return $this->server->GetQuerystring(QueryStringKeys::START_DATE);
	}

	public function ShowInaccessibleResources()
	{
		return Configuration::Instance()->GetSectionKey(ConfigSection::SCHEDULE,
														ConfigKeys::SCHEDULE_SHOW_INACCESSIBLE_RESOURCES,
														new BooleanConverter());
	}

	public function ShowFullWeekToggle($showShowFullWeekToggle)
	{
		$this->Set('ShowFullWeekLink', $showShowFullWeekToggle);
	}

	public function GetShowFullWeek()
	{
		$showFullWeek = $this->GetQuerystring(QueryStringKeys::SHOW_FULL_WEEK);

		return !empty($showFullWeek);
	}

	public function ProcessAction()
	{
		// no-op
	}

	public function SetLayoutResponse($layoutResponse)
	{
		$this->SetJson($layoutResponse);
	}

	public function GetLayoutDate()
	{
		return $this->GetQuerystring(QueryStringKeys::LAYOUT_DATE);
	}

	public function GetScheduleDirection($scheduleId)
	{
		$cookie = $this->server->GetCookie("schedule-direction-$scheduleId");
		if ($cookie != null)
		{
			return $cookie;
		}

		return ScheduleDirection::horizontal;
	}

	public function SetScheduleDirection($direction)
	{
		$this->scheduleDirection = $direction;
		$this->Set('CookieName', 'schedule-direction-' . $this->GetVar('ScheduleId'));
		$this->Set('CookieValue', $direction == ScheduleDirection::vertical ? ScheduleDirection::horizontal : ScheduleDirection::vertical);
	}

	//LOOKUP	
	//function SetImportantAnnouncements:
	//emfanisi simantikis anakoinwsis an xreiazetai k apothikefsi cookie oti emfanistike	
	public function SetImportantAnnouncements(){
		$today=date('Y-m-d');
		$rows=pdoq("select * from announcements where important=1 and start_date <= ? and end_date >= ? order by priority asc, announcementid desc limit 1",array($today,$today));
		
		if(count($rows)){
			if(!isset($_COOKIE['read_ann']) || $_COOKIE['read_ann']!=$rows[0]->announcementid){
				$this->Set('IsThereImportantAnnouncement', true);
				$this->Set('announcement_text', nl2br($rows[0]->announcement_text));
				$this->Set('announcement_cookie_val', $rows[0]->announcementid);
			}
		}
		else{
			$this->Set('IsThereImportantAnnouncement', false);
		}
	}
	
	//LOOKUP	
	//function SetWeather:
	//epeksergasia kairou k an xreiazetai emfanizei oti ta gipeda den paizontai
	public function SetWeather(){
		$resources = Resources::GetInstance();
		
		$row=pdoq("select * from w_clouds where now=1");
		
		$row1=pdoq("select * from w_winds where now=1");
		
		if(!$row[0]->playable || !$row1[0]->playable){
			$greek=new gr_el();
			$this->smarty->assign('show_weather', 1);
			$this->smarty->assign('weather', "<tr><td align='right'><b>".$resources->GetString("kairos")."</b></td><td width='10'></td><td align='right'><b>".$resources->GetString("aeras")."</b></td></tr><tr><td align='right'>".$row[0]->title."</td><td width='10'></td><td align='right'>".$row1[0]->title."</td></tr>");
			$this->smarty->assign('playable', $resources->GetString("unplayable_courts"));
		}
		else{
			$this->smarty->assign('show_weather', 0);
		}
	}
    
    /**
     * Elegxei an pame na kleisoume gipedo gia call, i aplo reservation
     * an einai gia call, apothikevei to call id k to pernaei stin epomeni selida
     * @return void
     */
    private function IsCallRes(){
        if(isset($_GET['call'])){
            $userid=ServiceLocator::GetServer()->GetUserSession()->UserId;
            $call=pdoq("select call_id from r_calls where call_id=? and call_accepted=1 and match_date IS NULL and (caller_user_id=? OR callee_user_id=?)",array((int)$_GET['call'],$userid,$userid));
            if($call){
                $this->Set('isCallRes', TRUE);
                $this->Set('callid', $call[0]->call_id);
                
                return;
            }
        }
        
        $this->Set('isCallRes', FALSE);
        $this->Set('callid', FALSE);
    }
}

class DisplaySlotFactory
{
	public function GetFunction(IReservationSlot $slot, $accessAllowed = false, $resource)
	{
		$slot->IsPending();
		if ($slot->IsReserved())
		{
            if($this->IsPaid($slot)){//an admin + paid
                return 'displayPaid';
            }

			if ($this->IsMyReservation($slot))
			{
				//elegxos an einai en anamoni paikti				
				$rows=pdoq("select * from open_reservations where reference_number=?",$slot->Id());
				if(count($rows)>0){
					return 'displayOpen';
				}
				//telos elegxos an einai en anamoni paikti
				return 'displayMyReserved';
			}
			elseif ($this->AmIParticipating($slot))
			{
				return 'displayMyParticipating';
			}
			else{
				//elegxos an einai en anamoni paikti				
				$rows=pdoq("select * from open_reservations where reference_number=?",$slot->Id());
				if(count($rows)>0){
					return 'displayOpen';
				}
				//telos elegxos an einai en anamoni paikti
				return 'displayReserved';
			}
		}
		else
		{
			if (!$accessAllowed)
			{
				return 'displayRestricted';
			}
			else
			{
				if ($slot->IsPastDate(Date::Now(), $resource) && !$this->UserHasAdminRights())
				{
					return 'displayPastTime';
				}
				else
				{
					if ($slot->IsReservable())
					{
						return 'displayReservable';
					}
					else
					{
						return 'displayUnreservable';
					}
				}
			}
		}

		return null;
	}

	private function UserHasAdminRights()
	{
		return ServiceLocator::GetServer()->GetUserSession()->IsAdmin;
	}

	private function IsMyReservation(IReservationSlot $slot)
	{
		$mySession = ServiceLocator::GetServer()->GetUserSession();
		return $slot->IsOwnedBy($mySession);
	}

	private function AmIParticipating(IReservationSlot $slot)
	{
		$mySession = ServiceLocator::GetServer()->GetUserSession();
		return $slot->IsParticipating($mySession);
	}

    private function IsPaid(IReservationSlot $slot)
    {
        return $slot->diplayAsPaid();
    }
}

?>