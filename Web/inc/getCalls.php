<?php
require_once('../emailSendOrSchedule.php');
include('config.php');
require_once('functions.php');
$caller=$_POST['caller'];
$callee=$_POST['callee'];

$callid = newCall($caller,$callee);

$res=mysql_query("select ac_code from r_call_activation_codes where ac_call_id=$callid");
$row=mysql_fetch_object($res);

$userrep=new UserRepository();
$user=$userrep->LoadById($callee);
$calleruser=$userrep->LoadById($caller);

sendOrSchedule("NewCallEmail",$user,$calleruser,FALSE,$row->ac_code);
include('config.php');
sms($callid,$callee,0);
echo "Το call σας έγινε με επιτυχία!";
?>