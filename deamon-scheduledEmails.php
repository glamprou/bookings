<?php
define('ROOT_DIR','');
require_once(ROOT_DIR . 'config/config.php');
require_once(ROOT_DIR . 'emailSendOrSchedule.php');
require_once(ROOT_DIR . 'Domain/Access/UserRepository.php');

$userrep=new UserRepository();

$rows=pdoq("select * from r_email_schedules");
foreach($rows as $row){
    if($row->extra!==""){
        sendOrSchedule($row->type,$userrep->LoadById($row->to_id),$userrep->LoadById($row->from_id),$row->doublesend==1 ? TRUE : FALSE,$row->extra);
    }
    else{
        sendOrSchedule($row->type,$userrep->LoadById($row->to_id),$userrep->LoadById($row->from_id),$row->doublesend==1 ? TRUE : FALSE);
    }
}
pdoq("delete from r_email_schedules where 1");