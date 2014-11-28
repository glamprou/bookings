<?php

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationEmailMessage.php');

class ReservationDeletedEmail extends ReservationEmailMessage
{
    /**
     * @return string
     */
    function Subject()
    {
        return $this->Translate('ReservationDeletedSubject');
    }

    protected function GetTemplateName()
    {
       return 'ReservationDeleted.tpl';
    }
}

?>