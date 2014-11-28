<?php
class resObject{
	public $owner;
	public $participants=array();
}

class QuotaRule implements IReservationValidationRule
{
	/**
	 * @var \IQuotaRepository
	 */
	private $quotaRepository;

	/**
	 * @var \IReservationViewRepository
	 */
	private $reservationViewRepository;

	/**
	 * @var \IUserRepository
	 */
	private $userRepository;

	/**
	 * @var \IScheduleRepository
	 */
	private $scheduleRepository;

	public function __construct(IQuotaRepository $quotaRepository, IReservationViewRepository $reservationViewRepository, IUserRepository $userRepository, IScheduleRepository $scheduleRepository)
	{
		$this->quotaRepository = $quotaRepository;
		$this->reservationViewRepository = $reservationViewRepository;
		$this->userRepository = $userRepository;
		$this->scheduleRepository = $scheduleRepository;
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
		$quotas = $this->quotaRepository->LoadAll();
		$user = $this->userRepository->LoadById($reservationSeries->UserId());
		$schedule = $this->scheduleRepository->LoadById($reservationSeries->ScheduleId());
        if(!ServiceLocator::GetServer()->GetUserSession()->IsCoach() || empty($_POST['isTrainingCheckbox'])){
            foreach ($quotas as $quota)
            {
                try{
                    $quota->ExceedsQuota($reservationSeries, $user, $schedule, $this->reservationViewRepository);
                }
                catch(QuotaExceededException $ex){
                    return new ReservationRuleResult(false, $this->createExceptionMessage('current', $ex->getMessage(), $quota));
                }
            }

            //check participants quotas
            if(count($GLOBALS['participants'])>0){
                foreach($GLOBALS['participants'] as $participantId){
                    $quotas = $this->quotaRepository->LoadAll();
                    $user = $this->userRepository->LoadById($participantId);
                    $schedule = $this->scheduleRepository->LoadById($reservationSeries->ScheduleId());

                    foreach ($quotas as $quota)
                    {
                        try{
                            $quota->ExceedsQuota($reservationSeries, $user, $schedule, $this->reservationViewRepository);
                        }
                        catch(QuotaExceededException $ex){
                            return new ReservationRuleResult(false, $this->createExceptionMessage($user, $ex->getMessage(), $quota));
                        }
                    }
                }
            }
        }

		
		//elegxos gia ofeiles k an epitrepetai na ginei i kratisi i oxi				
		$tmp=array();
		$rows=pdoq("select * from reservation_series where status_id=1");//epilogi mono twn energwn series
		
		foreach($rows as $row){
			$tmp[]=$row->series_id;
		}
		$tmp=implode(",",$tmp);
		$instances=array();
		$unpaid_series=array();
		if($tmp=='') $tmp='-9999';
		$rows=pdoq("select ri.reservation_instance_id, ri.series_id from reservation_instances ri inner join custom_attribute_values av on ri.series_id=av.entity_id where av.custom_attribute_id=2 and av.attribute_value='NAI' and av.entity_id IN ($tmp)");
		if(is_a($reservationSeries,'ExistingReservationSeries')){//i sigkekrimeni kratisi den prepei na ipologistei. arkei oi ypoloipes na einai < 2
				if($reservationSeries->SeriesId()!=''){
					$rows=pdoq("select ri.reservation_instance_id, ri.series_id from reservation_instances ri inner join custom_attribute_values av on ri.series_id=av.entity_id where ri.series_id	<> ? and av.custom_attribute_id=2 and av.attribute_value='NAI' and av.entity_id IN ($tmp)",$reservationSeries->SeriesId());
				}
		}
		foreach($rows as $row){//epilogi twn instances_ids apo ta energa series
			$instances[]=$row->reservation_instance_id;
			$unpaid_series[]=$row->series_id;
		}
		
		$tmp=implode(",",$instances);
		if($tmp=='') $tmp='-9999';
		$rows1=pdoq("select * from reservation_users where reservation_instance_id IN ($tmp)");//evresi kai epilogi twn owners twn parapanw
		$users=array();
		$all_reservations=array();
		foreach($rows1 as $row1){
			if(!isset($all_reservations[$row1->reservation_instance_id])){
				$all_reservations[$row1->reservation_instance_id]=new resObject();
				
			}
			if($row1->reservation_user_level==1){//owner
				$all_reservations[$row1->reservation_instance_id]->owner=$row1->user_id;
			}
			else{//participant
				$all_reservations[$row1->reservation_instance_id]->participants[]=$row1->user_id;
			}
		}
	
		foreach($all_reservations as $res){
			$guest=false;
			//participant handling
			foreach($res->participants as $participant){
				$cur_user=$this->userRepository->LoadById($participant);
				foreach($cur_user->Groups() as $group){
					if(!is_free_group($group->GroupId)){//einai Mx
						if(!isset($users[$participant])){
							$users[$participant]=1;
						}
						else{
							$users[$participant]++;
						}
					}
					if($group->GroupId==8 || $group->GroupId==14){
						$guest=true;
					}
				}
			}
			
			//owner handling
			$cur_user=$this->userRepository->LoadById($res->owner);
			foreach($cur_user->Groups() as $group){
				if(!is_free_group($group->GroupId)){//einai Mx
					if(!isset($users[$res->owner])){
						$users[$res->owner]=1;
					}
					else{
						$users[$res->owner]++;
					}
				}
				if(is_free_group($group->GroupId) && $guest){//einai M1 alla iparxei guest
					if(!isset($users[$res->owner])){
						$users[$res->owner]=1;
					}
					else{
						$users[$res->owner]++;
					}
				}
			}
		}
		$res_owner = $this->userRepository->LoadById($reservationSeries->UserId());
		////////////////////////
		$max_unpaid_allowed=20;//
		////////////////////////
		
		foreach($res_owner->Groups() as $group){//elegxos tou owner
			if($group->GroupId==10){//einai coach. ara max_unpaid_allowed=20
				$max_unpaid_allowed=20;
			}
		}
		$passed=true;
		$problem_users=array();
		
		//elegxos an iparxei guest stin sigkekrimeni kratisi
		$there_is_guest=false;
		if($GLOBALS['participants']){
			foreach($GLOBALS['participants'] as $key => $userid){
				$this_is_guest=true;
				$cur_user=$this->userRepository->LoadById($userid);
				$loops=0;
				foreach($cur_user->Groups() as $group){
					if($group->GroupId!=8 && $group->GroupId!=14){
						$this_is_guest=false;
					}
					$loops++;
				}
				if($this_is_guest && $loops>0){
					$there_is_guest=true;
					break;
				}
			}
		}
		//telos elegxos an iparxei guest stin sigkekrimeni kratisi
	
		//evresi gia to poioi xrewnontai stin sigkekrimeni kratisi
		$charged_users=array();
		foreach($res_owner->Groups() as $group){//elegxos tou owner
			if(is_free_group($group->GroupId)){//einai M1 alla iparxei guest
				if($there_is_guest){
					$charged_users[]=$res_owner;
				}
			}
			else{
				$charged_users[]=$res_owner;
			}
		}
        foreach((array)$GLOBALS['participants'] as $key => $userid){//elegxos twn participants
            $cur_user=$this->userRepository->LoadById($userid);
            foreach($cur_user->Groups() as $group){
                if(!is_free_group($group->GroupId)){//einai Mx
                    if(!in_array($cur_user,$charged_users,true)){
                        $charged_users[]=$cur_user;
                    }
                }
            }
        }
		//telos evresi gia to poioi xrewnontai stin sigkekrimeni kratisi
		foreach($users as $userid => $unpaid){
			if($userid==$res_owner->Id()){//einai owner
				if($unpaid>=$max_unpaid_allowed){				
					$cur_user=$this->userRepository->LoadById($userid);
					if(in_array($cur_user,$charged_users,true)){//ean xrewnetai k einai sto orio
						$problem_users[]=$cur_user->FullName();
						$passed=false;
					}
				}
			}
			if(in_array($userid,$GLOBALS['participants'])){//einai participant
				if($unpaid>=$max_unpaid_allowed){	
					$cur_user=$this->userRepository->LoadById($userid);
					$isGuest=false;
					foreach($cur_user->Groups() as $group){
						if($group->GroupName=='Guest'){//an einai guest
							$isGuest=true;
						}
					}
					foreach($cur_user->Groups() as $group){
						if($group->GroupName!='Guest'){//an einai guest KAI kati allo, isxyei to allo group
							$isGuest=false;
						}
					}
					if(in_array($cur_user,$charged_users,true) && !$isGuest){//ean xrewnetai k einai sto orio
						$problem_users[]=$cur_user->FullName();
						$passed=false;
					}
				}
			}
		}
		if(!$passed){
			$problem_users=implode('<br />',$problem_users);
			return new ReservationRuleResult(false, "Παρακαλούνται οι παρακάτω χρήστες να περάσουν από τη γραμματεία<br />$problem_users");
		}
		//telos elegxos gia ofeiles k an epitrepetai na ginei i kratisi i oxi
		return new ReservationRuleResult();
	}
    
    /**
     * 
     * @param User $user
     * @param String $exceptionType
     * @param Quota $quota
     */
    public function createExceptionMessage($user, $exceptionType, $quota) {
        $message='';
        if($user==='current'){
            $message.='Έχετε υπερβεί το όριο των ';
        }
        else{
            $message.='Ο χρήστης '.$user->FullName().' έχει υπερβεί το όριο των ';
        }
        
        if($exceptionType==='count'){
            $message.=intval($quota->GetLimit()->Amount());
            $message.=' κρατήσεων';
        }
        else if($exceptionType==='hours'){
            $message.=$quota->GetLimit()->Amount();
            $message.=' ωρών';
        }
        else if($exceptionType==='active'){
            $message.=intval($quota->GetLimit()->Amount());
            $message.=' ενεργών κρατήσεων';
        }
        $resources = Resources::GetInstance();
        if($exceptionType!=='active'){
            $message.=' '.$resources->GetString('per_'.$quota->GetDuration()->Name());
        }
        
        return $message;
    }
}

?>