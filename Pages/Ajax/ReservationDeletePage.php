<?php

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Pages/Ajax/IReservationSaveResultsPage.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationPresenterFactory.php');

interface IReservationDeletePage extends IReservationSaveResultsPage
{
	/**
	 * @return string
	 */
	public function GetReferenceNumber();

	/**
	 * @return SeriesUpdateScope|string
	 */
	public function GetSeriesUpdateScope();
}

class ReservationDeletePage extends SecurePage implements IReservationDeletePage
{
	/**
	 * @var ReservationDeletePresenter
	 */
	protected $presenter;

	/**
	 * @var bool
	 */
	protected $reservationSavedSuccessfully = false;
	
	/**
	 * 	boolean:
	 *	true an den einai nwritera apo min_edit_time
	 *	false an einai nwritera
	 */
	public $in_time;

	public function __construct()
	{
		parent::__construct();

		$factory = new ReservationPresenterFactory();
		$this->presenter = $factory->Delete($this, ServiceLocator::GetServer()->GetUserSession());
	}

	public function PageLoad()
	{
		try
		{
			$reservation = $this->presenter->BuildReservation();

            $numberOfInstances = pdoq('select * from reservation_instances where series_id = ?', $reservation->SeriesId(), true);

			//LOOKUP
			$this->inTime($reservation);//set object-variable in_time value
			$this->ckeckInTime($reservation);//if user not admin or coach (if coach is capable of) and res is too soon, display error
			
            if(!$this->handlerCallCase($reservation)){
                //i kratisi einai call pou exei oloklirwthei kai etsi DEN mporei na diagrafei
                $this->ShowErrors("Η κράτηση δεν ειναι δυνατό να διαγραφεί καθώς είναι αγώνας κατάταξης ο οποίος έχει ολοκληρωθεί!");
                $this->Display('Ajax/reservation/delete_failed.tpl');
                exit;
            }
            
			$this->presenter->HandleReservation($reservation);

			if ($this->reservationSavedSuccessfully)
			{
                if($this->GetSeriesUpdateScope() == SeriesUpdateScope::FullSeries || $numberOfInstances == 1){
                    pdoq("delete from reservation_details where series_id=?",$reservation->SeriesId());
                }
                pdoq("delete from open_reservations where reference_number=?",$reservation->CurrentInstance()->ReferenceNumber());
				$this->Display('Ajax/reservation/delete_successful.tpl');
			}
			else
			{
				$this->Display('Ajax/reservation/delete_failed.tpl');
			}
		} catch (Exception $ex)
		{
			Log::Error('ReservationDeletePage - Critical error saving reservation: %s', $ex);
			$this->Display('Ajax/reservation/reservation_error.tpl');
		}
	}

	public function SetSaveSuccessfulMessage($succeeded)
	{
		$this->reservationSavedSuccessfully = $succeeded;
	}

	public function ShowErrors($errors)
	{
		$this->Set('Errors', $errors);
	}

	public function ShowWarnings($warnings)
	{
		$this->Set('Warnings', $warnings);
	}

	public function GetReferenceNumber()
	{
		return $this->GetForm(FormKeys::REFERENCE_NUMBER);
	}

	public function GetSeriesUpdateScope()
	{
		return $this->GetForm(FormKeys::SERIES_UPDATE_SCOPE);
	}
	//function inTime:LOOKUP
	//orizei tin metavliti in_time tou antikeimenou:
	//true - an oxi nwritera apo min_edit_time apo tin enarksi tis kratisis
	//false - diaforetika  	
	public function inTime($reservation){
		$diff=$reservation->CurrentInstance()->StartDate()->ToUTC()->Timestamp()-(strtotime("now")+sp_get_min_edit_time_seconds()); 
		$this->in_time=$diff>0 ? true : false;
	}
	
	//function checkInTime:
	//return void
	//typwnei oti einai nwris gia edit i diagrafi kratisis (ean einai ontws) kai o xristis den einai admin i coach(an einai energi i epilogi)
	public function ckeckInTime($reservation){
		$userSession=ServiceLocator::GetServer()->GetUserSession();
		
		if($userSession->IsAdmin) return;
		
		if(!$this->in_time){
			if(!sp_too_soon_coach_edit() || !$userSession->IsCoach()){
				$this->ShowErrors(str_replace('{time_var}',sp_get_min_edit_time_seconds(true),Resources::GetInstance()->GetString('tooSoonToEditOrDeleteReservation')));
				$this->Display('Ajax/reservation/save_failed.tpl');
				exit;
			}
		}
	}
    /**
     * Elegxei ean i kratisi pou prokeitai na svisei einai call. Ean einai kai den exei oloklirwthei, diagrafetai, k to call einai 
     * pali anoixto gia kleisimo imerominias. Ean exei oloklirwthei, den mporei na diagrafei.
     * Epistrefei TRUE mporei na diagrafei i kratisi, FALSE ean einai call alla exei oloklirwthei ara den mporei na diagrafei.
     * @param ExistingReservationSeries $reservation
     * @return
     */
    public function handlerCallCase($reservation) {
        $reference_number=$reservation->CurrentInstance()->ReferenceNumber();
        $call=pdoq("select * from r_calls where reference_number=?",$reference_number);
        if($call){
            if($call[0]->call_completed==1){
                return FALSE;
            }
            else{
                pdoq("update r_calls set match_date=NULL, reference_number=NULL where call_id=?",$call[0]->call_id);
                return TRUE;
            }
        }
        return TRUE;
    }
}

class ReservationDeleteJsonPage extends ReservationDeletePage implements IReservationDeletePage
{
	public function __construct()
	{
		parent::__construct();
	}

	public function PageLoad()
	{
		$reservation = $this->presenter->BuildReservation();
		$this->presenter->HandleReservation($reservation);
	}

	/**
	 * @param bool $succeeded
	 */
	public function SetSaveSuccessfulMessage($succeeded)
	{
		if ($succeeded)
		{
			$this->SetJson(array('deleted' => (string)$succeeded));
		}
	}

	public function ShowErrors($errors)
	{
		if (!empty($errors))
		{
			$this->SetJson(array('deleted' => (string)false), $errors);
		}
	}

	public function ShowWarnings($warnings)
	{
		//
	}
}

?>