<?php
 

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationPresenter.php');

interface IReservationPage extends IPage
{
	/**
	 * Set the schedule period items to be used when presenting reservations
	 * @param $periods array|ISchedulePeriod[]
	 */
	function BindPeriods($periods);
	
	/**
	 * Set the resources that can be reserved by this user
	 * @param $resources array|ResourceDto[]
	 */
	function BindAvailableResources($resources);

	/**
	 * @abstract
	 * @param $accessories array|AccessoryDto[]
	 * @return void
	 */
	function BindAvailableAccessories($accessories);

	/**
	 * @param SchedulePeriod $selectedStart
	 * @param Date $startDate
	 */
	function SetSelectedStart(SchedulePeriod $selectedStart, Date $startDate);
	
	/**
	 * @param SchedulePeriod $selectedEnd
	 * @param Date $endDate
	 */
	function SetSelectedEnd(SchedulePeriod $selectedEnd, Date $endDate);
	
	/**
	 * @param $repeatTerminationDate Date
	 */
	function SetRepeatTerminationDate($repeatTerminationDate);
	
	/**
	 * @param UserDto $user
	 */
	function SetReservationUser(UserDto $user);
	
	/**
	 * @param ResourceDto $resource
	 */
	function SetReservationResource($resource);

	/**
	 * @param int $scheduleId
	 */
	function SetScheduleId($scheduleId);

	/**
	 * @abstract
	 * @param ReservationUserView[] $participants
	 * @return void
	 */
	function SetParticipants($participants);

	/**
	 * @abstract
	 * @param ReservationUserView[] $invitees
	 * @return void
	 */
	function SetInvitees($invitees);

	/**
	 * @abstract
	 * @param $accessories ReservationAccessory[]|array
	 * @return void
	 */
	function SetAccessories($accessories);

	/**
	 * @abstract
	 * @param $attachments ReservationAttachmentView[]|array
	 * @return void
	 */
	function SetAttachments($attachments);

	/**
	 * @abstract
	 * @param $canChangeUser
	 * @return void
	 */
	function SetCanChangeUser($canChangeUser);

    /**
     * @abstract
     * @param bool $canShowAdditionalResources
     */
	function ShowAdditionalResources($canShowAdditionalResources);

    /**
     * @abstract
     * @param bool $canShowUserDetails
     */
    function ShowUserDetails($canShowUserDetails);

	/**
	 * @abstract
	 * @param $attributes array|Attribute[]
	 */
	function SetCustomAttributes($attributes);
}

abstract class ReservationPage extends Page implements IReservationPage
{
	protected $presenter;
	/**
	 * @var PermissionServiceFactory
	 */
	protected $permissionServiceFactory;

	/**
	 * @var ReservationInitializerFactory
	 */
	protected $initializationFactory;
	
	public function __construct($title = null)
	{
		parent::__construct($title);
		
		$this->permissionServiceFactory = new PermissionServiceFactory();

		$this->initializationFactory = new ReservationInitializerFactory(
			new ScheduleRepository(),
			new UserRepository(),
			new ResourceService(new ResourceRepository(), $this->permissionServiceFactory->GetPermissionService()),
			new ReservationAuthorization(AuthorizationServiceFactory::GetAuthorizationService()),
			new AttributeRepository(),
			ServiceLocator::GetServer()->GetUserSession()
			);

		$this->presenter = $this->GetPresenter();
	}
	
	/**
	 * @return IReservationPresenter
	 */
	protected abstract function GetPresenter();
	
	/**
	 * @return string
	 */
	protected abstract function GetTemplateName();
	
	/**
	 * @return string
	 */
	protected abstract function GetReservationAction();
		
	public function PageLoad()
	{
		$this->presenter->PageLoad();
		$this->Set('ReturnUrl', $this->GetLastPage(Pages::SCHEDULE));
		$this->Set('RepeatEveryOptions', range(1, 20));
		$this->Set('RepeatOptions', array (
						'none' => array('key' => 'DoesNotRepeat', 'everyKey' => ''),
						'daily' => array('key' => 'Daily', 'everyKey' => 'days'),
						'weekly' => array('key' => 'Weekly', 'everyKey' => 'weeks'),
						'monthly' => array('key' => 'Monthly', 'everyKey' => 'months'),
						'yearly' => array('key' => 'Yearly', 'everyKey' => 'years'),
								)
		);
		$this->Set('DayNames', array(
								0 => 'DaySundayAbbr',
								1 => 'DayMondayAbbr',
								2 => 'DayTuesdayAbbr',
								3 => 'DayWednesdayAbbr',
								4 => 'DayThursdayAbbr',
								5 => 'DayFridayAbbr',
								6 => 'DaySaturdayAbbr',
								)
		);
		$this->Set('ReservationAction', $this->GetReservationAction());
		$this->Set('MaxUploadSize', UploadedFile::GetMaxSize());
		$this->Set('UploadsEnabled', Configuration::Instance()->GetSectionKey(ConfigSection::UPLOADS, ConfigKeys::UPLOAD_ENABLE_RESERVATION_ATTACHMENTS, new BooleanConverter()));
		include_once('../Web/inc/config.php');	
		//include_once('../Web/functions.php');
		
		
		
		
		$res=mysql_query("select  r_calls.call_id,users.fname,users.lname,users.user_id from r_calls inner join users on (r_calls.caller_user_id=users.user_id) or (r_calls.callee_user_id=users.user_id ) where ((r_calls.caller_user_id=$userid or r_calls.callee_user_id=$userid) and (r_calls.call_accepted=1 and r_calls.call_completed=0) and (r_calls.match_date='0000-00-00'))");
		$i=0;
		$calls=array();
		if(isset($_GET['call'])){
			$defCall=$_GET['call'];
			$this->Set('defCall', $defCall);
		}
		while ($row=mysql_fetch_object($res)){
			if ($row->user_id==$userid)
				continue;
			$calls[$row->call_id]="vs ".$row->fname." ".$row->lname;
			$i++;
		}
		if($i!=0){
			$this->Set('calls', $calls);
		}
		$classofexisting='ExistingReservationPage';
		if($this instanceof $classofexisting){
			//existing reservation
			$res=mysql_query("select series_id from reservation_instances where reference_number='".$this->GetReferenceNumber()."'");
			if($row=mysql_fetch_object($res)){
				$res1=mysql_query("select attribute_value,entity_id from custom_attribute_values where entity_id=".$row->series_id);
				if($row1=mysql_fetch_object($res1)){
					if($row1->attribute_value=="true"){
						$res2=mysql_query("select call_id from r_call_entity_id where entity_id=".$row1->entity_id);
						if($row2=mysql_fetch_object($res2)){
							$calls=array();
							$defCall=$row2->call_id;
							$this->Set('defCall', $defCall);
							$res3=mysql_query("select  users.fname,users.lname,users.user_id from users inner join r_calls on (r_calls.caller_user_id=users.user_id) or (r_calls.callee_user_id=users.user_id ) where call_id=".$row2->call_id);
							while($row3=mysql_fetch_object($res3)){
								if ($row3->user_id==$userid)
									continue;
								$calls[$row2->call_id]="vs ".$row3->fname." ".$row3->lname;
							}							
							$this->Set('calls', $calls);
							$this->Set('onlyone', 'true');
						}
					}
				}
			}
		}
		$this->Display($this->GetTemplateName());
	}
	
	public function BindPeriods($periods)
	{
		$this->Set('Periods', $periods);
	}
	
	public function BindAvailableResources($resources)
	{
		$this->Set('AvailableResources', $resources);
	}

	public function ShowAdditionalResources($shouldShow)
	{
		$this->Set('ShowAdditionalResources', $shouldShow);
	}

	public function BindAvailableAccessories($accessories)
	{
		$this->Set('AvailableAccessories', $accessories);
	}
	
	public function SetSelectedStart(SchedulePeriod $selectedStart, Date $startDate)
	{
		$this->Set('SelectedStart', $selectedStart);
		$this->Set('StartDate', $startDate);
	}
	
	public function SetSelectedEnd(SchedulePeriod $selectedEnd, Date $endDate)
	{
		$this->Set('SelectedEnd', $selectedEnd);
		$this->Set('EndDate', $endDate);
	}

	/**
	 * @param UserDto $user
	 * @return void
	 */
	public function SetReservationUser(UserDto $user)
	{
		$this->Set('ReservationUserName', $user->FullName());
		$this->Set('UserId', $user->Id());
	}
	
	/**
	 * @param $resource ResourceDto
	 * @return void
	 */
	public function SetReservationResource($resource)
	{
		$this->Set('ResourceName', $resource->Name);
		$this->Set('ResourceId', $resource->Id);
	}
	
	public function SetScheduleId($scheduleId)
	{
		$this->Set('ScheduleId', $scheduleId);
	}
	
	public function SetRepeatTerminationDate($repeatTerminationDate)
	{
		$this->Set('RepeatTerminationDate', $repeatTerminationDate);
	}

	public function SetParticipants($participants)
	{
		$this->Set('Participants', $participants);
	}

	public function SetInvitees($invitees)
	{
		$this->Set('Invitees', $invitees);
	}

	public function SetAccessories($accessories)
	{
		$this->Set('Accessories', $accessories);
	}

	public function SetAttachments($attachments)
	{
		$this->Set('Attachments', $attachments);
	}

	public function SetCanChangeUser($canChangeUser)
	{
		$this->Set('CanChangeUser', $canChangeUser);
	}

    public function ShowUserDetails($canShowUserDetails)
    {
        $this->Set('ShowUserDetails', $canShowUserDetails);
    }

	public function SetCustomAttributes($attributes)
	{
		$this->Set('Attributes', $attributes);
	}
}
?>