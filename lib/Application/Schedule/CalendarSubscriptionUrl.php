<?php

class CalendarSubscriptionUrl
{
    /**
     * @var Url
     */
    private $url;

    public function __construct($userPublicId, $schedulePublicId, $resourcePublicId)
    {
        $config = Configuration::Instance();
        $scriptUrl = $config->GetScriptUrl();
        $scriptUrl = str_replace('https', 'webcal', $scriptUrl);
        $scriptUrl = str_replace('http', 'webcal', $scriptUrl);
        $scriptUrl .= '/export/' . Pages::CALENDAR_SUBSCRIBE;
        $url = new Url($scriptUrl);

        $url->AddQueryString(QueryStringKeys::USER_ID, $userPublicId);
        $url->AddQueryString(QueryStringKeys::SCHEDULE_ID, $schedulePublicId);
        $url->AddQueryString(QueryStringKeys::RESOURCE_ID, $resourcePublicId);
        $url->AddQueryString(QueryStringKeys::SUBSCRIPTION_KEY, $config->GetSectionKey(ConfigSection::ICS, ConfigKeys::ICS_SUBSCRIPTION_KEY));
        $this->url = $url;
    }

    public function __toString()
    {
        return $this->url->ToString();
    }
}

?>