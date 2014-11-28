<?php
define('ROOT_DIR','');
date_default_timezone_set ('Europe/Athens');
require_once(ROOT_DIR . 'Pages/Admin/ManageUsersPage.php');
require_once(ROOT_DIR . 'lib/Email/Messages/NewCallEmail.php');
require_once(ROOT_DIR . 'lib/Email/Messages/CallReminderTodayEmail.php');
require_once(ROOT_DIR . 'lib/Email/Messages/CallReminderTomorrowEmail.php');
require_once(ROOT_DIR . 'lib/Email/Messages/InsertCallScoreTodayEmail.php');
require_once(ROOT_DIR . 'lib/Email/Messages/InsertCallScoreTomorrowEmail.php');
require_once(ROOT_DIR . 'lib/Email/Messages/InsertCallDateTodayEmail.php');
require_once(ROOT_DIR . 'lib/Email/Messages/InsertCallDateTomorrowEmail.php');
require_once(ROOT_DIR . 'lib/Email/Messages/CallDeclinedEmail.php');
require_once(ROOT_DIR . 'lib/Email/Messages/CallAcceptedEmail.php');
require_once(ROOT_DIR . 'Domain/Access/UserRepository.php');

/**
 * true, an i wra twra einai prin tis 10 to vrady kai meta tis 9 to prwi
 * false, diaforetika
 * @return boolean
 */
function awake(){
    $night_datetime=date("Y-m-d 22:00:00");
    $morning_datetime=date("Y-m-d 09:00:00");
    $now=strtotime("now");
    if($now<strtotime($morning_datetime) || $now>strtotime($night_datetime)){
        return FALSE;
    }
    return TRUE;
}

/**
 * an awake, steilto. alliws apothikefse to sti vasi gia apostoli argotera
 * @param $class
 * @param $to User
 * @param $from User
 * @param bool $doublesend
 * @param null $extra
 */
function sendOrSchedule($class, $to, $from, $doublesend=false, $extra=NULL){
    if(awake()){
        if($extra){
            ServiceLocator::GetEmailService()->Send(new $class($to,$from,$extra));
            if($doublesend){
                ServiceLocator::GetEmailService()->Send(new $class($from,$to,$extra));
            }
        }
        else {
            ServiceLocator::GetEmailService()->Send(new $class($to,$from));
            if($doublesend){
                ServiceLocator::GetEmailService()->Send(new $class($from,$to));
            }
        }
    }
    else{
        $doublesend=$doublesend ? 1 : 0;
        $extra=$extra ? $extra : "";

        pdoq("insert into r_email_schedules (type, from_id, to_id, doublesend, extra) values (?,?,?,?,?)", array($class,$from->Id(),$to->Id(),$doublesend,$extra));
    }
}