<?php
function is_free_group($groupid){	
	$row=pdoq("select free_of_charge from groups where group_id=?",$groupid);
	if($row){
        $row = $row[0];
        if($row->free_of_charge){
            return true;
        }
    }

    return false;
}

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Pages/Ajax/IReservationSaveResultsPage.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationPresenterFactory.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ReservationRuleResult.php');
require_once(ROOT_DIR . 'Domain/Access/UserRepository.php');

interface IReservationSavePage extends IReservationSaveResultsPage, IRepeatOptionsComposite
{
	/**
	 * @return int
	 */
	public function GetUserId();

	/**
	 * @return int
	 */
	public function GetResourceId();

	/**
	 * @return string
	 */
	public function GetTitle();

	/**
	 * @return string
	 */
	public function GetDescription();

	/**
	 * @return string
	 */
	public function GetStartDate();

	/**
	 * @return string
	 */
	public function GetEndDate();

	/**
	 * @return string
	 */
	public function GetStartTime();

	/**
	 * @return string
	 */
	public function GetEndTime();

	/**
	 * @return int[]
	 */
	public function GetResources();

	/**
	 * @abstract
	 * @return int[]
	 */
	public function GetParticipants();

	/**
	 * @abstract
	 * @return int[]
	 */
	public function GetInvitees();

	/**
	 * @param string $referenceNumber
	 */
	public function SetReferenceNumber($referenceNumber);

	/**
	 * @abstract
	 * @return AccessoryFormElement[]|array
	 */
	public function GetAccessories();

	/**
	 * @abstract
	 * @return AttributeFormElement[]|array
	 */
	public function GetAttributes();

	/**
	 * @abstract
	 * @return UploadedFile
	 */
	public function GetAttachment();

	/**
	 * @return bool
	 */
	public function HasStartReminder();

	/**
	 * @return string
	 */
	public function GetStartReminderValue();

	/**
	 * @return string
	 */
	public function GetStartReminderInterval();

	/**
	 * @return bool
	 */
	public function HasEndReminder();

	/**
	 * @return string
	 */
	public function GetEndReminderValue();

	/**
	 * @return string
	 */
	public function GetEndReminderInterval();
}

class ReservationSavePage extends SecurePage implements IReservationSavePage
{
	/**
	 * @var ReservationSavePresenter
	 */
	private $_presenter;

	/**
	 * @var bool
	 */
	private $_reservationSavedSuccessfully = false;
	
	/**
	 * 	string:
	 *	paid
	 *	not_paid
	 *	not_set
	 */
	public $paid;
	
	/**
	 * 	string: 
	 *	not_set
	 *	group
	 *	private
	 *	replacement
	 */
	public $training;
	
	/**
	 * 	boolean:
	 *	true an den einai nwritera apo min_edit_time
	 *	false an einai nwritera
	 */
	public $in_time;
    
    /**
     * An i kratisi afora call, tote i metavliti afti periexei to call_id. Alliws false
     * @var FALSE|int
     */
    public $callid=FALSE;

    
    public function __construct()
	{
		parent::__construct();

		$factory = new ReservationPresenterFactory();
		$this->_presenter = $factory->Create($this, ServiceLocator::GetServer()->GetUserSession());
	}

	public function PageLoad()
	{
		try
		{
			$reservation = $this->_presenter->BuildReservation();

            if(ServiceLocator::GetServer()->GetUserSession()->IsAdmin && empty($_POST['exceededQuotaAdminAck']) && empty($_POST['isTrainingCheckbox'])){
                $warning_message = $this->informAdminForExceededQuotas($reservation, $this->GetForm(FormKeys::PARTICIPANT_LIST));
                if($warning_message!==false){//there is a warning
                    $this->Set('warning_message',$warning_message);
                    $this->Display('Ajax/reservation/save_successful_part_notice.tpl');
                    exit;
                }
            }

            $this->isGame();
			$this->checkParticipantQuantity($reservation);

			$this->inTime($reservation);//set object-variable in_time value
			//$this->manageAttributes();//set attribute-object-variables values

			$this->checkTrainingParticipants($reservation);

			$participants_arr=$this->GetForm(FormKeys::PARTICIPANT_LIST);
			$seek_players = $_POST['ParticipantsNeeded'] && !$participants_arr  ? true : false;


			$userrep=new UserRepository();
			$user = $userrep->LoadById($reservation->UserId());

			//if no participants check for open reservation
			if($participants_arr){
				$GLOBALS['participants']=$participants_arr;
			}
			else{
				if(!$reservation->BookedBy()->IsAdmin){//not admin	
					if($this->in_time && $seek_players){//in time + seeking players				
						$storeAsOpen=true;
					}
					else{//telos ean apexei panw apo min_edit_time wres, tha dimiourgithei kratisi typou player-wanted
						if(!$seek_players){
							$this->Display('Ajax/reservation/save_update_participants_needed.tpl');
						}
						else{
							$this->Set('predefined_hours',sp_get_min_edit_time_seconds(true));
							$this->Display('Ajax/reservation/save_update_participants_needed_no_open.tpl');
						}
						exit;
					}
				}
				else{//admin
					if($seek_players){
						$storeAsOpen=true;
					}
				}
			}
			//ews edw

			$this->_presenter->HandleReservation($reservation);

			if ($this->_reservationSavedSuccessfully)
			{
                $this->handleCall($reservation);
                
				if($storeAsOpen){
					$this->setAsOpen($reservation);
				}		
				//eisagwgi olwn twn participants sto table
				if($participants_arr){			
					pdoq("delete from reservation_first_participant where reservation_series_id=?",$reservation->SeriesId());
                    foreach($participants_arr as $partId){
                        pdoq("insert into reservation_first_participant (reservation_series_id,user_id) values(?,?)",array($reservation->SeriesId(), $partId));
                    }
				}
				else{
					pdoq("delete from reservation_first_participant where reservation_series_id=?",$reservation->SeriesId());
				}
				//telos eisagwgis
				
				$this->handleReservationDetails($reservation);
				
				$this->setPaidCondition($reservation, $participants_arr, $user, $userrep);//ipologismos an einai xreiwsimi kai eisagwgi sti vasi tis katastasis plirwmis tis kratisis

                $this->Display('Ajax/reservation/save_successful.tpl');
			}
			else
			{
				$this->Display('Ajax/reservation/save_failed.tpl');
			}
		} catch (Exception $ex)
		{
			Log::Error('ReservationSavePage - Critical error saving reservation: %s', $ex);
			$this->Display('Ajax/reservation/reservation_error.tpl');
		}
	}

	public function SetSaveSuccessfulMessage($succeeded)
	{
		$this->_reservationSavedSuccessfully = $succeeded;
	}

	public function SetReferenceNumber($referenceNumber)
	{
		$this->Set('ReferenceNumber', $referenceNumber);
	}

	public function ShowErrors($errors)
	{
		$this->Set('Errors', $errors);
	}

	public function ShowWarnings($warnings)
	{
		// set warnings variable
	}

	public function GetReservationAction()
	{
		return $this->GetForm(FormKeys::RESERVATION_ACTION);
	}

	public function GetReferenceNumber()
	{
		return $this->GetForm(FormKeys::REFERENCE_NUMBER);
	}

	public function GetUserId()
	{
		return $this->GetForm(FormKeys::USER_ID);
	}

	public function GetResourceId()
	{
		return $this->GetForm(FormKeys::RESOURCE_ID);
	}

	public function GetTitle()
	{
		return $this->GetForm(FormKeys::RESERVATION_TITLE);
	}

	public function GetDescription()
	{
		return $this->GetForm(FormKeys::DESCRIPTION);
	}

	public function GetStartDate()
	{
		return $this->GetForm(FormKeys::BEGIN_DATE);
	}

	public function GetEndDate()
	{
		return $this->GetForm(FormKeys::END_DATE);
	}

	public function GetStartTime()
	{
		return $this->GetForm(FormKeys::BEGIN_PERIOD);
	}

	public function GetEndTime()
	{
		return $this->GetForm(FormKeys::END_PERIOD);
	}

	public function GetResources()
	{
		$resources = $this->GetForm(FormKeys::ADDITIONAL_RESOURCES);
		if (is_null($resources))
		{
			return array();
		}

		if (!is_array($resources))
		{
			return array($resources);
		}

		return $resources;
	}

	public function GetRepeatOptions()
	{
		return $this->_presenter->GetRepeatOptions();
	}

	public function GetRepeatType()
	{
		return $this->GetForm(FormKeys::REPEAT_OPTIONS);
	}

	public function GetRepeatInterval()
	{
		return $this->GetForm(FormKeys::REPEAT_EVERY);
	}

	public function GetRepeatWeekdays()
	{
		$days = array();

		$sun = $this->GetForm(FormKeys::REPEAT_SUNDAY);
		if (!empty($sun))
		{
			$days[] = 0;
		}

		$mon = $this->GetForm(FormKeys::REPEAT_MONDAY);
		if (!empty($mon))
		{
			$days[] = 1;
		}

		$tue = $this->GetForm(FormKeys::REPEAT_TUESDAY);
		if (!empty($tue))
		{
			$days[] = 2;
		}

		$wed = $this->GetForm(FormKeys::REPEAT_WEDNESDAY);
		if (!empty($wed))
		{
			$days[] = 3;
		}

		$thu = $this->GetForm(FormKeys::REPEAT_THURSDAY);
		if (!empty($thu))
		{
			$days[] = 4;
		}

		$fri = $this->GetForm(FormKeys::REPEAT_FRIDAY);
		if (!empty($fri))
		{
			$days[] = 5;
		}

		$sat = $this->GetForm(FormKeys::REPEAT_SATURDAY);
		if (!empty($sat))
		{
			$days[] = 6;
		}

		return $days;
	}

	public function GetRepeatMonthlyType()
	{
		return $this->GetForm(FormKeys::REPEAT_MONTHLY_TYPE);
	}

	public function GetRepeatTerminationDate()
	{
		return $this->GetForm(FormKeys::END_REPEAT_DATE);
	}

	public function GetSeriesUpdateScope()
	{
		return $this->GetForm(FormKeys::SERIES_UPDATE_SCOPE);
	}

	/**
	 * @return int[]
	 */
	public function GetParticipants()
	{
		$participants = $this->GetForm(FormKeys::PARTICIPANT_LIST);
		if (is_array($participants))
		{
			return $participants;
		}

		return array();
	}

	/**
	 * @return int[]
	 */
	public function GetInvitees()
	{
		$invitees = $this->GetForm(FormKeys::INVITATION_LIST);
		if (is_array($invitees))
		{
			return $invitees;
		}

		return array();
	}

	/**
	 * @return AccessoryFormElement[]
	 */
	public function GetAccessories()
	{
		$accessories = $this->GetForm(FormKeys::ACCESSORY_LIST);
		if (is_array($accessories))
		{
			$af = array();

			foreach ($accessories as $a)
			{
				$af[] = new AccessoryFormElement($a);
			}
			return $af;
		}

		return array();
	}

	/**
	 * @return AttributeFormElement[]|array
	 */
	public function GetAttributes()
	{
		return AttributeFormParser::GetAttributes($this->GetForm(FormKeys::ATTRIBUTE_PREFIX));
	}

	/**
	 * @return UploadedFile
	 */
	public function GetAttachment()
	{
		if ($this->AttachmentsEnabled())
		{
			return $this->server->GetFile(FormKeys::RESERVATION_FILE);
		}
		return null;
	}

	private function AttachmentsEnabled()
	{
		return Configuration::Instance()->GetSectionKey(ConfigSection::UPLOADS,
														ConfigKeys::UPLOAD_ENABLE_RESERVATION_ATTACHMENTS,
														new BooleanConverter());
	}

	/**
	 * @return bool
	 */
	public function HasStartReminder()
	{
		$val = $this->server->GetForm(FormKeys::START_REMINDER_ENABLED);
		return !empty($val);
	}

	/**
	 * @return string
	 */
	public function GetStartReminderValue()
	{
		return $this->server->GetForm(FormKeys::START_REMINDER_TIME);
	}

	/**
	 * @return string
	 */
	public function GetStartReminderInterval()
	{
		return $this->server->GetForm(FormKeys::START_REMINDER_INTERVAL);
	}

	/**
	 * @return bool
	 */
	public function HasEndReminder()
	{
		$val = $this->server->GetForm(FormKeys::END_REMINDER_ENABLED);
		return !empty($val);
	}

	/**
	 * @return string
	 */
	public function GetEndReminderValue()
	{
		return $this->server->GetForm(FormKeys::END_REMINDER_TIME);
	}

	/**
	 * @return string
	 */
	public function GetEndReminderInterval()
	{
		return $this->server->GetForm(FormKeys::END_REMINDER_INTERVAL);
	}
	
	
	//function manageAttributes
	//elegxei ta attribute gia 
	//-plirwmeni kratisi
	//-proponisi
	//
	//kai settarei tis metavlites paid kai training tou antikeimenou stis parakatw times:
	//paid: 	-paid
	//			-not_paid
	//			-not_set
	//		
	//training:	-not_set
	//			-group
	//			-private
	//			-replacement
	//LOOKUP
	public function manageAttributes(){
		$attributes=$_POST['psiattribute'];
		foreach($attributes as $attribute_id => $attribute_value){
			if($attribute_id==2){//unpaid attribute
				if($attribute_value==="NAI" || $attribute_value==="ΝΑΙ"){//set as paid
					$this->paid="not_paid";
				}
				else if($attribute_value==="OXI" || $attribute_value==="ΟΧΙ"){//set as unpaid
					$this->paid="paid";
				}
				else{//not set
					$this->paid="not_set";
				}
				
			}
			else if($attribute_id==3){//training attribute
				if($attribute_value==="group"){
					$this->training="group";
				}
				else if($attribute_value==="private"){
					$this->training="private";
				}
				else if($attribute_value==="replacement"){
					$this->training="replacement";
				}
				else{
					$this->training="not_set";
				}
			}
		}
	}

    /**
     * Elegxei an einai proponisi. Ean einai tote prepei participants >= 1. Ean oxi, display error
     */
    public function checkTrainingParticipants(){
        if($this->GetForm(FormKeys::TRAINING_CHECKED) && !$this->GetForm(FormKeys::PARTICIPANT_LIST)){
            $this->Set('Errors','Για προπόνηση παρακαλώ εισάγετε τουλάχιστον έναν συμμετέχοντα!');
            $this->Display('Ajax/reservation/save_failed.tpl');
            exit;
        }
	}
    
    /**
     * TODO: na ginei 1 sinartisi gia elegxo arithmou participant genikotera kai na antikatastathei to checkTrainingParticipants
     * Checkarei an se 1,5 wras slots simmetexoun 4 paixtes (double)
     * 
     * @param ReservationSeries $reservation
     */
    public function checkParticipantQuantity($reservation) {
        $difference_in_seconds=$reservation->CurrentInstance()->Duration()->GetBegin()->GetDifference($reservation->CurrentInstance()->Duration()->GetEnd())->TotalSeconds();
        $userSession=ServiceLocator::GetServer()->GetUserSession();
        if($difference_in_seconds==7200 && !$userSession->IsAdmin){//1misi wra kratisi mono gia doubles i gia ladder games
            if(count($this->GetForm(FormKeys::PARTICIPANT_LIST))!=3 && $this->callid===FALSE){
                $this->Set('Errors','Στο συγκεκριμένο γήπεδο επιτρέπονται μόνο τα διπλά. Παρακαλούμε προσθέστε ακριβώς 3 συμμετέχοντες.');
				$this->Display('Ajax/reservation/save_failed.tpl');
				exit;
            }
        }
    }

    /**
     * orizei tin metavliti in_time tou antikeimenou:
     * true - an oxi nwritera apo min_edit_time apo tin enarksi tis kratisis
     * false - diaforetika
     * @param ReservationSeries $reservation
     */
    public function inTime($reservation){
		$diff=$reservation->CurrentInstance()->StartDate()->ToUTC()->Timestamp()-(strtotime("now")+sp_get_min_edit_time_seconds()); 
		$this->in_time=$diff>0 ? true : false;
	}

    /**
     * @param $reservation ReservationSeries
     */
    public function setAsOpen($reservation){
        pdoq("delete from open_reservations where reference_number=?",$reservation->CurrentInstance()->ReferenceNumber());
        //to deadline einai tin proigoumeni mera tis kratisis, stis 12 to mesimeri
        $deadline=new Date($reservation->CurrentInstance()->StartDate()->GetDate()->RemoveMinutes(60*24)->Format('Y-m-d 12:00:00'), 'Europe/Athens');

        pdoq("insert into open_reservations (reference_number,deadline) values (?,?)",array($reservation->CurrentInstance()->ReferenceNumber(),$deadline->ToTimezone('UTC')));
    }

    public function unsetAsOpen($reservation){
        pdoq("delete from open_reservations where reference_number=?",$reservation->CurrentInstance()->ReferenceNumber());
    }

    /**
     * ipologizei kai eisagei sti vasi tin katastasi plirwmis tis kratisis
     * @param $reservation
     * @param $participants_arr
     * @param $user
     * @param $userrep
     */
    public function setPaidCondition($reservation, $participants_arr, $user, $userrep){
		if($participants_arr){	
			$to_be_charged1=true;
			$to_be_charged2=true;
			foreach($user->Groups() as $group){
				if(is_free_group($group->GroupId)){
					$to_be_charged1=false;
				}
			}
			foreach($participants_arr as $participants){
				$participant=$userrep->LoadById($participants);
				foreach($participant->Groups() as $group){
					if(is_free_group($group->GroupId)){
						$to_be_charged2=false;
					}
				}
				break;
			}
			$userSession=ServiceLocator::GetServer()->GetUserSession();
			pdoq("delete from custom_attribute_values where custom_attribute_id=2 and entity_id=?",$reservation->SeriesId());					
			if(false){//i kratisi einai xrewsimi
				if($this->paid==="paid" && $userSession->IsAdmin){//plirwthike
					pdoq("insert into custom_attribute_values (custom_attribute_id, attribute_value, entity_id, attribute_category) values (?,?,?,?)",array(2,'OXI',$reservation->SeriesId(),1));
				}
				else{
					pdoq("insert into custom_attribute_values (custom_attribute_id, attribute_value, entity_id, attribute_category) values (?,?,?,?)",array(2,'NAI',$reservation->SeriesId(),1));
				}
			}
			else{
				pdoq("insert into custom_attribute_values (custom_attribute_id, attribute_value, entity_id, attribute_category) values (?,?,?,?)",array(2,'',$reservation->SeriesId(),1));
			}
		}
	}

    /**
     * elegxos gia kseperasmeno quota twn participants se kratiseis tou admin kai enimerwsi tou
     * false an ola ok alliws string message
     * i kratisi ginetai kanonika (einai o admin)
     * @param $reservation
     * @param $participants_arr
     * @return false|string
     */
    public function informAdminForExceededQuotas($reservation, $participants_arr){
		$ownerExceeded=false;
		$participantExceeded=false;
        $numberOfExceeded = 0;

        require_once(ROOT_DIR.'Domain/Access/QuotaRepository.php');
        require_once(ROOT_DIR.'Domain/Access/UserRepository.php');
        require_once(ROOT_DIR.'Domain/Access/ScheduleRepository.php');
        require_once(ROOT_DIR.'Domain/Access/ReservationViewRepository.php');

        $warning_message='Προσοχή!';
        if($reservation->UserId()!=$reservation->BookedBy()->UserId){//an exei kleistei apo ton admin gia allo xristi, tha elegxthei k o xristis
            $quotaRepository=new QuotaRepository();
            $quotas = $quotaRepository->LoadAll();
            $userRepository=new UserRepository();
            $user = $userRepository->LoadById($reservation->UserId());
            $scheduleRepository=new ScheduleRepository();
            $schedule = $scheduleRepository->LoadById($reservation->ScheduleId());
            $reservationViewRepository=new ReservationViewRepository();
            foreach ($quotas as $quota){
                try{
                    $quota->ExceedsQuota($reservation, $user, $schedule, $reservationViewRepository);
                }
                catch(QuotaExceededException $ex){
                    if(!$ownerExceeded){
                        $warning_message.=' Ο '.$user->FullName();
                        $ownerExceeded=true;
                        $numberOfExceeded++;
                        break;//1 time per user
                    }
                }
            }
        }

		if($participants_arr){
			foreach($participants_arr as $key => $value){
				$quotaRepository=new QuotaRepository();
				$quotas = $quotaRepository->LoadAll();
				$userRepository=new UserRepository();
				$user = $userRepository->LoadById($value);
				$scheduleRepository=new ScheduleRepository();
				$schedule = $scheduleRepository->LoadById($reservation->ScheduleId());
				$reservationViewRepository=new ReservationViewRepository();

				foreach ($quotas as $quota){
                    try{
                        $quota->ExceedsQuota($reservation, $user, $schedule, $reservationViewRepository);
					}
                    catch(QuotaExceededException $ex){
                        if(!$ownerExceeded && !$participantExceeded){
                            $warning_message.=' O '.$user->FullName();
                        }
                        else{
                            $warning_message.=' και ο '.$user->FullName();
                        }
                        $participantExceeded=true;
                        $numberOfExceeded++;
                        break;//1 time per user
                    }
				}
			}
		}

		if(!$ownerExceeded && !$participantExceeded){
			return false;
		}
		else{
			if($numberOfExceeded > 1){
				$warning_message.=' έχουν ξεπεράσει το όριο κρατήσεων! Επιθυμείτε να συνεχίσετε;';
			}
			else{
				$warning_message.=' έχει ξεπεράσει το όριο κρατήσεων! Επιθυμείτε να συνεχίσετε;';
			}
			return $warning_message;
		}
	}
    
    /**
     * Elegxei ama i kratisi afora call i oxi. Ean nai, apothikevei stin topiki metavliti callid to id tou call pou afora.
     * Alliws, apothikevei FALSE.
     * @return void
     */
    public function isGame(){
        if(isset($_POST['chooseACall']) && $_POST['chooseACall']!='-1'){
            $callid=$_POST['chooseACall'];
            
            if(ctype_digit($callid)){
                $userid=ServiceLocator::GetServer()->GetUserSession()->UserId;
                $callExists=pdoq("select call_id from r_calls where call_id=? and call_accepted=1 and match_date IS NULL and (caller_user_id=? OR callee_user_id=?)",array($callid,$userid,$userid));
                if($callExists){
                    $this->callid=(int)$callid;
                    return;
                }
            }
        }
        $this->callid=FALSE;
    }
    
    /**
     * I sinartisi kaleitai efoson exei apothikeftei me epityxia to reservation kai enimerwnei to call me to match_date
     * @param ReservationSeries $reservation
     */
    public function handleCall($reservation) {
        if($this->callid){
            $match_date=$reservation->CurrentInstance()->StartDate()->Format('Y-m-d');
            $reference_number=$reservation->CurrentInstance()->ReferenceNumber();
            
            pdoq("update r_calls set match_date=?, reference_number=? where call_id=?",array($match_date, $reference_number,$this->callid));
        }
    }

    /**
     * apothikevei sto table reservation details
     * tis plirofories tis kratisis
     * @param $reservation ReservationSeries
     */
    public function handleReservationDetails($reservation){
        if(isset($_POST['isTrainingCheckbox']) && $_POST['isTrainingCheckbox']==='on'){
            pdoq("insert into reservation_details (series_id, particular_type, trainingType) values (?,'training', ?)", array($reservation->SeriesId(), count($this->GetForm(FormKeys::PARTICIPANT_LIST)) > 1 ? 'Group' : 'Private'));
        }
        else{
            pdoq("insert into reservation_details (series_id, particular_type) values (?,NULL)", $reservation->SeriesId());
        }
    }
}

class AccessoryFormElement
{
	public $Id;
	public $Quantity;

	public function __construct($formValue)
	{
		$idAndQuantity = $formValue;
		$y = explode('-', $idAndQuantity);
		$params = explode(',', $y[1]);
		$id = explode('=', $params[0]);
		$quantity = explode('=', $params[1]);
		$name = explode('=', $params[2]);

		$this->Id = $id[1];
		$this->Quantity = $quantity[1];
		$this->Name = urldecode($name[1]);
	}

	public static function Create($id, $quantity)
	{
		$element = new AccessoryFormElement("accessory-id=$id,quantity=$quantity,name=");
		return $element;
	}
}

?>