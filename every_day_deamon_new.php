<?php
define('ROOT_DIR','');
date_default_timezone_set ('Europe/Athens');
require_once(ROOT_DIR . 'Pages/Admin/ManageUsersPage.php');
require_once(ROOT_DIR . 'Web/inc/config.php');
require_once(ROOT_DIR . 'Web/inc/functions.php');
require_once(ROOT_DIR . 'Domain/Access/UserRepository.php');
require_once(ROOT_DIR . 'emailSendOrSchedule.php');

$todayDate = date("Y-m-d");
$daysNum=date('N', strtotime($todayDate));//deftera:1,triti:2...kyriaki:7
//echo "deamon activated<br>";

/*Block calls when scheduled*/
$res=mysql_query("select * from r_blocks");
$res=mysql_fetch_object($res);
if ($res->calls_block_scheduled){
	if ($res->calls_block_schedule==$todayDate){
		mysql_query("update r_blocks set calls_block = 1, calls_block_scheduled = 0, calls_block_schedule = '0000-00-00' where 1");//block calls
		mysql_query("update r_calls set call_accepted = -1 where (call_accepted = 0 or call_completed=0)");//cancel all open calls
	}
}
else if($res->calls_block){
	mysql_query("update r_calls set call_accepted = -1 where (call_accepted = 0 or call_completed=0)");//cancel all open calls
}

/*Unblock players when block deadline finished*/
$res=mysql_query("select * from r_user_blocks");

while ($row=mysql_fetch_object($res)){
	if ($row->bl_end==$todayDate){
		mysql_query("delete from r_user_blocks where user_id=".$row->user_id);//unblock player
	}
}

/*declines=declines-1 when bonus date*/
$today=date("Y-m-d");
$res=mysql_query("select * from r_numofdeclines where bonus_date='$today' and numofdeclines>0");
while($row=mysql_fetch_object($res)){
	$thirty_days_later=date("Y-m-d",strtotime("+ 30 days"));
	if($row->numofdeclines==1){
		mysql_query("update r_numofdeclines set numofdeclines=numofdeclines-1, bonus_date='0000-00-00' where user_id=$row->user_id");
	}
	else{
		mysql_query("update r_numofdeclines set numofdeclines=numofdeclines-1, bonus_date='$thirty_days_later' where user_id=$row->user_id");
	}
}

$todayTimestamp=strtotime($todayDate);
$userrep=new UserRepository();

/*Accept/Decline reminder emails and penalty
$res=mysql_query("select * from r_calls where call_accepted = 0");
while ($row=mysql_fetch_object($res)){
	$acceptDeclineTomorrowDeadline=strtotime('+4 days',strtotime($row->call_date));
	$acceptDeclineTodayDeadline=strtotime('+5 days',strtotime($row->call_date));
	$acceptDeclinePenaltyDeadline=strtotime('+6 days',strtotime($row->call_date));
	
	if($todayTimestamp>=$acceptDeclinePenaltyDeadline){
		givePenalty($row->callee_user_id, true);
		mysql_query("update r_calls set call_accepted=-1 where call_id =".$row->call_id);
	}
	else if($todayTimestamp>=$acceptDeclineTodayDeadline){
		$callee=$userrep->LoadById($row->callee_user_id);
		$caller=$userrep->LoadById($row->caller_user_id);
		require(ROOT_DIR . 'Web/inc/config.php');
                sendOrSchedule("CallReminderTodayEmail",$callee,$caller);
	}
	else if($todayTimestamp>=$acceptDeclineTomorrowDeadline){
		$callee=$userrep->LoadById($row->callee_user_id);
		$caller=$userrep->LoadById($row->caller_user_id);
		require(ROOT_DIR . 'Web/inc/config.php');
                sendOrSchedule("CallReminderTomorrowEmail",$callee,$caller);
	}
}
*/
/*Give penalty for outdated calls
$res=mysql_query("select * from r_calls where call_accepted = 1 and call_completed=0");
while ($row=mysql_fetch_object($res)){
	$dateScorePenaltyDeadline=strtotime('+13 days',strtotime($row->call_date));
	if($todayTimestamp>=$dateScorePenaltyDeadline){
		givePenalty($row->caller_user_id,false);//true for ignoring if has 2 open calls
		givePenalty($row->callee_user_id,false);
		mysql_query("update r_calls set call_accepted=-1 where call_id =".$row->call_id);
	}
}
*/
/*insert call date email reminder
$res=mysql_query("select * from r_calls where call_accepted=1 and match_date='0000-00-00'");
while ($row=mysql_fetch_object($res)){
	$dateScoreTodayDeadline=strtotime('+12 days',strtotime($row->call_date));
	$dateScoreTomorrowDeadline=strtotime('+11 days',strtotime($row->call_date));
	if($todayTimestamp>=$dateScoreTodayDeadline && $todayTimestamp<$dateScorePenaltyDeadline){
		$callee=$userrep->LoadById($row->callee_user_id);
		$caller=$userrep->LoadById($row->caller_user_id);
		require(ROOT_DIR . 'Web/inc/config.php');
                sendOrSchedule("InsertCallDateTodayEmail",$callee,$caller,TRUE);
	}
	else if($todayTimestamp>=$dateScoreTomorrowDeadline && $todayTimestamp<$dateScorePenaltyDeadline){
		$callee=$userrep->LoadById($row->callee_user_id);
		$caller=$userrep->LoadById($row->caller_user_id);
		require(ROOT_DIR . 'Web/inc/config.php');
                sendOrSchedule("InsertCallDateTomorrowEmail",$callee,$caller,TRUE);
	}
}

*/

/*insert call score email reminder
$res=mysql_query("select * from r_calls where call_accepted=1 and call_completed=0 and match_date!='0000-00-00'");
while ($row=mysql_fetch_object($res)){
	$dateScoreTodayDeadline=strtotime('+12 days',strtotime($row->call_date));
	$dateScoreTomorrowDeadline=strtotime('+11 days',strtotime($row->call_date));
	if($todayTimestamp>=$dateScoreTodayDeadline && $todayTimestamp<$dateScorePenaltyDeadline){
		$callee=$userrep->LoadById($row->callee_user_id);
		$caller=$userrep->LoadById($row->caller_user_id);
		require(ROOT_DIR . 'Web/inc/config.php');
                sendOrSchedule("InsertCallScoreTodayEmail",$callee,$caller,TRUE);
	}
	else if($todayTimestamp>=$dateScoreTomorrowDeadline && $todayTimestamp<$dateScorePenaltyDeadline){
		$callee=$userrep->LoadById($row->callee_user_id);
		$caller=$userrep->LoadById($row->caller_user_id);
		require(ROOT_DIR . 'Web/inc/config.php');
                sendOrSchedule("InsertCallScoreTomorrowEmail",$callee,$caller,TRUE);
	}
}
*/
if($daysNum==1){//an einai deftera
	//echo "today is Monday!<br>";
	//apothikefsi thesis kathe paixti prin tin ananewsi
	$res=mysql_query("select * from users u inner join r_rankings_mens r on u.user_id=r.rank_user_id");
	while($row=mysql_fetch_object($res)){
		$res1=mysql_query("select * from player_rank_details where user_id=".$row->user_id);
		$redo=true;
		if(mysql_num_rows($res1)>0){
			$redo=false;
			mysql_query("update player_rank_details set last_rank=$row->rank_pos where user_id=$row->user_id");
		}
		else{
			mysql_query("insert into player_rank_details (user_id,last_rank) values ($row->user_id,$row->rank_pos)");
		}
	}
	
	$res=mysql_query("select * from users u inner join r_rankings_women r on u.user_id=r.rank_user_id");
	while($row=mysql_fetch_object($res)){
		$res1=mysql_query("select * from player_rank_details where user_id=".$row->user_id);
		$redo=true;
		if(mysql_num_rows($res1)>0){
			$redo=false;
			mysql_query("update player_rank_details set last_rank=$row->rank_pos where user_id=$row->user_id");
		}
		else{
			mysql_query("insert into player_rank_details (user_id,last_rank) values ($row->user_id,$row->rank_pos)");
		}
	}
	//telos apothikefsi thesis kathe paixti prin tin ananewsi
	
/*Update ranking points from calls 52-week system*/
	///////////////////
	//points removal//
	//////////////////
	
	//to makrynari ypologizei to yearweek tis xthesinis imeras, prin ena xrono
	$res=mysql_query("select sum(match_points_won) as total_points, match_winner_user_id as user_id from r_calls where yearweek = '".date('oW',strtotime('-1 year -1 day'))."' group by match_winner_user_id");
	while($row=mysql_fetch_object($res)){
		mysql_query("update r_rankings_mens set rank_tot_points=rank_tot_points-$row->total_points where rank_user_id=$row->user_id");
		mysql_query("update r_rankings_women set rank_tot_points=rank_tot_points-$row->total_points where rank_user_id=$row->user_id");
	}
	mysql_query("update r_calls set yearweek='' where yearweek = '".date('oW',strtotime('-1 year -1 day'))."'");
	
	//////////////
	//points add//
	//////////////
	
	$res=mysql_query("select sum(match_points_won) as total_points, match_winner_user_id as user_id from r_calls where toInsert=1 group by match_winner_user_id");
	while($row=mysql_fetch_object($res)){
		mysql_query("update r_rankings_mens set rank_tot_points=rank_tot_points+$row->total_points where rank_user_id=$row->user_id");
		mysql_query("update r_rankings_women set rank_tot_points=rank_tot_points+$row->total_points where rank_user_id=$row->user_id");
	}
	mysql_query("update r_calls set toInsert=0, countedToRank=1 where toInsert=1");
	sortRankings();	
	
	
	//Update ranking points from tours once a week when scheduled to (insert or remove tour during week)
	$res=mysql_query("select * from r_tour_updates");
	while ($row=mysql_fetch_object($res)){
		if($row->type=='insert'){
			updateRankings_insertTourPoints($row->tour_id);
		}
		else if($row->type=='remove'){
			updateRankings_removeTourPoints($row->tour_id);
		}
	}
	mysql_query("delete from r_tour_updates where 1");
	
	//update heightest ranking
	$now = date("Y-m-d");
	$week_start=(date('w', strtotime($now)) == 1) ? $now : date("Y-m-d",strtotime('last monday', strtotime($now)));
	$week_start.=" 00:00:00";
	
	$week_end=(date('w', strtotime($now)) == 0) ? $now : date("Y-m-d",strtotime('next sunday', strtotime($now)));
//	$week_end.=" 23:59:59";
	
	$res=mysql_query("select * from users u inner join r_rankings_mens r on u.user_id=r.rank_user_id");
	while($row=mysql_fetch_object($res)){
		mysql_query("insert into week_positions (week_start,user_id,position) values ('$week_start',$row->user_id,$row->rank_pos)");
		$res1=mysql_query("select * from player_rank_details where user_id=".$row->user_id);
		$row1=mysql_fetch_object($res1);
		if($row1->heightest_rank>$row->rank_pos || $row1->heightest_rank==0){
			mysql_query("update player_rank_details set heightest_rank=$row->rank_pos where user_id=$row1->user_id");
		}
	}
	
	$res=mysql_query("select * from users u inner join r_rankings_women r on u.user_id=r.rank_user_id");
	while($row=mysql_fetch_object($res)){
		mysql_query("insert into week_positions (week_start,user_id,position) values ('$week_start',$row->user_id,$row->rank_pos)");
		$res1=mysql_query("select * from player_rank_details where user_id=".$row->user_id);
		$row1=mysql_fetch_object($res1);
		if($row1->heightest_rank>$row->rank_pos || $row1->heightest_rank==0){
			mysql_query("update player_rank_details set heightest_rank=$row->rank_pos where user_id=$row1->user_id");
		}
	}
	//telos update heightest ranking
}
?>