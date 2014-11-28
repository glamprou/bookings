<?php

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationEmailMessage.php');

class ParticipantAddedEmail extends ReservationEmailMessage
{
	/**
	 * @var User
	 */
	private $participant;

	public function __construct(User $reservationOwner, User $participant, ReservationSeries $reservationSeries)
	{
		parent::__construct($reservationOwner, $reservationSeries, $participant->Language());
		
		$this->reservationOwner = $reservationOwner;
		$this->reservationSeries = $reservationSeries;
		$this->timezone = $participant->Timezone();
		$this->participant = $participant;
	}

	public function To()
	{
		$address = $this->participant->EmailAddress();
		$name = $this->participant->FullName();
		
		return array(new EmailAddress($address, $name));
	}

	public function Subject()
	{
		return $this->Translate('ParticipantAddedSubject');
	}

	public function From()
	{
		return new EmailAddress($this->reservationOwner->EmailAddress(), $this->reservationOwner->FullName());
	}

    public function GetTemplateName()
    {
        return 'ReservationCreated.tpl';
    }
}
?>