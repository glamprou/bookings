<?php
 

require_once('Language.php');
require_once('en_us.php');

class en_gb extends en_us
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function _LoadDates()
    {
        $dates = parent::_LoadDates();

        // change defaults here
        $dates['general_date'] = 'd/m/Y';
        $dates['general_datetime'] = 'd/m/Y H:i:s';
        $dates['schedule_daily'] = 'l, d/m/Y';
        $dates['reservation_email'] = 'd/m/Y @ g:i A (e)';
        $dates['res_popup'] = 'd/m/Y g:i A';
        $dates['dashboard'] = 'l, d/m/Y g:i A';
        $dates['period_time'] = "g:i A";
        $dates['general_date_js'] = "dd/mm/yy";

        $this->Dates = $dates;
    }

    protected function _LoadStrings()
    {
        parent::_LoadStrings();

        // change defaults here
    }

    protected function _LoadDays()
    {
        parent::_LoadDays();

        // change defaults here
    }

    protected function _LoadMonths()
    {
        parent:: _LoadMonths();

        // change defaults here
    }
}

?>