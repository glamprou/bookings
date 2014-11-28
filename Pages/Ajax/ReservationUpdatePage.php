<?php

require_once(ROOT_DIR . 'Pages/Ajax/ReservationSavePage.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationPresenterFactory.php');
require_once(ROOT_DIR . 'config/config.php');

interface IReservationUpdatePage extends IReservationSavePage
{
	/**
	 * @return string
	 */
	public function GetReferenceNumber();

	/**
	 * @return SeriesUpdateScope
	 */
	public function GetSeriesUpdateScope();

	/*
	 * @return array|int[]
	 */
	public function GetRemovedAttachmentIds();
}

class ReservationUpdatePage extends ReservationSavePage implements IReservationUpdatePage
{
	/**
	 * @var ReservationUpdatePresenter
	 */
	private $_presenter;

	/**
	 * @var bool
	 */
	private $_reservationSavedSuccessfully = false;
	
    private $sameGame=FALSE;
    
	public function __construct()
	{
		parent::__construct();

		$factory = new ReservationPresenterFactory();
		$this->_presenter = $factory->Update($this, ServiceLocator::GetServer()->GetUserSession());
	}

	public function PageLoad()
	{
		try
		{//LOOKUP

			$reservation = $this->_presenter->BuildReservation();

            if(ServiceLocator::GetServer()->GetUserSession()->IsAdmin && empty($_POST['exceededQuotaAdminAck']) && empty($_POST['isTrainingCheckbox'])){
                $warning_message = $this->informAdminForExceededQuotas($reservation, $this->GetForm(FormKeys::PARTICIPANT_LIST));
                if($warning_message!==false){//there is a warning
                    $this->Set('warning_message',$warning_message);
                    $this->Display('Ajax/reservation/save_successful_part_notice.tpl');
                    exit;
                }
            }

            $this->isGame($reservation);//settarei me call_id i false to $this->callid
            $this->checkParticipantQuantity($reservation);

			$userrep=new UserRepository();
			$user = $userrep->LoadById($reservation->UserId());	

			$this->inTime($reservation);//set object-variable in_time value
			$this->ckeckInTime($reservation);//if user not admin or coach (if coach is capable of) and res is too soon, display error
			
			//$this->manageAttributes();////set attribute-object-variables values

            $this->checkTrainingParticipants($reservation);
			
			$participants_arr=$this->GetForm(FormKeys::PARTICIPANT_LIST);
			$seek_players = $_POST['ParticipantsNeeded'] && !$participants_arr  ? true : false;
            $storeAsOpen=false;

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
							$this->Set('predefined_hours',$predefined_hours);
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
                else{
                    $this->unsetAsOpen($reservation);
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
			Log::Error('ReservationUpdatePage - Critical error saving reservation: %s', $ex);
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
		$this->Set('Warnings', $warnings);
	}

	public function GetReservationId()
	{
		return $this->GetForm(FormKeys::RESERVATION_ID);
	}

	public function GetSeriesUpdateScope()
	{
		return $this->GetForm(FormKeys::SERIES_UPDATE_SCOPE);
	}

	public function GetRemovedAttachmentIds()
	{
		$fileIds = $this->GetForm(FormKeys::REMOVED_FILE_IDS);
		if (is_array($fileIds))
		{
			return array_keys($fileIds);
		}

		return array();
	}
	
	//function checkInTime:
	//return void
	//typwnei oti einai nwris gia edit i diagrafi kratisis (ean einai ontws) kai o xristis den einai admin i coach(an einai energi i epilogi)
	public function ckeckInTime($reservation){
		$userSession=ServiceLocator::GetServer()->GetUserSession();
		
		if($userSession->IsAdmin) return;
		
		if(!$this->in_time){
			if(!sp_too_soon_coach_edit() || !$userSession->IsCoach()){
                if(isset($_POST['isTrainingCheckbox']) && $_POST['isTrainingCheckbox']==='on'){
                    $trainingCancelled = $this->handleCancelledTraining($reservation);
                    if($trainingCancelled){
                        $this->ShowWarnings('Η προπόνηση έχει ακυρωθεί. Οι συμμετέχοντες θα ενημερωθούν με email'.(!empty($_POST['cancel-training-send-sms']) ? ' και με sms' : '').'.<br><br>Οποιαδήποτε άλλη αλλαγή που ενδεχομένως να έχει γίνει δεν έχει αποθηκευτεί. '.str_replace('{time_var}',sp_get_min_edit_time_seconds(true),Resources::GetInstance()->GetString('tooSoonToEditOrDeleteReservation')));
                        $this->Display('Ajax/reservation/save_failed.tpl');
                        exit;
                    }
                }
				$this->ShowErrors(str_replace('{time_var}',sp_get_min_edit_time_seconds(true),Resources::GetInstance()->GetString('tooSoonToEditOrDeleteReservation')));
				$this->Display('Ajax/reservation/save_failed.tpl');
				exit;
			}
		}
	}
    
    /**
     * An i kratisi einai idi game, epistrefei to call_id tis
     * Alliws FALSE
     * @param ExistingReservationSeries $reservation
     * @return int|FALSE
     */
    public function getCallId($reservation) {
        $rn=$reservation->CurrentInstance()->ReferenceNumber();
        $call=pdoq('select call_id from r_calls where reference_number=?',$rn);
        
        return ($call ? $call[0]->call_id : FALSE);
    }

    /**
     * Elegxei ama i kratisi afora call i oxi. Ean nai, apothikevei stin topiki metavliti callid to id tou call pou afora.
     * Alliws, apothikevei FALSE.
     * @return void
     */
    public function isGame($reservation){
        if(isset($_POST['chooseACall']) && $_POST['chooseACall']!='-1'){
            $callid=$_POST['chooseACall'];
            if(ctype_digit($callid)){
                $userid=ServiceLocator::GetServer()->GetUserSession()->UserId;
                $admin_priviledges = ServiceLocator::GetServer()->GetUserSession()->IsAdmin ? '1=1' : 'FALSE';

                $rn=$reservation->CurrentInstance()->ReferenceNumber();
                $callExists=pdoq("select call_id from r_calls where call_id=? and call_accepted=1 and (match_date IS NULL or reference_number=?) and (caller_user_id=? OR callee_user_id=? OR ?)",array($callid,$rn,$userid,$userid,$admin_priviledges));

                if($callExists){
                    $this->callid=(int)$callid;
                    return;
                }
            }
        }
        $this->callid=FALSE;
    }
    
    /**
     * An i kratisi itan i/kai tha ginei game, allazei katallilws ta reference_numbers 
     * kai ta match_dates apo ton pinaka r_calls
     * @param ExistingReservationSeries $reservation
     */
    public function handleCall($reservation) {
        $match_date=$reservation->CurrentInstance()->StartDate()->Format('Y-m-d');
        $rn=$reservation->CurrentInstance()->ReferenceNumber();
        
        $old_callid=$this->getCallId($reservation);
        $new_callid=$this->callid;
        
        $warnings=array();
        if($old_callid){
            pdoq('update r_calls set match_date=NULL, reference_number=NULL where call_id=?',$old_callid);
        }
        if($new_callid){
            pdoq('update r_calls set match_date=?, reference_number=? where call_id=?',array($match_date,$rn,$new_callid));
        }
        $this->ShowWarnings($warnings);
    }

    /**
     * apothikevei sto table reservation details
     * tis plirofories tis kratisis
     * @param $reservation ReservationSeries
     */
    public function handleReservationDetails($reservation){
		$detailExists=pdoq("select * from reservation_details where series_id=?", $reservation->SeriesId());
		if($detailExists){
			if(isset($_POST['isTrainingCheckbox']) && $_POST['isTrainingCheckbox']==='on'){
				pdoq("update reservation_details set particular_type='training', trainingType = ? where series_id=?", array(count($this->GetForm(FormKeys::PARTICIPANT_LIST)) > 1 ? 'Group' : 'Private', $reservation->SeriesId()));
	
				$this->handleCancelledTraining($reservation);
			}
			else{
				pdoq("update reservation_details set particular_type = NULL, cancelledTraining = NULL, trainingType = NULL where series_id=?", $reservation->SeriesId());
			}
		}
		else{
			if(isset($_POST['isTrainingCheckbox']) && $_POST['isTrainingCheckbox']==='on'){
				pdoq("insert into reservation_details (series_id, particular_type, trainingType) values (?,'training', ?)", array($reservation->SeriesId(), count($this->GetForm(FormKeys::PARTICIPANT_LIST)) > 1 ? 'Group' : 'Private'));

				$this->handleCancelledTraining($reservation);
			}
			else{
				pdoq("insert into reservation_details (series_id, particular_type) values (?,NULL)", $reservation->SeriesId());
			}
		}
    }

    public function handleCancelledTraining($reservation){
        if(!empty($_POST['cancel-training'])){
            pdoq("update reservation_details set cancelledTraining = ? where series_id=?", array($_POST['cancel-training-reason'], $reservation->SeriesId()));

            //send email & sms
            require_once(ROOT_DIR . 'lib/Email/Messages/CancelledTrainingEmail.php');
            require_once(ROOT_DIR . 'Ranking/functions.php');

            $participantIds = $reservation->CurrentInstance()->Participants();

            $userRepository = new UserRepository();
            foreach($participantIds as $partId){
                $participant = $userRepository->LoadById($partId);
                ServiceLocator::GetEmailService()->Send(new CancelledTrainingEmail($participant, $reservation));
//                //send sms
//                if($_POST['cancel-training-send-sms']){
//                    sms(null, $partId, 5, $reservation);
//                }
            }

            return true;
        }
        else{
            pdoq("update reservation_details set cancelledTraining = NULL where series_id=?", $reservation->SeriesId());
        }

        return false;
    }
}

?>