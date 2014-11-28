<?php
define('ROOT_DIR','../');

require_once(ROOT_DIR.'config/config.php');
require_once(ROOT_DIR.'Pages/Pages.php');
require_once(ROOT_DIR.'lib/Application/Authentication/IAccountActivation.php');
require_once(ROOT_DIR.'lib/Application/Authentication/AccountActivation.php');
require_once(ROOT_DIR.'lib/Application/Authentication/Authentication.php');
require_once(ROOT_DIR.'lib/Email/Messages/CallAcceptedEmail.php');
require_once(ROOT_DIR.'lib/Email/Messages/CallDeclinedEmail.php');
require_once(ROOT_DIR.'Web/inc/functions.php');

if(count($_POST)>0 || !isset($_GET['adcac']) || !isset($_GET['action'])){
	echo "error"; exit;
}

$userRepository=new UserRepository();

//handle call
global $conf;
$link=mysql_connect("localhost", $conf['settings']['database']['user'], $conf['settings']['database']['password']);
mysql_select_db($conf['settings']['database']['name']);

mysql_query("SET NAMES utf8");

$res=mysql_query("select * from r_call_activation_codes where ac_code='".mysql_real_escape_string($_GET['adcac'])."'");
if($row=mysql_fetch_object($res)){
	$userid=$row->ac_callee_id;
	$callid=$row->ac_call_id;
	$res=mysql_query("select caller_user_id,callee_user_id from r_calls where call_id=$callid");
	$row=mysql_fetch_object($res);
	
	$tmp=$userRepository->LoadById(2);//1o fetch akyro gia na emfanizei swsta to onoma tou $user	
	$user=$userRepository->LoadById($row->callee_user_id);
	$calleruser=$userRepository->LoadById($row->caller_user_id);
	
	global $conf;
	$link=mysql_connect("localhost", $conf['settings']['database']['user'], $conf['settings']['database']['password']);
	mysql_select_db($conf['settings']['database']['name']);
	
	mysql_query("SET NAMES utf8");
	
	if($_GET['action']=='1'){//call acceptance
		mysql_query("update r_calls set call_accepted=1 where call_id=$callid");
		mysql_query("delete from r_call_activation_codes where ac_call_id=$callid");	
		
		ServiceLocator::GetEmailService()->Send(new CallAcceptedEmail($user, $calleruser));
		ServiceLocator::GetEmailService()->Send(new CallAcceptedEmail($calleruser, $user));
		global $conf;
		$link=mysql_connect("localhost", $conf['settings']['database']['user'], $conf['settings']['database']['password']);
		mysql_select_db($conf['settings']['database']['name']);
		sms($callid,$row->caller_user_id,1);
	}
	else{//decline
		mysql_query("update r_calls set call_accepted=-1 where call_id=$callid");
		mysql_query("delete from r_call_activation_codes where ac_call_id=$callid");	
		givePenalty($userid);
		
		ServiceLocator::GetEmailService()->Send(new CallDeclinedEmail($user, $calleruser));
		
		global $conf;
		$link=mysql_connect("localhost", $conf['settings']['database']['user'], $conf['settings']['database']['password']);
		mysql_select_db($conf['settings']['database']['name']);
		
		mysql_query("SET NAMES utf8");
		
		$morethanthreematches=false;//three is dynamic now
		
		$tmpres=mysql_query("select numAGFreeDecl from r_options");
		$tmprow=mysql_fetch_object($tmpres);
		$numofmatchesforfreedecl=$tmprow->numAGFreeDecl;
		
		$r=mysql_query("select * from r_calls where (caller_user_id=$row->callee_user_id or callee_user_id=$row->callee_user_id) and call_accepted=1 and call_completed=0");
		if (mysql_num_rows($r)>=$numofmatchesforfreedecl){//den tha dexthei poini
			$morethanthreematches=true;
		}
		ServiceLocator::GetEmailService()->Send(new CallDeclinedEmail($calleruser, $user, $morethanthreematches));
		global $conf;
		$link=mysql_connect("localhost", $conf['settings']['database']['user'], $conf['settings']['database']['password']);
		mysql_select_db($conf['settings']['database']['name']);
		sms($callid,$row->caller_user_id,2);
	}
}
else{//palio activation code i acitvation code pou den isxyei
	header("Location: index.php");
	exit;
}
//telos handle call

//then, auto login
$user = $userRepository->LoadById($userid);
$activationResult=new ActivationResult(true, $user);
$user=$activationResult->User();
$authentication=PluginManager::Instance()->LoadAuthentication();
$authentication->Login($user->Username(), new WebLoginContext(ServiceLocator::GetServer(), new LoginData(false, $user->Language())));

header("Location: calls.php");
//telos then, auto login
?>