<?php

require_once(ROOT_DIR . 'lib/Email/Messages/ParticipantAddedEmail.php');

class ParticipantAddedEmailNotification implements IReservationNotification
{
	/**
	 * @var \IUserRepository
	 */
	private $userRepository;

	public function __construct(IUserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 */
	function Notify($reservationSeries)
	{
		$instance = $reservationSeries->CurrentInstance();
        $owner = $this->userRepository->LoadById($reservationSeries->UserId());

		foreach ($instance->AddedParticipants() as $userId)
		{
			$participant = $this->userRepository->LoadById($userId);

			$message = new ParticipantAddedEmail($owner, $participant, $reservationSeries);
			ServiceLocator::GetEmailService()->Send($message);
		}
	}
}
?>