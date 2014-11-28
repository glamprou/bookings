<?php

require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'Pages/Pages.php');

abstract class ReservationEmailMessage extends EmailMessage
{
    /**
     * @var User
     */
    protected $reservationOwner;

    /**
     * @var ReservationSeries
     */
    protected $reservationSeries;

    /**
     * @var IResource
     */
    protected $primaryResource;

    /**
     * @var string
     */
    protected $timezone;

    public function __construct(User $reservationOwner, ReservationSeries $reservationSeries, $language = null)
    {
        if (empty($language))
        {
            $language = $reservationOwner->Language();
        }
        parent::__construct($language);

        $this->reservationOwner = $reservationOwner;
        $this->reservationSeries = $reservationSeries;
        $this->timezone = $reservationOwner->Timezone();
    }

    /**
     * @abstract
     * @return string
     */
    protected abstract function GetTemplateName();

    public function To()
    {
        $address = $this->reservationOwner->EmailAddress();
        $name = $this->reservationOwner->FullName();

        return array(new EmailAddress($address, $name));
    }

    public function Body()
    {
        $this->PopulateTemplate();
        return $this->FetchTemplate($this->GetTemplateName());
    }

    protected function PopulateTemplate()
    {
        $currentInstance = $this->reservationSeries->CurrentInstance();
        $this->Set('UserName', $this->reservationOwner->FullName());
        $this->Set('StartDate', $currentInstance->StartDate()->ToTimezone($this->timezone));
        $this->Set('EndDate', $currentInstance->EndDate()->ToTimezone($this->timezone));
        $this->Set('ResourceName', $this->reservationSeries->Resource()->GetName());
        $this->Set('Title', $this->reservationSeries->Title());
        $this->Set('Description', $this->reservationSeries->Description());

        $repeatDates = array();
        if ($this->reservationSeries->IsRecurring())
        {
            foreach ($this->reservationSeries->Instances() as $repeated)
            {
                $repeatDates[] = $repeated->StartDate()->ToTimezone($this->timezone);
            }
        }
        $this->Set('RepeatDates', $repeatDates);
        $this->Set('RequiresApproval', $this->reservationSeries->RequiresApproval());
        $this->Set('ReservationUrl', sprintf("%s?%s=%s", Pages::RESERVATION, QueryStringKeys::REFERENCE_NUMBER, $currentInstance->ReferenceNumber()));
        $this->Set('ICalUrl', sprintf("export/%s?%s=%s", Pages::CALENDAR_EXPORT, QueryStringKeys::REFERENCE_NUMBER, $currentInstance->ReferenceNumber()));

		$resourceNames = array();
		foreach($this->reservationSeries->AllResources() as $resource)
		{
			$resourceNames[] = $resource->GetName();
		}
		$this->Set('ResourceNames', $resourceNames);
		$this->Set('Accessories', $this->reservationSeries->Accessories());
    }
}
?>