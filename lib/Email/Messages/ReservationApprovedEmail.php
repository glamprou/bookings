<?php

require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationEmailMessage.php');

class ReservationApprovedEmail extends ReservationEmailMessage
{
	public function Subject()
	{
		return $this->Translate('ReservationApprovedSubject');
	}

    /**
     * @return string
     */
    protected function GetTemplateName()
    {
        return 'ReservationCreated.tpl';
    }
}
?>