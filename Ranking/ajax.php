<?php
define('ROOT_DIR', '../');
require_once(ROOT_DIR . 'config/config.php');
require_once(ROOT_DIR . 'Ranking/functions.php');
require_once(ROOT_DIR . 'lib/Common/ServiceLocator.php');

$userSession=ServiceLocator::GetServer()->GetUserSession();

/**
 * Aplos elegxos tou current xristi me ton eksousiodotimeno xristi. an einai oi idioi, tote ok. Alliws die()
 * @param int $authorizedUserId
 * @param int $userId
 * @return boolean
 */
function authorization($authorizedUserId, $userId){
    if($authorizedUserId!=$userId){
        die("unauthorized");
    }
    return TRUE;
}

///////////
///////////
//ranking//
///////////
///////////
if (isset($_POST['action']) && $_POST['action']=="newCall"){
    require_once(ROOT_DIR . 'Pages/Admin/ManageUsersPage.php');
    require_once(ROOT_DIR . 'Domain/Access/UserRepository.php');
    require_once(ROOT_DIR . 'lib/Email/Messages/NewCallEmail.php');

    $caller=$_POST['caller'];
    $callee=$_POST['callee'];
    
    $db=ServiceLocator::GetDatabase();
    $db->Connection->Connect();  
        
    $callid = newCall($caller,$callee);
    $db->Connection->Connect();  

    $row=pdoq("select ac_code from r_call_activation_codes where ac_call_id=?",$callid);
    if($row){
        $activation_code=$row[0]->ac_code;
    }
    $userrep=new UserRepository();
    $user=$userrep->LoadById($callee);
    $calleruser=$userrep->LoadById($caller);

    ServiceLocator::GetEmailService()->Send(new NewCallEmail($user,$calleruser,$activation_code));

    $db=ServiceLocator::GetDatabase();
    $db->Connection->Connect();

    sms($callid,$callee,0);
    echo "Το call σας έγινε με επιτυχία!";
    
	exit;
}
if (isset($_POST['action']) && $_POST['action']=="blockPlr" && $userSession->IsAdmin){
	pdoq("insert into r_user_blocks (user_id, bl_end) values(?,NULL)",$_POST['player']);
	exit;
}
if (isset($_POST['action']) && $_POST['action']=="unblockPlr" && $userSession->IsAdmin){
	pdoq("delete from r_user_blocks where user_id=?",$_POST['player']);
	exit;
}
if (isset($_POST['action']) && $_POST['action']=="injure" && $userSession->IsAdmin){
	pdoq("insert into r_injuries (user_id) values (?)",$_POST['player']);
	exit;
}
if (isset($_POST['action']) && $_POST['action']=="uninjure" && $userSession->IsAdmin){
	pdoq("delete from r_injuries where user_id=?",$_POST['player']);
	exit;
}
if (isset($_POST['action']) && $_POST['action']=="removePlr" && $userSession->IsAdmin){
    $ranking_table_name=getRankingTable($_POST['player']);
	pdoq("delete from $ranking_table_name where rank_user_id=?",$_POST['player']);
    sortRankings();
	exit;
}
if (isset($_POST['action']) && $_POST['action']=="insertToRanking" && $userSession->IsAdmin){
    session_start();
    
	$userid=$_POST['player'];
    $plr=pdoq("select CONCAT(fname,' ',lname) as fullname from users where user_id=?", $userid);
    if(!$plr){
        die("user not exists");
    }
    
    $rankingid=$_POST['ranking'];
    $row=pdoq("select ranking_table_name from r_rankings where ranking_id=?",$rankingid);
    if(!$row){
        die("unknown table");
    }
    $table=$row[0]->ranking_table_name;
    
	$row=pdoq("select * from $table where 1 limit 1");
	if($row){
		$res=pdoq("select max(rank_pos) as maxpos,min(rank_tot_points) as minpoints from $table");
		
		if ($res[0]->minpoints==0)
			$lastpos=$res[0]->maxpos;
		else
			$lastpos=$res[0]->maxpos+1;
		$res=pdoq("select * from $table where rank_user_id=?",$userid);
		if ($res)
			$res=mysql_query("insert into $table values(null,$lastpos,".$userid.",0)");
            pdoq("insert into $table (rank_id, rank_pos, rank_user_id, rank_tot_points) values(?,?,?,?)",array(null,$lastpos,$userid,0));
	}
	else{
		pdoq("insert into $table (rank_id, rank_pos, rank_user_id, rank_tot_points) values(?,?,?,?)",array(null,0,$userid,0));
	}
	$_SESSION['rankingMessage']="Ο χρήστης ".$plr[0]->fullname." έχει εισαχθεί με επιτυχία στη βαθμολογία";
    //LOOKUP TODO
    //eisagwgi ksana vathmwn apo tour gia ton paikti efoson epaize palia sto idio ranking
//	$res=mysql_query("select * from r_tours_participants where user_id=".$userid." and countedToRank=1 and sex=$sex");
//	while($row=mysql_fetch_object($res)){
//		$res2=mysql_query("select pos_points from r_tours_positions where position_id=$row->position_id");
//		$row2=mysql_fetch_object($res2);
//		mysql_query("update $table set rank_tot_points=rank_tot_points+$row2->pos_points where rank_user_id=".$_POST['addplr']."");
//	}
	sortRankings();
}

/////////
/////////
//calls//
/////////
/////////
if (isset($_POST['action']) && $_POST['action']=="acceptCall"){
    $row=pdoq("select caller_user_id,callee_user_id from r_calls where call_id=?",$_POST['callid']);    
    if($row){
        authorization($row[0]->callee_user_id,$userSession->UserId);
        
        $_SESSION['rankingMessage']="Αποδεχτήκατε την πρόσκληση με επιτυχία.";
        pdoq("update r_calls set call_accepted=1 where call_id=?",$_POST['callid']);
        pdoq("delete from r_call_activation_codes where ac_call_id=?",$_POST['callid']);
		
		require_once(ROOT_DIR . 'Domain/Access/UserRepository.php');
        require_once(ROOT_DIR . 'lib/Email/Messages/CallAcceptedEmail.php');
    
        $userrep=new UserRepository();
        $user=$userrep->LoadById($row->callee_user_id);
        $calleruser=$userrep->LoadById($row->caller_user_id);
        
        ServiceLocator::GetEmailService()->Send(new CallAcceptedEmail($user,$calleruser));
        $db=ServiceLocator::GetDatabase();
        $db->Connection->Connect();
        sms($_POST['callid'],$row->caller_user_id,1);
    }
	exit();
}
if (isset($_POST['action']) && $_POST['action']=="declineCall"){
    $row=pdoq("select caller_user_id,callee_user_id from r_calls where call_id=?",$_POST['callid']);    
    if($row){
        authorization($row[0]->callee_user_id,$userSession->UserId);
        
        require_once(ROOT_DIR . 'Pages/Admin/ManageUsersPage.php');
        require_once(ROOT_DIR . 'Domain/Access/UserRepository.php');
        require_once(ROOT_DIR . 'lib/Email/Messages/CallDeclinedEmail.php');
        
        $_SESSION['rankingMessage']="Απορρίψατε την πρόσκληση με επιτυχία.";
        
        $db=ServiceLocator::GetDatabase();
        $db->Connection->Connect();
        
        mysql_query("update r_calls set call_accepted=-1 where call_id=".$_POST['callid']);
        mysql_query("delete from r_call_activation_codes where ac_call_id=".$_POST['callid']);
        
        $res=mysql_query("select caller_user_id,callee_user_id from r_calls where call_id=".$_POST['callid']);
        $row=mysql_fetch_object($res);
        
        givePenalty($userSession->UserId);
        
        $userrep=new UserRepository();
        $user=$userrep->LoadById($row->callee_user_id);
        $calleruser=$userrep->LoadById($row->caller_user_id);
        
        $db=ServiceLocator::GetDatabase();
        $db->Connection->Connect();
        
        $morethanthreematches=false;//three is dynamic now

        $tmpres=mysql_query("select numAGFreeDecl from r_options");
        $tmprow=mysql_fetch_object($tmpres);
        $numofmatchesforfreedecl=$tmprow->numAGFreeDecl;

        $r=mysql_query("select * from r_calls where (caller_user_id=$row->callee_user_id or callee_user_id=$row->callee_user_id) and call_accepted=1 and call_completed=0");
        if (mysql_num_rows($r)>=$numofmatchesforfreedecl){//den tha dexthei poini
            $morethanthreematches=true;
        }
        
        ServiceLocator::GetEmailService()->Send(new CallDeclinedEmail($user,$calleruser,$morethanthreematches));
        $db=ServiceLocator::GetDatabase();
        $db->Connection->Connect();
        sms($_POST['callid'],$row->caller_user_id,2);
    }
	exit();
}

    
/////////
/////////
//Rvars//
/////////
/////////
if (isset($_POST['action']) && $_POST['action']=="newRankingVariables" && $userSession->IsAdmin){
	$db=ServiceLocator::GetDatabase();
    $db->Connection->Connect();  
    
    mysql_query("update r_options set numofpenalties=".$_POST['numofpenalties'].", numofdays=".$_POST['numofdays'].", maxcalldistance=".$_POST['maxcalldistance'].", numofdays_samecall=".$_POST['numOfDaysOfsamecall'].", numAGFreeDecl=".$_POST['numofacegames']." where 1");
	$tmp=explode(',',$_POST['distances']);
	$res=mysql_query("select * from r_points");
	if (mysql_num_rows($res)>0){
		if (mysql_num_rows($res)>$_POST['maxcalldistance']){
			mysql_query("delete from r_points  where  points_pos_difference > ".$_POST['maxcalldistance']);
		}
	}
	foreach($tmp as $key=>$value){
		$tmp2=explode('-',$value);
		foreach($tmp2 as $key1=>$value1){
			if ($key1==0){
				$diff=$value1;
			}
			if ($key1==1){
				$strong=$value1;
			}
			if ($key1==2){
				$weak=$value1;
			}
		}
		//echo "diff: ".$diff."strong: ".$strong."weak: ".$weak."\n";
		$res=mysql_query("select * from r_points where points_pos_difference=$diff");
		if (mysql_num_rows($res)>0){
			mysql_query("update r_points set points_strong=$strong, points_weak=$weak where points_pos_difference=$diff");
		}
		else{
			mysql_query("insert into r_points values(null,$diff,$strong,$weak)");
		}
	}
	
	$tmp=explode(',',$_POST['positions']);
	foreach($tmp as $key=>$value){
		$tmp2=explode('-',$value);
		foreach($tmp2 as $key1=>$value1){
			if ($key1==0){
				$posid=$value1;
			}
			if ($key1==1){
				$pospoints=$value1;
			}
		}
		//echo "diff: ".$diff."strong: ".$strong."weak: ".$weak."\n";
		$res=mysql_query("select * from r_tours_positions where position_id=$posid");
		mysql_query("update r_tours_positions set pos_points=$pospoints where position_id=$posid");
	}
	$_SESSION['rankingMessage']='Οι μεταβλητές της κατάταξης ενημερώθηκαν με επιτυχία!';
    
	exit;
}

/////////
/////////
//admin//
/////////
/////////
if (isset($_POST['action']) && $_POST['action']==='blocking' && $userSession->IsAdmin){
    $db=ServiceLocator::GetDatabase();
    $db->Connection->Connect();
        
	$date=$_POST['date'];
    $now=FALSE;
	if ($_POST['date'] <= date('d-m-Y')){
		mysql_query("update r_blocks set calls_block=1");
        $now=TRUE;
	}
	else{
		$newarr=explode('-',$date);
		$date=$newarr[2]."-".$newarr[1]."-".$newarr[0];
		mysql_query("update r_blocks set calls_block_scheduled=1,calls_block_schedule='$date'");
	}
    
    if($now){
        $_SESSION['rankingMessage']='Οι αγώνες κατάταξης έχουν μπλοκαριστεί';
    }
    else{
        $_SESSION['rankingMessage']='Οι αγώνες κατάταξης θα μπλοκαριστούν στις '.$_POST['date'];
    }
	exit;
}
if (isset($_POST['action']) && $_POST['action']==='unblocking' && $userSession->IsAdmin){
    pdoq("update r_blocks set calls_block=0, calls_block_scheduled=0, calls_block_schedule=NULL");
	
    $_SESSION['rankingMessage']='Οι αγώνες κατάταξης έχουν ενεργοποιηθεί';
    exit;
}
if (isset($_POST['action']) && $_POST['action']==='updateblock' && $userSession->IsAdmin){
	$db=ServiceLocator::GetDatabase();
    $db->Connection->Connect();
    $now=FALSE;
    if ($_POST['updateblockdate'] <= date('d-m-Y')){
		mysql_query("update r_blocks set calls_block=1, calls_block_scheduled=0, calls_block_schedule=NULL");
        $now=TRUE;
        
        $_SESSION['rankingMessage']='Οι αγώνες κατάταξης έχουν μπλοκαριστεί';
		exit();
	}
	$date=$_POST['updateblockdate'];
	$newarr=explode('-',$date);
	$date=$newarr[2]."-".$newarr[1]."-".$newarr[0];
	$res=mysql_query("update r_blocks set calls_block_scheduled=1,calls_block_schedule='$date', calls_block=0 where 1");
	
    $_SESSION['rankingMessage']='Οι αγώνες κατάταξης θα μπλοκαριστούν στις '.$_POST['updateblockdate'];
	exit();
}
if (isset($_POST['action']) && $_POST['action']=="insertNewTour" && $userSession->IsAdmin){
    $db=ServiceLocator::GetDatabase();
    $db->Connection->Connect();
    
    $tourname=filter_input(INPUT_POST, 'tourname', FILTER_SANITIZE_STRING);
    
    if(!$tourname || empty($tourname)){
        $_SESSION['rankingMessage']='Το όνομα του τουρνουά δεν μπορεί να είναι κενό';
        exit;
    }
    
    $res=mysql_query("select * from r_tours where tour_name='$tourname'");
	if (mysql_num_rows($res)==0){
		$date=$_POST['tourdate'];
		$newarr=explode('-',$date);
		$date=$newarr[2]."-".$newarr[1]."-".$newarr[0];
		$date2=$_POST['tourdateend'];
		$newarr=explode('-',$date2);
		$date2=$newarr[2]."-".$newarr[1]."-".$newarr[0];
		insertTour($tourname,$date,$date2);
	}
    
    $_SESSION['rankingMessage']="Η εισαγωγή του τουρνουά '$tourname' έγινε με επιτυχία";
	exit;
}
if (isset($_POST['action']) && $_POST['action']=="insertTour" && $userSession->IsAdmin){
	$db=ServiceLocator::GetDatabase();
    $db->Connection->Connect();
    
    //no automatic update. 
	//	updateRankings_insertTourPoints($_POST['tourid'],$_POST['sex']);
	//	updateRankings_insertCallPoints($_POST['tourid'],$_POST['sex']);
	//update points every monday
	$res=mysql_query("select * from r_tour_updates where tour_id=".$_POST['tourid']);
	if($row=mysql_fetch_object($res)){
		if($row->type==='remove'){//eksoudeterwse to remove
			mysql_query("delete from r_tour_updates where id=$row->id");
		}
	}
	else{//eisagwgi kanonika
		mysql_query("insert into r_tour_updates (type,tour_id) values ('insert',".$_POST['tourid'].")");
	}
	mysql_query("update r_tours set counts=1 where tour_id=".$_POST['tourid']);
    
    $_SESSION['rankingMessage']="Η εισαγωγή του τουρνουά '".fetch_tour_name($_POST['tourid'])."' και των σχετικών πόντων στην κατάταξη έχει προγραμματιστεί να γίνει την προκαθορισμένη ημέρα";
	exit;
}
if (isset($_POST['action']) && $_POST['action']=='removeTour' && $userSession->IsAdmin){
    $db=ServiceLocator::GetDatabase();
    $db->Connection->Connect();
    
	//no automatic update. 
	//	updateRankings_removeTourPoints($_POST['tourid']);
	//	updateRankings_removeCallPoints($_POST['tourid']);
	//update points every monday
	$res=mysql_query("select * from r_tour_updates where tour_id=".$_POST['tourid']);
	if($row=mysql_fetch_object($res)){
		if($row->type==='insert'){//eksoudeterwse to insert
			mysql_query("delete from r_tour_updates where id=$row->id");
		}
	}
	else{//eisagwgi kanonika
		mysql_query("insert into r_tour_updates (type,tour_id) values ('remove',".$_POST['tourid'].")");
	}
	mysql_query("update r_tours set counts=-1 where tour_id=".$_POST['tourid']);
    
    $_SESSION['rankingMessage']="Η αφαίρεση του τουρνουά '".fetch_tour_name($_POST['tourid'])."' και των σχετικών πόντων από την κατάταξη έχει προγραμματιστεί να γίνει την προκαθορισμένη ημέρα";
	exit;
}
if (isset($_POST['action']) && $_POST['action']=='insertTourPart' && $userSession->IsAdmin){
	$db=ServiceLocator::GetDatabase();
    $db->Connection->Connect();
    
    mysql_query("insert into r_tours_participants values(null,".$_POST['tourid'].",".$_POST['plrid'].",".$_POST['plrpos'].",-1,".$_POST['ranking'].")");
	exit();
}	
if (isset($_POST['action']) && $_POST['action']=='removeTourPart' && $userSession->IsAdmin){
	$db=ServiceLocator::GetDatabase();
    $db->Connection->Connect();
    
	$res=mysql_query("select r_tours_positions.pos_points,r_tours_participants.user_id,r_tours_participants.countedToRank from r_tours_positions inner join r_tours_participants on r_tours_positions.position_id = r_tours_participants.position_id where r_tours_participants.tours_part_id=".$_POST['partid']);
	$res=mysql_fetch_object($res);
    $ranking_table_name=getRankingTable($res->user_id);
	if ($res->countedToRank==1){
		mysql_query("update $ranking_table_name set rank_tot_points=rank_tot_points-$res->pos_points where rank_user_id=$res->user_id");
	}
	mysql_query("delete from r_tours_participants where tours_part_id=".$_POST['partid']);
	sortRankings();
	exit();
}
if (isset($_POST['action']) && $_POST['action']=="cancelCall" && $userSession->IsAdmin){
    pdoq("update r_calls set call_accepted=-1 where call_id=?",$_POST['callid']);
    //TODO
    //edw isws na stelnetai enimerwtiko email oti to paixnidi tous akyrwthike apo ton admin
    exit();
}