<?php

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationEmailMessage.php');

class ReservationFirstParticipantCancellation extends ReservationEmailMessage
{
	/**
	 * @var User
	 */
	private $secretary;
	private $first_participant;
	
	public function __construct(User $reservationOwner, User $first_participant, ReservationSeries $reservationSeries,User $secretary)
	{
		parent::__construct($reservationOwner, $reservationSeries, $secretary->Language());
		
		$this->reservationOwner = $reservationOwner;
		$this->reservationSeries = $reservationSeries;
		$this->timezone = $secretary->Timezone();
		$this->secretary = $secretary;
		$this->first_participant=$first_participant;
	}

	public function To()
	{
		$address = $this->secretary->EmailAddress();
		$name = $this->secretary->FullName();
		
		return array(new EmailAddress($address, $name));
	}

	public function Subject()
	{
		return $this->Translate('ReservationFirstParticipantCancellation');
	}

	public function From()
	{
		return new EmailAddress($this->first_participant->EmailAddress(), $this->first_participant->FullName());
	}

    public function GetTemplateName()
    {
        return 'ReservationFirstParticipantCancellation.tpl';
    }
}
?>