<?php
 
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/SchedulePresenter.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');


interface IReservationPopupPage
{
	/**
	 * @return string
	 */
	function GetReservationId();

	/**
	 * @param $first string
	 * @param $last string
	 */
	function SetName($first, $last);

	/**
	 * @param $resources ScheduleResource[]
	 */
	function SetResources($resources);

	/**
	 * @param $users ReservationUser[]
	 */
	function SetParticipants($users);

	/**
	 * @param $summary string
	 */
	function SetSummary($summary);

    /**
	 * @param $title string
	 */
	function SetTitle($title);

	/**
	 * @param $startDate Date
	 * @param $endDate Date
	 */
	function SetDates($startDate, $endDate);

	/**
	 * @abstract
	 * @param $accessories ReservationAccessory[]
	 * @return mixed
	 */
	public function SetAccessories($accessories);

	/**
	 * @abstract
	 * @param bool $hideReservationDetails
	 * @return void
	 */
	public function SetHideDetails($hideReservationDetails);

	/**
	 * @abstract
	 * @param bool $hideUserInfo
	 * @return void
	 */
	public function SetHideUser($hideUserInfo);
}

class ReservationPopupPage extends Page implements IReservationPopupPage
{
	/**
	 * @var ReservationPopupPresenter
	 */
	private $_presenter;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_presenter = new ReservationPopupPresenter($this, new ReservationViewRepository(), new ReservationAuthorization(PluginManager::Instance()->LoadAuthorization()));
	}

	public function IsAuthenticated()
	{
		return Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_VIEW_RESERVATIONS, new BooleanConverter()) ||
						parent::IsAuthenticated();
	}

	public function PageLoad()
	{
		if (!$this->IsAuthenticated())
		{
			$this->Set('authorized', false);
		}
		else
		{
			$this->Set('authorized', true);
			$this->_presenter->PageLoad();
		}
        
        $call=pdoq("select concat(us.lname, ' ',us.fname) as opponent_name, us.user_id from
                    r_calls cal 
                    inner join reservation_instances ri on cal.reference_number=ri.reference_number
                    inner join reservation_users ru on ri.reservation_instance_id=ru.reservation_instance_id
                    inner join users us on ru.user_id=us.user_id
                    where ri.reference_number=? order by ru.reservation_user_level asc",$this->GetReservationId());

        if($call){
            $this->Set('isGame', TRUE);
            $this->Set('rankingName',getRankingName($call[0]->user_id));
            //get player names and ranking positions
            $this->Set('opponent1name', $call[0]->opponent_name);
            $this->Set('opponent1pos', getPlayerPosition($call[0]->user_id));
            
            $this->Set('opponent2name', $call[1]->opponent_name);
            $this->Set('opponent2pos', getPlayerPosition($call[1]->user_id));
        }

        $this->Set('ownerPhone', "");

        $userSession=ServiceLocator::GetServer()->GetUserSession();
        if($userSession->IsAdmin){
            $row= pdoq("select us.phone
                        from reservation_instances ri
                        inner join reservation_series rs on ri.series_id=rs.series_id
                        inner join users us  on us.user_id=rs.owner_id
                        where ri.reference_number=?",$this->GetReservationId());
            if($row && !empty($row[0]->phone)){
                $this->Set('ownerPhone', "(".$row[0]->phone.")");
            }
        }

		$this->Set('ReservationId', $this->GetReservationId());
		
		$this->Display('Ajax/respopup.tpl');
	}
	
	/**
	 * @return string
	 */
	function GetReservationId()
	{
		return $this->GetQuerystring('id');
	}
	
	function SetName($first, $last)
	{
		$this->Set('fullName', new FullName($first, $last));
	}
	
	function SetResources($resources)
	{
		$this->Set('resources', $resources);
	}
	
	function SetParticipants($users)
	{
		$this->Set('participants', $users);
	}
	
	function SetSummary($summary)
	{
		$this->Set('summary', $summary);
	}

    function SetTitle($title)
    {
        $this->Set('title', $title);
    }
	
	function SetDates($startDate, $endDate)
	{
		$this->Set('startDate', $startDate);
		$this->Set('endDate', $endDate);
	}

	/**
	 * @param $accessories ReservationAccessory[]
	 * @return mixed
	 */
	public function SetAccessories($accessories)
	{
		$this->Set('accessories', $accessories);
	}

	/**
	 * @param bool $hideReservationDetails
	 * @return void
	 */
	public function SetHideDetails($hideReservationDetails)
	{
		$this->Set('hideDetails', $hideReservationDetails);
	}

	/**
	 * @param bool $hideUserInfo
	 * @return void
	 */
	public function SetHideUser($hideUserInfo)
	{
		$this->Set('hideUserInfo', $hideUserInfo);
	}
}


class ReservationPopupPresenter
{
	/**
	 * @var IReservationPopupPage
	 */
	private $_page;
	
	/*
	 * @var IReservationViewRepository
	 */
	private $_reservationRepository;

	/**
	 * @var IReservationAuthorization
	 */
	private $_reservationAuthorization;
	 
	public function __construct(IReservationPopupPage $page, IReservationViewRepository $reservationRepository, IReservationAuthorization $reservationAuthorization)
	{
		$this->_page = $page;
		$this->_reservationRepository = $reservationRepository;
		$this->_reservationAuthorization = $reservationAuthorization;
	}
	
	public function PageLoad()
	{
		$hideUserInfo = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_HIDE_USER_DETAILS, new BooleanConverter());
		$hideReservationDetails = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_HIDE_RESERVATION_DETAILS, new BooleanConverter());

		$tz = ServiceLocator::GetServer()->GetUserSession()->Timezone;
		
		$reservation = $this->_reservationRepository->GetReservationForEditing($this->_page->GetReservationId());

		if (!$reservation->IsDisplayable())
		{
			return;
		}

		if ($hideReservationDetails || $hideUserInfo)
		{
			$canViewDetails = $this->_reservationAuthorization->CanViewDetails($reservation, ServiceLocator::GetServer()->GetUserSession());

			$hideReservationDetails = !$canViewDetails && $hideReservationDetails;
			$hideUserInfo = !$canViewDetails && $hideUserInfo;
		}
		$this->_page->SetHideDetails($hideReservationDetails);
		$this->_page->SetHideUser($hideUserInfo);

		$startDate = $reservation->StartDate->ToTimezone($tz);
		$endDate = $reservation->EndDate->ToTimezone($tz);

		$this->_page->SetName($reservation->OwnerFirstName, $reservation->OwnerLastName);
		$this->_page->SetResources($reservation->Resources);
		$this->_page->SetParticipants($reservation->Participants);
		$this->_page->SetSummary($reservation->Description);
		$this->_page->SetTitle($reservation->Title);
		$this->_page->SetAccessories($reservation->Accessories);

		$this->_page->SetDates($startDate, $endDate);
	}
}
?>