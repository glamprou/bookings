<?php

require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'Pages/Pages.php');

abstract class ReminderEmail extends EmailMessage
{
	/**
	 * @var ReminderNotice
	 */
	protected $reminder;

	public function __construct(ReminderNotice $reminder)
	{
		$this->reminder = $reminder;
		parent::__construct($reminder->Language());
	}

	/**
	 * @return array|EmailAddress[]|EmailAddress
	 */
	public function To()
	{
		$name = new FullName($this->reminder->FirstName(), $this->reminder->LastName());
		return new EmailAddress($this->reminder->EmailAddress(), $name->__toString());
	}

	public function From()
	{
		return $this->To();
	}

	/**
	 * @return string
	 */
	public function Body()
	{
		$this->Set('StartDate', $this->reminder->StartDate()->ToTimezone($this->reminder->Timezone()));
		$this->Set('EndDate', $this->reminder->EndDate()->ToTimezone($this->reminder->Timezone()));
		$this->Set('ResourceName', $this->reminder->ResourceName());
		$this->Set('Title', $this->reminder->Title());
		$this->Set('Description', $this->reminder->Description());
		$this->Set('ReservationUrl', sprintf("%s?%s=%s", Pages::RESERVATION, QueryStringKeys::REFERENCE_NUMBER,
											 $this->reminder->ReferenceNumber()));
		$this->Set('ICalUrl', sprintf("export/%s?%s=%s", Pages::CALENDAR_EXPORT, QueryStringKeys::REFERENCE_NUMBER,
									  $this->reminder->ReferenceNumber()));
		return $this->FetchTemplate($this->GetTemplateName());
	}

	protected abstract function GetTemplateName();
}

class ReminderStartEmail extends ReminderEmail
{
	/**
	 * @return string
	 */
	public function Subject()
	{
		return $this->Translate('ReservationStartingSoonSubject', array($this->reminder->ResourceName()));
	}

	protected function GetTemplateName()
	{
		return 'StartReminderEmail.tpl';
	}
}

class ReminderEndEmail extends ReminderEmail
{
	/**
	 * @return string
	 */
	public function Subject()
	{
		return $this->Translate('ReservationEndingSoonSubject', $this->reminder->Title());
	}

	protected function GetTemplateName()
	{
		return 'EndReminderEmail.tpl';
	}
}

?>