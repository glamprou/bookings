<?php
define('ROOT_DIR','');
require_once(ROOT_DIR . 'emailSendOrSchedule.php');
require_once(ROOT_DIR . 'Domain/Access/UserRepository.php');
require_once(ROOT_DIR . 'Web/inc/config.php');

$userrep=new UserRepository();

$res=mysql_query("select * from email_schedules where sent=0");
while($row=mysql_fetch_object($res)){
    if($row->extra!==""){
        sendOrSchedule($row->type,$userrep->LoadById($row->to_id),$userrep->LoadById($row->from_id),$row->doublesend==1 ? TRUE : FALSE,$row->extra);
    }
    else{
        sendOrSchedule($row->type,$userrep->LoadById($row->to_id),$userrep->LoadById($row->from_id),$row->doublesend==1 ? TRUE : FALSE);
    }
}
include(ROOT_DIR . 'Web/inc/config.php');
mysql_query("update email_schedules set sent=1");