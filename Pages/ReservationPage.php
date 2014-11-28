<?php

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationPresenter.php');

interface IReservationPage extends IPage
{
	/**
	 * Set the schedule period items to be used when presenting reservations
	 * @param $startPeriods array|SchedulePeriod[]
	 * @param $endPeriods array|SchedulePeriod[]
	 */
	function BindPeriods($startPeriods, $endPeriods);

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
	 * @param bool $showReservationDetails
	 */
	function ShowReservationDetails($showReservationDetails);

	/**
	 * @abstract
	 * @param $attributes array|Attribute[]
	 */
	function SetCustomAttributes($attributes);

	/**
	 * @abstract
	 * @param bool $isHidden
	 */
	function HideRecurrence($isHidden);
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

		if (is_null($this->permissionServiceFactory))
		{
			$this->permissionServiceFactory = new PermissionServiceFactory();
		}

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
		$this->Set('ReservationAction', $this->GetReservationAction());
		$this->Set('MaxUploadSize', UploadedFile::GetMaxSize());
		$this->Set('UploadsEnabled', Configuration::Instance()->GetSectionKey(ConfigSection::UPLOADS,
																			  ConfigKeys::UPLOAD_ENABLE_RESERVATION_ATTACHMENTS,
																			  new BooleanConverter()));
		$this->Set('ShowParticipation', !Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION,
																				  ConfigKeys::RESERVATION_PREVENT_PARTICIPATION,
																				  new BooleanConverter()));
		$remindersEnabled = Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION,
																	 ConfigKeys::RESERVATION_REMINDERS_ENABLED,
																	 new BooleanConverter());
		$emailEnabled = Configuration::Instance()->GetKey(ConfigKeys::ENABLE_EMAIL,
														  new BooleanConverter());
		$this->Set('RemindersEnabled', $remindersEnabled && $emailEnabled);

		$this->Set('RepeatEveryOptions', range(1, 20));
		$this->Set('RepeatOptions', array(
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
		
		
		//elegxos an einai player wanted kai an einai, emfanisi koumpiou gia simmetoxi
		if(isset($_GET['rn']) && $_GET['rn']!=''){
			$reference_number=$_GET['rn'];
			
			$reservation_repository=new ReservationRepository();
			$series=$reservation_repository->LoadByReferenceNumber($reference_number);
			$reservation=$series->GetInstance($reference_number);
			
			
			$row=pdoq("select min_edit_time_seconds from system_preferences where id=?",1);

			//an i kratisi ksekinaei se perissotero apo ton prokathorismeno xrono, mporei na akyrwsei tin symmetoxi tou o participant 
			if(($reservation->StartDate()->ToTimezone(Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE))->Timestamp()-strtotime('now'))>$row[0]->min_edit_time_seconds){
				$this->Set('moreThanThreeHours', true);
			}
			else{
				$this->Set('moreThanThreeHours', false);
			}
			
			$row=pdoq("select * from open_reservations where reference_number=?",$reference_number);
			if(count($row)>0 && $reservation->EndDate()->ToTimezone(Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE))->Compare(new Date())==1){//is open and is not past date
				$this->Set('checkOpenReservationCheckbox', true);
				$this->Set('isReservationOpen', true);
			}
			else{
				$this->Set('checkOpenReservationCheckbox', false);
				$this->Set('isReservationOpen', false);
			}
			
			//manipulate training checkbox and radio buttons
//			$row=pdoq("select * from is_training where series_id=?",$series->SeriesId());
//			if(count($row)){//is training
//				$this->Set('isTrainingChecked', true);
//				if($row[0]->training_type=="group"){
//					$this->Set('isGroupTraining', true);
//				}
//				else if($row[0]->training_type=="private"){
//					$this->Set('isPrivateTraining', true);
//				}
//				else if($row[0]->training_type=="replacement"){
//					$this->Set('isReplacementTraining', true);
//				}
//			}
		}
		else{
			$row=pdoq("select min_edit_time_seconds from system_preferences where id=?",1);
			
			if(($this->GetStartDate()->Timestamp()-strtotime('now'))>$row[0]->min_edit_time_seconds){
				$this->Set('moreThanThreeHours', true);
			}
			else{
				$this->Set('moreThanThreeHours', false);
			}
		}
		//telos elegxos an einai player wanted kai an einai, emfanisi koumpiou gia simmetoxi
		
		//is coach or admin? If yes, hide player wanted checkbox
		$userSession=ServiceLocator::GetServer()->GetUserSession();
		$this->Set('IsAdmin', $userSession->IsAdmin);

		$this->Set('IsCoach', $userSession->IsCoach());
		//

        $this->handleCallSelection();
        
		$this->Display($this->GetTemplateName());
	}

	public function BindPeriods($startPeriods, $endPeriods)
	{
		$this->Set('StartPeriods', $startPeriods);
		$this->Set('EndPeriods', $endPeriods);
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

	public function ShowReservationDetails($showReservationDetails)
	{
		$this->Set('ShowReservationDetails', $showReservationDetails);
	}

	public function SetCustomAttributes($attributes)
	{
		$this->Set('Attributes', $attributes);
	}

	public function HideRecurrence($isHidden)
	{
		$this->Set('HideRecurrence', $isHidden);
	}
}

?>