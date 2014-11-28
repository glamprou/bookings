<?php

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationCreatedEmailAdmin.php');

class ReservationDeletedEmailAdmin extends ReservationCreatedEmailAdmin
{
    public function Subject()
    {
        return $this->Translate('ReservationDeleteAdminSubject');
    }

    protected function GetTemplateName()
    {
       return 'ReservationDeleted.tpl';
    }
}

?>