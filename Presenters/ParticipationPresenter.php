<?php


require_once(ROOT_DIR . 'Pages/ParticipationPage.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationFirstParticipantCancellation.php');
require_once(ROOT_DIR . 'Domain/Access/UserRepository.php');

class ParticipationPresenter {

    /**
     * @var \IParticipationPage
     */
    private $page;

    /**
     * @var \IReservationRepository
     */
    private $reservationRepository;

    /**
     * @var \IReservationViewRepository
     */
    private $reservationViewRepository;

    public function __construct(IParticipationPage $page, IReservationRepository $reservationRepository, IReservationViewRepository $reservationViewRepository) {
        $this->page = $page;
        $this->reservationRepository = $reservationRepository;
        $this->reservationViewRepository = $reservationViewRepository;
    }

    public function PageLoad() {
        $invitationAction = $this->page->GetInvitationAction();

        if (!empty($invitationAction)) {
            $this->HandleInvitationAction($invitationAction);

            if ($this->page->GetResponseType() == 'json') {
                $this->page->DisplayResult(null);
                return;
            }
        }

        $startDate = Date::Now();
        $endDate = $startDate->AddDays(30);
        $user = ServiceLocator::GetServer()->GetUserSession();
        $userId = $user->UserId;

        $reservations = $this->reservationViewRepository->GetReservationList($startDate, $endDate, $userId, ReservationUserLevel::INVITEE);

        $this->page->SetTimezone($user->Timezone);
        $this->page->BindReservations($reservations);
        $this->page->DisplayParticipation();
    }

    private function HandleInvitationAction($invitationAction) {
        $referenceNumber = $this->page->GetInvitationReferenceNumber();
        $userId = $this->page->GetUserId();

        Log::Debug('Invitation action %s for user %s and reference number %s', $invitationAction, $userId, $referenceNumber);

        $series = $this->reservationRepository->LoadByReferenceNumber($referenceNumber);

        if ($invitationAction == InvitationAction::Accept) {
            $series->AcceptInvitation($userId);
        }
        if ($invitationAction == InvitationAction::Decline) {
            $series->DeclineInvitation($userId);
        }
        if ($invitationAction == InvitationAction::CancelInstance) {
            $series->CancelInstanceParticipation($userId);
						
			/*elegxos periptwsis 1ou participant, k an nai, diagrafi kratisis*/						
			$row=pdoq("select * from reservation_first_participant where user_id=? and reservation_series_id=?",array($userId,$series->SeriesId()));
			if(count($row)){
				//diagrafi kratisis
				pdoq("update reservation_series set status_id=2 where series_id=?",$series->SeriesId());
				//telos diagrafi kratisis
				pdoq("delete from reservation_first_participant where reservation_series_id=?",$series->SeriesId());
				
				/*Email ston owner*/
				$userrep=new UserRepository();
				$owner = $userrep->LoadById($series->UserId());
				$participant = $userrep->LoadById($userId);
				
				$message = new ReservationFirstParticipantCancellation($owner, $participant, $series, $owner);
				ServiceLocator::GetEmailService()->Send($message);
				/*telos*/
				
				/*Email sti grammateia*/
				$userrep=new UserRepository();
				$owner = $userrep->LoadById($series->UserId());
				$secretary = $userrep->LoadById(2);//to id tis grammateias einai to 2
				$participant = $userrep->LoadById($userId);
				
				$message = new ReservationFirstParticipantCancellation($owner, $participant, $series, $secretary);
				ServiceLocator::GetEmailService()->Send($message);
				/*telos*/
				echo json_encode('gotoschedule');
				exit;
			}
			/*telos*/
						
        }
        if ($invitationAction == InvitationAction::CancelAll) {
            $series->CancelAllParticipation($userId);
        }
		if ($invitationAction == InvitationAction::AcceptOnOpenReservation) {
			$series->AcceptInvitation($userId);
			
			/*diagrafi eggrafis ston pinaka twn 1wn participants*/
			pdoq("insert into reservation_first_participant (reservation_series_id,user_id) values (?,?)",array($series->SeriesId(),$userId));
			pdoq("delete from open_reservations where reference_number=?",$series->CurrentInstance()->ReferenceNumber());
			/*telos*/
        }
        $this->reservationRepository->Update($series);
    }

}

?>