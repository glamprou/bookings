<?php

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationEmailMessage.php');

class ReservationParticipantCancellation extends ReservationEmailMessage
{
	/**
	 * @var User
	 */
	protected $reservationOwner;
	private $participant;
	
	public function __construct(User $reservationOwner, User $participant, ReservationSeries $reservationSeries)
	{
		parent::__construct($reservationOwner, $reservationSeries, $participant->Language());
		
		$this->reservationOwner = $reservationOwner;
		$this->reservationSeries = $reservationSeries;
		$this->timezone = $participant->Timezone();
		$this->participant=$participant;
	}

	public function To()
	{
		$address = $this->reservationOwner->EmailAddress();
		$name = $this->reservationOwner->FullName();
		
		return array(new EmailAddress($address, $name));
	}

	public function Subject()
	{
		return $this->Translate('ReservationParticipantCancellation');
	}

	public function From()
	{
		return new EmailAddress($this->participant->EmailAddress(), $this->participant->FullName());
	}

    public function GetTemplateName()
    {
        return 'ReservationParticipantCancellation.tpl';
    }
}
?>