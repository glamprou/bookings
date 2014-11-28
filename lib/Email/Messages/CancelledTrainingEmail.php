<?php
 
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationEmailMessage.php');

class CancelledTrainingEmail extends ReservationEmailMessage
{
    /**
     * @return string
     */
    function Subject()
    {
        return $this->Translate('CancelledTraining');
    }

    protected function GetTemplateName()
    {
       return 'ReservationDeleted.tpl';
    }
}

?>