<?php

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationEmailMessage.php');
require_once(ROOT_DIR . 'Domain/Values/InvitationAction.php');

class InviteeAddedEmail extends ReservationEmailMessage
{
	/**
	 * @var User
	 */
	private $invitee;
	
	public function __construct(User $reservationOwner, User $invitee, ReservationSeries $reservationSeries)
	{
		parent::__construct($reservationOwner, $reservationSeries, $invitee->Language());
		
		$this->reservationOwner = $reservationOwner;
		$this->reservationSeries = $reservationSeries;
		$this->timezone = $invitee->Timezone();
		$this->invitee = $invitee;
	}

	public function To()
	{
		$address = $this->invitee->EmailAddress();
		$name = $this->invitee->FullName();
		
		return array(new EmailAddress($address, $name));
	}

	public function Subject()
	{
		return $this->Translate('InviteeAddedSubject');
	}

	public function From()
	{
		return new EmailAddress($this->reservationOwner->EmailAddress(), $this->reservationOwner->FullName());
	}

    public function GetTemplateName()
    {
        return 'ReservationInvitation.tpl';
    }
	
	protected function PopulateTemplate()
	{
        $currentInstance = $this->reservationSeries->CurrentInstance();
        parent::PopulateTemplate();

	    $this->Set('AcceptUrl', sprintf("%s?%s=%s&%s=%s", Pages::INVITATION_RESPONSES, QueryStringKeys::REFERENCE_NUMBER, $currentInstance->ReferenceNumber(), QueryStringKeys::INVITATION_ACTION, InvitationAction::Accept));
		$this->Set('DeclineUrl', sprintf("%s?%s=%s&%s=%s", Pages::INVITATION_RESPONSES, QueryStringKeys::REFERENCE_NUMBER, $currentInstance->ReferenceNumber(), QueryStringKeys::INVITATION_ACTION, InvitationAction::Decline));
	}
}
?>