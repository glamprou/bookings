<?php
define('ROOT_DIR','../');

require_once(ROOT_DIR.'config/config.php');
require_once(ROOT_DIR.'Pages/Pages.php');
require_once(ROOT_DIR.'lib/Application/Authentication/IAccountActivation.php');
require_once(ROOT_DIR.'lib/Application/Authentication/AccountActivation.php');
require_once(ROOT_DIR.'lib/Application/Authentication/Authentication.php');
require_once(ROOT_DIR.'lib/Email/Messages/CallAcceptedEmail.php');
require_once(ROOT_DIR.'lib/Email/Messages/CallDeclinedEmail.php');
require_once(ROOT_DIR.'Ranking/functions.php');
require_once(ROOT_DIR . 'emailSendOrSchedule.php');

function redirectTo($target='home'){
    switch($target){
        case 'calls':
            header("Location: calls.php");
            exit;
            break;
        case 'home':
            header("Location: ".ROOT_DIR);
            exit;
            break;
        default:
            header("Location: ".ROOT_DIR);
            exit;
            break;
    }
}

if(count($_POST)>0 || !isset($_GET['adcac']) || !isset($_GET['action'])){
	redirectTo('home');
}

$userRepository=new UserRepository();

//handle call
$row=pdoq("select * from r_call_activation_codes where ac_code=?",$_GET['adcac']);
$callid=$row[0]->ac_call_id;
$row=pdoq("select caller_user_id,callee_user_id from r_calls where call_id=?",$callid);
if($row){
	$row=pdoq("select caller_user_id,callee_user_id from r_calls where call_id=?",$callid);

	$callee=$userRepository->LoadById($row[0]->callee_user_id);
	$caller=$userRepository->LoadById($row[0]->caller_user_id);

	if($_GET['action']=='1'){//call acceptance
		pdoq("update r_calls set call_accepted=1 where call_id=?",$callid);
		pdoq("delete from r_call_activation_codes where ac_call_id=?",$callid);


		sendOrSchedule("CallAcceptedEmail",$callee,$caller,TRUE);

        $db=ServiceLocator::GetDatabase();
        $db->Connection->Connect();
		sms($callid,$caller->Id(),1);
	}
	else{//decline
		pdoq("update r_calls set call_accepted=-1 where call_id=?",$callid);
		pdoq("delete from r_call_activation_codes where ac_call_id=?",$callid);

		givePenalty($callee);

		$morethanthreematches=false;//three is dynamic now

        $tmprow=pdoq("select numAGFreeDecl from r_options");
		$numofmatchesforfreedecl=$tmprow[0]->numAGFreeDecl;

		$openGames=pdoq("select * from r_calls where (caller_user_id=? or callee_user_id=?) and call_accepted=1 and call_completed=0", array($callee->Id(),$callee->Id()), TRUE);

        if ($openGames>=$numofmatchesforfreedecl){//den tha dexthei poini
			$morethanthreematches=true;
		}

        sendOrSchedule("CallDeclinedEmail",$caller,$callee,FALSE, $morethanthreematches);

        $db=ServiceLocator::GetDatabase();
        $db->Connection->Connect();
		sms($callid,$calleruser->Id(),2);
	}
}
else{//palio activation code i activation code pou den isxyei
	redirectTo('home');
}
//telos handle call


//then, auto login
//$activationResult=new ActivationResult(true, $callee);
//$user=$activationResult->User();
//
//$authentication=PluginManager::Instance()->LoadAuthentication();
//$authentication->Login($user->Username(), new WebLoginContext(new LoginData(false, $user->Language())));

redirectTo('calls');
//telos then, auto login
?>