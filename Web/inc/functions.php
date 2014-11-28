<?php

include_once('config.php');

function utcToAthens($utc_dt){
    $utc_tz =  new DateTimeZone('UTC');
    $ath_tz = new DateTimeZone('Europe/Athens');

    $dt = new DateTime($utc_dt, $utc_tz);
    $dt->setTimeZone($ath_tz);

    $ath_dt = $dt->format('Y-m-d H:i:s');

    return $ath_dt;
}

/*
message types:
0: you have new call
1: call accepted
2: call declined
3: ace game has been scheduled
4: ace game score has been submitted
*/
function sms($callid,$reciever_id,$message_type){
	$res=mysql_query("select * from r_calls where call_id=$callid");
	if($row=mysql_fetch_object($res)){
	//echo $row->caller_user_id." - ".$reciever_id."<br />";
		if($row->caller_user_id==$reciever_id){
			$res1=mysql_query("select fname,lname,phone from users where user_id=$row->callee_user_id");
			$row1=mysql_fetch_object($res1);
			$name=$row1->fname.' '.$row1->lname;
			if($row1->phone!=''){
				$phone='('.$row1->phone.')';
			}
			else{
				$phone='';
			}
		}
		else{
			$res1=mysql_query("select fname,lname,phone from users where user_id=$row->caller_user_id");
			$row1=mysql_fetch_object($res1);
			$name=$row1->fname.' '.$row1->lname;
			if($row1->phone!=''){
				$phone='('.$row1->phone.')';
			}
			else{
				$phone='';
			}
		}
		
		if($message_type==0){
			$sms_content="Ο χρήστης $name $phone σας προσκάλεσε σε αγώνα. Παρακαλώ μπείτε στο Ace Booking για να αποδεχθείτε ή να απορρίψετε την πρόσκληση.";
		}
		else if($message_type==1){
			$sms_content="Ο χρήστης $name $phone αποδέχθηκε την πρόσκληση. Επικοινωνήστε μαζί του και έπειτα ορίστε ημερομηνία διεξαγωγής του αγώνα.";
		}
		else if($message_type==2){
			if($row->caller_user_id==$reciever_id){
				$userid=$row->callee_user_id;
			}
			else{
				$userid=$row->caller_user_id;
			}
			
			$morethanthreematches=false;//three matches is dynamic now
			
			$tmpres=mysql_query("select numAGFreeDecl from r_options");
			$tmprow=mysql_fetch_object($tmpres);
			$numofmatchesforfreedecl=$tmprow->numAGFreeDecl;
		
			$r=mysql_query("select * from r_calls where (caller_user_id=$userid or callee_user_id=$userid) and call_accepted=1 and call_completed=0");
			if (mysql_num_rows($r)>=$numofmatchesforfreedecl){//den tha dexthei poini
				$morethanthreematches=true;
			}
			
			if($morethanthreematches){
				$sms_content="Ο χρήστης $name $phone απέρριψε την πρόσκλησή σας (Έχει ".$numofmatchesforfreedecl." ή περισσότερους αγώνες σε εκκρεμότητα).";
			}
			else{
				$sms_content="Ο χρήστης $name $phone απέρριψε την πρόσκλησή σας.";
			}
		}
		else if($message_type==3){
			$r=mysql_query("select entity_id from r_call_entity_id where call_id=$callid");
			$r=mysql_fetch_object($r);
			$r1=mysql_query("select start_date from reservation_instances where series_id=$r->entity_id");
			$r1=mysql_fetch_object($r1);
			$greek_start_datetime=date('Y-m-d H:i',strtotime(utcToAthens($r1->start_date)));
			$tmp=explode(' ',$greek_start_datetime);
			$date=changeDate($tmp[0]);
			$hour=$tmp[1];
			
			$r2=mysql_query("select resource_id from reservation_resources where series_id=$r->entity_id");
			$r2=mysql_fetch_object($r2);
			$r3=mysql_query("select name from resources where resource_id=$r2->resource_id");
			$r3=mysql_fetch_object($r3);
			$court_name=$r3->name;
			
			$sms_content="Ο χρήστης $name $phone όρισε τον μεταξύ σας αγώνα για τις $date @$hour $court_name.";
		}
		else if($message_type==4){
			$sms_content="Ο χρήστης $name $phone έκανε εισαγωγή του σκόρ του μεταξύ σας αγώνα.";
		}
		else{
			return;
		}
		$res=mysql_query("select phone from users where user_id=$reciever_id");
		if($row=mysql_fetch_object($res)){
			$phone=$row->phone;
			$phone = preg_replace('[\D]', '', $phone);//afairesi olwn ektos twn arithmwn
			if(strlen($phone)==10 && strcmp($phone,$row->phone)==0){//an einai 10 xaraktires kai den iparxei xaraktiras sto tilefwno tote apostoli
				$sendtime=date('H:i');
				$flag=false;
				if(strtotime($sendtime)>strtotime('22:00:00')){
					$senddatetime=date('Y-m-d',strtotime('+1 day',strtotime(date('Y-m-d')))).' 09:00';
					$flag=true;
				}
				else if(strtotime($sendtime)<strtotime('09:00:00')){
					$senddatetime=date('Y-m-d').' 09:00';
					$flag=true;
				}
				if($flag){
					$params = array(
						'username' => 'glamprou_acetennis',          //username used in HQSMS
						'password' => md5('acecodeplus'),     
						'to'       => '0030'.$phone,       //destination number
						'from'     => "Ace Tennis",            //sender name have to be activated
						'message'  => $sms_content,
						'datacoding'  => 'gsm',
  		 	 		'date' => strtotime($senddatetime)
					);
				}
				else{
					$params = array(
						'username' => 'glamprou_acetennis',          //username used in HQSMS
						'password' => md5('acecodeplus'),     
						'to'       => '0030'.$phone,       //destination number
						'from'     => "Ace Tennis",            //sender name have to be activated
						'message'  => $sms_content,
						'datacoding'  => 'gsm'
					);
				}
				if ($params['username'] && $params['password'] && $params['to'] && $params['message']) {
					$data = '?'.http_build_query($params);
					$file = fopen('https://ssl.hqsms.com/sms.do'.$data,'r');
					$result = fread($file,1024);
					fclose($file);
				}
			}
		}
	}
}

/*Calls Blocking/Unblocking*/
function blockCalls(){
	mysql_query("update r_blocks set calls_block=1");
	
	$res=mysql_query("select * from r_calls order by call_id desc LIMIT 1");
	$res=mysql_fetch_object($res);
	$last_call_id = $res->call_id;
	$res=mysql_query("select max(tour_id) as max from r_tours");
	if($res=mysql_fetch_object($res))
		$last_tour_id = $res->max;
	else
		$last_tour_id=1;
		
	mysql_query("replace into r_belongs_to (bel_id,max_call_id,tour_id) values(null,$last_call_id,$last_tour_id)");
}
function unblockCalls(){
	mysql_query("update r_blocks set calls_block=0");
}
function scheduleBlock($when){
	mysql_query("update r_blocks set calls_block_scheduled=1,calls_block_schedule='$when'");
}
function unScheduleBlock(){
	mysql_query("update r_blocks set calls_block_scheduled=0,calls_block_schedule=''");
}
function isCallsBlocked($var){
	if ($var=="schedule"){
		$res=mysql_query("select calls_block,calls_block_scheduled from r_blocks");
		$res=mysql_fetch_object($res);
		
		if ($res->calls_block || $res->calls_block_scheduled)
			return 1;
		else
			return 0;
	}
	else{
		$res=mysql_query("select calls_block from r_blocks");
		$res=mysql_fetch_object($res);
		return $res->calls_block;
	}
}
/*END OF Calls Blocking/Unblocking */

/*Calls Handling*/
function newCall($caller,$callee){	
	mysql_query("insert into r_calls (caller_user_id,callee_user_id,call_date) values ('$caller','$callee','".date("Y-m-d")."')");
	$res=mysql_query("select * from r_tours where counts=1 order by tour_date_fin desc limit 1");
	if (mysql_num_rows($res)>0){
		$row=mysql_fetch_object($res);
		$res2=mysql_query("select * from r_belongs_to where tour_id=".$row->tour_id);
		if (mysql_num_rows($res2)>0){
			$row2=mysql_fetch_object($res2);
			$res3=mysql_query("select call_id from r_calls where 1 order by call_id desc limit 1");
			$res3=mysql_fetch_object($res3);
			$lastcallid=$res3->call_id;
			
			mysql_query("update r_belongs_to set end_call_id=$lastcallid where bel_id=".$row2->bel_id);
		}
		else{
			$res3=mysql_query("select call_id from r_calls where 1 order by call_id desc limit 1");
			$res3=mysql_fetch_object($res3);
			$lastcallid=$res3->call_id;
			$res4=mysql_query("select end_call_id from r_belongs_to where 1 order by end_call_id desc limit 1");
			if (mysql_num_rows($res4)>0){
				$res4=mysql_fetch_object($res4);
				//echo $res4->maxi;
				$newstart=$res4->end_call_id+1;
			}
			else{
				$newstart=1;
			}
			mysql_query("insert into r_belongs_to values (null,$newstart,$lastcallid,$row->tour_id)");
		}
	}
	else{
		//den iparxei tournoua
	}
	
	/*store players' positions and running difference at the time of the call*/
	mysql_query("insert into r_call_init_pos values($lastcallid,".fetch_player_rank($caller).",".fetch_player_rank($callee).",".fetch_running_difference($caller,$callee).")");
	
	//apothikefsi activation code klp
	$flag=true;
	while($flag){
		$activation_code=sha1(mt_rand(10000,99999).time(). $callee);
		$res=mysql_query("select * from r_call_activation_codes where ac_code='$activation_code'");
		if(mysql_num_rows($res)==0){
			$flag=false;
		}
	}
	if(!isset($lastcallid)){
		$res3=mysql_query("select call_id from r_calls where 1 order by call_id desc limit 1");
		$res3=mysql_fetch_object($res3);
		$lastcallid=$res3->call_id;
	}
	mysql_query("insert into r_call_activation_codes (ac_code, ac_callee_id, ac_call_id) values ('$activation_code',$callee,$lastcallid)");
	//apothikefsi activation code klp
	
	$res=mysql_query("select call_id from r_calls where 1 order by call_id desc limit 1");
	$row=mysql_fetch_object($res);
	return $row->call_id;
}

function fetch_running_difference($caller,$callee){
	$res=mysql_query("select rank_id from r_rankings_mens where rank_user_id=".$caller);
	if (mysql_num_rows($res)>0){
		$user1table="r_rankings_mens";
	}
	$res1=mysql_query("select rank_id from r_rankings_mens where rank_user_id=".$callee);
	if (mysql_num_rows($res1)>0){
		$user2table="r_rankings_mens";
	}
	$res2=mysql_query("select rank_id from r_rankings_women where rank_user_id=".$caller);
	if (mysql_num_rows($res2)>0){
		$user1table="r_rankings_women";
	}
	$res3=mysql_query("select rank_id from r_rankings_women where rank_user_id=".$callee);
	if (mysql_num_rows($res3)>0){
		$user2table="r_rankings_women";
	}
	
	$r=mysql_query("select rank_pos from $user1table where rank_user_id=$caller");
	$r=mysql_fetch_object($r);
	$rank1=$r->rank_pos;
	$r=mysql_query("select rank_pos from $user2table where rank_user_id=$callee");
	$r=mysql_fetch_object($r);
	$rank2=$r->rank_pos;
	
	if($rank1>$rank2){
		$it=$rank1-1;
		$diff=1;
		while($it>$rank2){
			$pos_valid=false;
			$res=mysql_query("select * from $user1table where rank_pos=$it");
			while($row=mysql_fetch_object($res)){
				$res1=mysql_query("select * from r_user_blocks where user_id=".$row->rank_user_id);
				if (!(isInjured($row->rank_user_id) || mysql_num_rows($res1)>0)){
					$pos_valid=true;
				}
			}
			if($pos_valid){
				$diff++;
			}
			$it--;
		}
	}
	elseif($rank1<$rank2){
		$it=$rank2-1;
		$diff=1;
		while($it>$rank1){
			$pos_valid=false;
			$res=mysql_query("select * from $user1table where rank_pos=$it");
			while($row=mysql_fetch_object($res)){
				$res1=mysql_query("select * from r_user_blocks where user_id=".$row->rank_user_id);
				if (!(isInjured($row->rank_user_id) || mysql_num_rows($res1)>0)){
					$pos_valid=true;
				}
			}
			if($pos_valid){
				$diff++;
			}
			$it--;
		}
	}
	else{
		return 0;//same position??
	}
	
	return $diff;
}
function acceptCall($call_id){
	mysql_query("update r_calls set call_accepted=1 where call_id=$call_id");
}
function setMatchDateTime($call_id,$datetime){//date("Y-m-d H:i:s")
	mysql_query("update r_calls set match_datetime='$datetime' where call_id=$call_id");
}
function updateMatchDateTime($call_id,$datetime){//date("Y-m-d H:i:s")
	mysql_query("update r_calls set match_datetime='$datetime' where call_id=$call_id");
}
function matchCompleted($call_id,$set1,$set1_tb,$set2,$set2_tb,$stb,$winner_id,$points_won){
	mysql_query("update r_calls set call_completed=1 , match_set1=$set1 , match_set1_tb=$set1_tb , match_set2=$set2 , match_set2_tb=$set2_tb , match_stb=$stb , match_winner_user_id=$winner_id , match_points_won=$points_won where call_id=$call_id");
}
function matchCanceled($call_id){
	mysql_query("update r_calls set call_completed=-1  where call_id=$call_id");
}
/*END OF Calls Handling*/

/*Rankings Handling*/
function sortRankings(){
	$res=mysql_query("select * from r_rankings_mens order by rank_tot_points desc");
	$oldpos=0;
	$oldpoints=0;
	while ($row=mysql_fetch_object($res)){
		if($row->rank_tot_points==$oldpoints){
			mysql_query("update r_rankings_mens set rank_pos=$oldpos where rank_user_id=$row->rank_user_id");
		}
		else{
			$oldpos++;
			mysql_query("update r_rankings_mens set rank_pos=$oldpos where rank_user_id=$row->rank_user_id");
			$oldpoints=$row->rank_tot_points;
		}
	}
	$res=mysql_query("select * from r_rankings_women order by rank_tot_points desc");
	$oldpos=0;
	$oldpoints=0;
	while ($row=mysql_fetch_object($res)){
		if($row->rank_tot_points==$oldpoints){
			mysql_query("update r_rankings_women set rank_pos=$oldpos where rank_user_id=$row->rank_user_id");
		}
		else{
			$oldpos++;
			mysql_query("update r_rankings_women set rank_pos=$oldpos where rank_user_id=$row->rank_user_id");
			$oldpoints=$row->rank_tot_points;
		}
	}
}
/*function updateRankings_Calls(){
	$res=mysql_query("select call_id,match_winner_user_id,match_points_won from r_calls where countedToRank=0 AND call_completed=1");
	while($row=mysql_fetch_object($res)){
		mysql_query("update r_rankings set rank_tot_points=rank_tot_points+$row->match_points_won where rank_user_id=$row->match_winner_user_id");
		mysql_query("update r_rankings_women set rank_tot_points=rank_tot_points+$row->match_points_won where rank_user_id=$row->match_winner_user_id");
		mysql_query("update r_calls set countedToRank=1 where call_id=$row->call_id");
	}
	sortRankings();
}*/
function updateRankings_Tours($tourid){
	if ($tourid=='all'){
		$res=mysql_query("select tours_part_id,user_id,position_id,tour_id from r_tours_participants where countedToRank!=1 ");
		while($row=mysql_fetch_object($res)){
			$res1=mysql_query("select pos_points from r_tours_positions where position_id=$row->position_id");
			$res1=mysql_fetch_object($res1);
			mysql_query("update r_rankings_mens set rank_tot_points=rank_tot_points+$res1->pos_points where rank_user_id=$row->user_id");
			mysql_query("update r_rankings_women set rank_tot_points=rank_tot_points+$res1->pos_points where rank_user_id=$row->user_id");
			mysql_query("update r_tours_participants set countedToRank=1 where tours_part_id=$row->tours_part_id");
			mysql_query("update r_tours set counts=1 where tour_id=$row->tour_id");
		}
	}
	else{
		$res=mysql_query("select tours_part_id,user_id,position_id,tour_id from r_tours_participants where countedToRank=0 and tour_id=$tourid");
		while($row=mysql_fetch_object($res)){
			$res1=mysql_query("select pos_points from r_tours_positions where position_id=$row->position_id");
			$res1=mysql_fetch_object($res1);
			mysql_query("update r_rankings_mens set rank_tot_points=rank_tot_points+$res1->pos_points where rank_user_id=$row->user_id");
			mysql_query("update r_rankings_women set rank_tot_points=rank_tot_points+$res1->pos_points where rank_user_id=$row->user_id");
			mysql_query("update r_tours_participants set countedToRank=1 where tours_part_id=$row->tours_part_id");
			mysql_query("update r_tours set counts=1 where tour_id=$row->tour_id");
		}
	}
	sortRankings();	
}
function updateRankings_insertTourPoints($tourid){
	$res=mysql_query("select tours_part_id,user_id,position_id from r_tours_participants where tour_id=".$tourid." and countedToRank=-1");
	while($row=mysql_fetch_object($res)){
		$res1=mysql_query("select pos_points from r_tours_positions where position_id=$row->position_id");
		$res1=mysql_fetch_object($res1);
		mysql_query("update r_rankings_mens set rank_tot_points=rank_tot_points+$res1->pos_points where rank_user_id=$row->user_id");
		mysql_query("update r_rankings_women set rank_tot_points=rank_tot_points+$res1->pos_points where rank_user_id=$row->user_id");
		mysql_query("update r_tours_participants set countedToRank=1 where tours_part_id=$row->tours_part_id");
	}
	sortRankings();
}
function updateRankings_insertCallPoints($tourid){
	$res=mysql_query("select r_belongs_to.start_call_id from r_belongs_to inner join r_tours on r_belongs_to.tour_id = r_tours.tour_id where r_tours.tour_id >= $tourid order by r_tours.tour_date asc limit 1");
	if($res=mysql_fetch_object($res)){
		$res1=mysql_query("select * from r_calls where call_id >= $res->start_call_id and call_completed = 1 and (countedToRank = -1 or countedToRank = 0)");
		while ($row1=mysql_fetch_object($res1)){
			mysql_query("update r_rankings_mens set rank_tot_points=rank_tot_points+$row1->match_points_won where rank_user_id=$row1->match_winner_user_id");
			mysql_query("update r_rankings_women set rank_tot_points=rank_tot_points+$row1->match_points_won where rank_user_id=$row1->match_winner_user_id");
			mysql_query("update r_calls set countedToRank= 1 where call_id=$row1->call_id");
		}
		sortRankings();
	}	
}
function updateRankings_removeTourPoints($tourid){
	$res=mysql_query("select tours_part_id,user_id,position_id from r_tours_participants where tour_id=".$tourid." and countedToRank=1");
	while($row=mysql_fetch_object($res)){
		$res1=mysql_query("select pos_points from r_tours_positions where position_id=$row->position_id");
		$res1=mysql_fetch_object($res1);
		mysql_query("update r_rankings_mens set rank_tot_points=rank_tot_points-$res1->pos_points where rank_user_id=$row->user_id");
		mysql_query("update r_rankings_women set rank_tot_points=rank_tot_points-$res1->pos_points where rank_user_id=$row->user_id");
		mysql_query("update r_tours_participants set countedToRank=-1 where tours_part_id=$row->tours_part_id");
	}
	$res=mysql_query("select tours_part_id,user_id,position_id from r_tours_participants where tour_id=".$tourid." and countedToRank=0");
	while($row=mysql_fetch_object($res)){
		mysql_query("update r_tours_participants set countedToRank=-1 where tours_part_id=$row->tours_part_id");
	}
	sortRankings();
}
function updateRankings_removeCallPoints($tourid){
	$res=mysql_query("select * from r_tours where tour_id < $tourid and counts=1");
	if (mysql_num_rows($res)==0){//prepei na svistoun calls
		$res2=mysql_query("select tour_id from r_tours where tour_id > $tourid and counts=1 order by tour_id asc limit 1");
		if($res2=mysql_fetch_object($res2)){
			$res3=mysql_query("select max(end_call_id) as max from r_belongs_to where tour_id < $res2->tour_id");
			if ($res3=mysql_fetch_object($res3)){
				$res4=mysql_query("select call_id,match_winner_user_id,match_points_won from r_calls where countedToRank=1 and call_id<=$res3->max");
				while($row4=mysql_fetch_object($res4)){
					mysql_query("update r_rankings_mens set rank_tot_points=rank_tot_points-$row4->match_points_won where rank_user_id=$row4->match_winner_user_id");
					mysql_query("update r_rankings_women set rank_tot_points=rank_tot_points-$row4->match_points_won where rank_user_id=$row4->match_winner_user_id");
					mysql_query("update r_calls set countedToRank=-1 where call_id=$row4->call_id");
				}
				//return "prepei na svistoun OLA ta calls me id mexri KAI: $res3->max \n";
			}
		}
		else{
			$res4=mysql_query("select call_id,match_winner_user_id,match_points_won from r_calls where countedToRank=1");
			while($row4=mysql_fetch_object($res4)){
				mysql_query("update r_rankings_mens set rank_tot_points=rank_tot_points-$row4->match_points_won where rank_user_id=$row4->match_winner_user_id");
				mysql_query("update r_rankings_women set rank_tot_points=rank_tot_points-$row4->match_points_won where rank_user_id=$row4->match_winner_user_id");
				mysql_query("update r_calls set countedToRank=-1 where call_id=$row4->call_id");
			}
		}
	}
	//return ;//den tha afairethei kanena call apo to ranking
	sortRankings();
}
/*function addPlayerPoints($user_id,$points){
	mysql_query("update r_rankings set rank_tot_points=rank_tot_points+$points where rank_user_id=$user_id");
	sortRankings();
}*/
/*END OF Rankings Handling*/

/*Tours Handling*/
function insertTour($name,$startdate,$enddate){
	mysql_query("insert into r_tours values(null,'$name','$startdate','$enddate',-1)");
}
function insertTourParticipants($tour_id,$user_id,$position_id){
	//echo $tour_id." - ".$user_id." - ".$position_id;
	mysql_query("insert into r_tours_participants values(null,$tour_id,$user_id,$position_id,-1,0)");
}
/*END OF Tours Handling*/
function changeDate($date){
	$newarr=explode('-',$date);
	return $newarr[2]."-".$newarr[1]."-".$newarr[0];
}
function fetch_winner_id_points($callid,$retid){
	$res=mysql_query("select * from r_calls where call_id=".$callid);
	$res=mysql_fetch_object($res);
	if (!$retid){
		$firstplrsetswon=0;
		$tmp=$res->match_set1;
		$tmp=explode('-',$tmp);
		if ($tmp[0]>$tmp[1]){
			$firstplrsetswon++;
		}
		$tmp=$res->match_set2;
		$tmp=explode('-',$tmp);
		if ($tmp[0]>$tmp[1]){
			$firstplrsetswon++;
		}
		if ($firstplrsetswon==1){
			$tmp=$res->match_stb;
			$tmp=explode('-',$tmp);
			if ($tmp[0]>$tmp[1]){
				$firstplrsetswon++;
			}	
		}
		if ($firstplrsetswon==2){
			$winandpoints=array();
			$winandpoints[0]=$res->caller_user_id;
			$winandpoints[1]=fetch_points_by_callid($res->caller_user_id,$res->callee_user_id,$res->caller_user_id,$res->call_id);
			return $winandpoints;
		}
		else{
			$winandpoints=array();
			$winandpoints[0]=$res->callee_user_id;
			$winandpoints[1]=fetch_points_by_callid($res->caller_user_id,$res->callee_user_id,$res->callee_user_id,$res->call_id);
			return $winandpoints;
		}
	}
	else{
		if ($retid==$res->caller_user_id){
			$winandpoints=array();
			$winandpoints[0]=$res->callee_user_id;
			$winandpoints[1]=fetch_points_by_callid($res->caller_user_id,$res->callee_user_id,$res->callee_user_id,$res->call_id);
			return $winandpoints;
		}
		else{
			$winandpoints=array();
			$winandpoints[0]=$res->caller_user_id;
			$winandpoints[1]=fetch_points_by_callid($res->caller_user_id,$res->callee_user_id,$res->caller_user_id,$res->call_id);
			return $winandpoints;
		}	
	}
}
function fetch_points($userid1,$userid2,$winnerid){
	$r=mysql_query("select rank_pos from r_rankings_mens where rank_user_id=$userid1");
	if (mysql_num_rows($r)==0){
		$r=mysql_query("select rank_pos from r_rankings_women where rank_user_id=$userid1");
	}
	$r=mysql_fetch_object($r);
	$rank1=$r->rank_pos;
	$r=mysql_query("select rank_pos from r_rankings_mens where rank_user_id=$userid2");
	if (mysql_num_rows($r)==0){
		$r=mysql_query("select rank_pos from r_rankings_women where rank_user_id=$userid2");
	}
	$r=mysql_fetch_object($r);
	$rank2=$r->rank_pos;
	$diff=abs($rank1-$rank2);
	if ($diff<1 || $diff>5)
		return '';
	$r=mysql_query("select points_strong, points_weak from r_points where points_pos_difference=$diff");
	$r=mysql_fetch_object($r);
	if ($winnerid==$userid1){
		if ($rank1<$rank2){
			return $r->points_strong;
		}
		else{
			return $r->points_weak;
		}
	}
	else{
		if ($rank1<$rank2){
			return $r->points_weak;
		}
		else{
			return $r->points_strong;
		}
	}
}
function fetch_points_by_callid($userid1,$userid2,$winnerid,$callid){
	$r=mysql_query("select * from r_call_init_pos where call_id=$callid");
	$r=mysql_fetch_object($r);
	if(!$r){
		return fetch_points($userid1,$userid2,$winnerid);
	}
		
	$diff=$r->diff;
	
	if ($diff<1 || $diff>5)
		return '';
	$r=mysql_query("select points_strong, points_weak from r_points where points_pos_difference=$diff");
	$r=mysql_fetch_object($r);
	if ($winnerid==$userid1){
		if ($rank1<$rank2){
			return $r->points_strong;
		}
		else{
			return $r->points_weak;
		}
	}
	else{
		if ($rank1<$rank2){
			return $r->points_weak;
		}
		else{
			return $r->points_strong;
		}
	}
}
function fetch_player_name($userid){
	$r=mysql_query("select fname,lname from users where user_id=$userid");
	$r=mysql_fetch_object($r);
	return $r->fname." ".$r->lname;
}
function fetch_player_rank($userid){
	$r=mysql_query("select rank_pos from r_rankings_mens where rank_user_id=$userid");
	if (mysql_num_rows($r)==0){
		$r=mysql_query("select rank_pos from r_rankings_women where rank_user_id=$userid");
	}
	$r=mysql_fetch_object($r);
	return $r->rank_pos;
}
function fetch_player_call_rank($callid,$userid,$callerorcallee){
	$r=mysql_query("select * from r_call_init_pos where call_id=$callid");
	$r=mysql_fetch_object($r);
	if(!$r){
		$r=mysql_query("select rank_pos from r_rankings_mens where rank_user_id=$userid");
		if (mysql_num_rows($r)==0){
			$r=mysql_query("select rank_pos from r_rankings_women where rank_user_id=$userid");
		}
		$r=mysql_fetch_object($r);
		return $r->rank_pos;
	}
	if($callerorcallee==0){
		return $r->caller_pos;
	}
	else{
		return $r->callee_pos;
	}
}
function canBeCalled($userid1,$userid2){
	$res=mysql_query("select rank_id from r_rankings_mens where rank_user_id=".$userid1);
	if (mysql_num_rows($res)>0){
		$user1table="r_rankings_mens";
	}
	$res1=mysql_query("select rank_id from r_rankings_mens where rank_user_id=".$userid2);
	if (mysql_num_rows($res1)>0){
		$user2table="r_rankings_mens";
	}
	$res2=mysql_query("select rank_id from r_rankings_women where rank_user_id=".$userid1);
	if (mysql_num_rows($res2)>0){
		$user1table="r_rankings_women";
	}
	$res3=mysql_query("select rank_id from r_rankings_women where rank_user_id=".$userid2);
	if (mysql_num_rows($res3)>0){
		$user2table="r_rankings_women";
	}
	if ($user1table!=$user2table)
		return false;
	
	if (isInjured($userid1) || isInjured($userid2))
		return false;
	$res=mysql_query("select calls_block from r_blocks");
	$res=mysql_fetch_object($res);
	$res1=mysql_query("select * from r_user_blocks where user_id=".$userid1." or user_id=".$userid2);
	if ($res->calls_block || mysql_num_rows($res1)>0)
		return false;
	
	$res=mysql_query("select numofdays_samecall from r_options");
	$res=mysql_fetch_object($res);
	$r=mysql_query("select * from r_calls where ((caller_user_id=$userid1 and callee_user_id=$userid2) or (caller_user_id=$userid2 and callee_user_id=$userid1)) order by call_id desc limit 1");
	if ($r=mysql_fetch_object($r)){
		if ($r->call_accepted==0 || ($r->call_accepted==1 && $r->call_completed!=1)){
			return 0;
		}else{
			if ($r->call_accepted==1){
				$todayDate = date("Y-m-d");
				$diff = abs(strtotime($todayDate) - strtotime($r->match_date));
				$betweensamecall = floor($diff / (60*60*24));
				if ($betweensamecall<$res->numofdays_samecall){
					return 0;
				}
			}/*
			else{
				echo "akirwmeno mats";	
			}*/
		}	
	}/*
	else{
		echo "den exoune paiksei";	
	}*/
	
	$r=mysql_query("select rank_pos from $user1table where rank_user_id=$userid1");
	$r=mysql_fetch_object($r);
	$rank1=$r->rank_pos;
	$r=mysql_query("select rank_pos from $user2table where rank_user_id=$userid2");
	$r=mysql_fetch_object($r);
	$rank2=$r->rank_pos;
	$diff=$rank1-$rank2;
	
	$res1=mysql_query("select maxcalldistance from r_options");
	$res1=mysql_fetch_object($res1);
	
	$ideal_maxcalldistance=$res1->maxcalldistance;
	$last_callable_rank=$rank1;
	while($ideal_maxcalldistance>0){
		$pos_valid=false;
		$ideal_maxcalldistance--;		
		$last_callable_rank--;
		$res=mysql_query("select * from $user1table where rank_pos=$last_callable_rank");
		while($row=mysql_fetch_object($res)){
			$res1=mysql_query("select * from r_user_blocks where user_id=".$row->rank_user_id);
			if (!(isInjured($row->rank_user_id) || mysql_num_rows($res1)>0)){
				$pos_valid=true;
			}
		}
		if($last_callable_rank<2){
			break;
		}
		if(!$pos_valid){
			$ideal_maxcalldistance++;
		}
	}
	if($last_callable_rank<1) $last_callable_rank=1;
	if ($rank2<$last_callable_rank || $rank2>=$rank1){
	echo $diff;
		return false;
	}
	else{
		return true;
	}
}
function fetch_tour_name($tourid){
	$r=mysql_query("select tour_name from r_tours where tour_id=$tourid");
	$r=mysql_fetch_object($r);
	return $r->tour_name;
}
function fetch_position_name($posid){
	$r=mysql_query("select pos_description from r_tours_positions where position_id=$posid");
	$r=mysql_fetch_object($r);
	return $r->pos_description;
}
function isInjured($plrid){
	$res=mysql_query("select * from r_injuries where user_id=$plrid");
	if (mysql_num_rows($res)==0)
		return false;
	else
		return true;
}
/*function updatePlrBlocks(){
	$res=mysql_query("select rank_user_id as id from r_rankings");
	while ($row=mysql_fetch_object($res)){
		$res2=mysql_query("select numofdeclines from r_numofdeclines where user_id=".$row->id);
		if ($row2=mysql_fetch_object($res2)){
			if ($row2->numofdeclines==3){
				mysql_query("update r_numofdeclines set numofdeclines=0 where user_id=".$row->id);//midenismos twn declines
				$todayDate = date("Y-m-d");
				$onemonthlater = strtotime(date("Y-m-d", strtotime($todayDate)) . "+1 month");
				$onemonthlater=date("Y-m-d", $onemonthlater);
			//	echo $onemonthlater;
				mysql_query("insert into r_user_blocks values (null,$row->id,'$onemonthlater')");
			}
		}
	}
}*/
function givePenalty($user, $deadelinePassPenalty=false){
	$tmpres=mysql_query("select numAGFreeDecl from r_options");
	$tmprow=mysql_fetch_object($tmpres);
	$numofmatchesforfreedecl=$tmprow->numAGFreeDecl;
		
	$r=mysql_query("select * from r_calls where (caller_user_id=$user or callee_user_id=$user) and call_accepted=1 and call_completed=0");
	if (!$deadelinePassPenalty && mysql_num_rows($r)>=$numofmatchesforfreedecl){//den tha dexthei poini
		return;
	}
	
	$res=mysql_query("select numofdeclines from r_numofdeclines where user_id=".$user);
	$res1=mysql_query("select numofpenalties,numofdays from r_options");
	$res1=mysql_fetch_object($res1);
	if (mysql_num_rows($res)>0){
		$res=mysql_fetch_object($res);
		if ($res->numofdeclines==($res1->numofpenalties-1)){//tha dwthei PENALTY 1 MINA
			mysql_query("update r_numofdeclines set numofdeclines=0, bonus_date='0000-00-00' where user_id=".$user);
			$todayDate = date("Y-m-d");
			$onemonthlater = strtotime(date("Y-m-d", strtotime($todayDate)) . "+".$res1->numofdays." days");
			$onemonthlater=date("Y-m-d", $onemonthlater);
			$q="insert into r_user_blocks values ($user,'".$onemonthlater."')";
			mysql_query($q);
		}
		else{
			$thirty_days_later=date("Y-m-d",strtotime("+ 30 days"));
			mysql_query("update r_numofdeclines set numofdeclines=numofdeclines+1, bonus_date='$thirty_days_later' where user_id=".$user);
		}
	}
	else{
		$thirty_days_later=date("Y-m-d",strtotime("+ 30 days"));
		mysql_query("insert into r_numofdeclines values ($user,1,'$thirty_days_later')");
	}
}
function blockingDeamon(){//doulevei mia xara, to thema einai kathe pote tha kaleitai. logika 1 fora ti mera, sto 1o request tis meras kai tha kratietai sti vasi i teleftaia mera pou kalestike k tha sigkrinetai me tin twrini
	$todayDate = date("Y-m-d");
	$res=mysql_query("select * from r_options");
if (mysql_num_rows($res)>0){
		$res=mysql_fetch_object($res);
		if ($res->lastdateofexec>=$todayDate){
			return;
		}
		else{
			mysql_query("update r_options set lastdateofexec='$todayDate'");
		}
	}
	else{
		mysql_query("insert into r_options (lastdateofexec) values ('$todayDate')");
	}
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
	
	/*Give penalty for outdated accept/decline*/
	$res=mysql_query("select * from r_calls where call_accepted = 0");
	while ($row=mysql_fetch_object($res)){
		$answerLatency=0;
		$diff = abs(strtotime($todayDate) - strtotime($row->call_date));
		$answerLatency = floor($diff / (60*60*24));
		
		if ($answerLatency>10){
			//echo $row->call_id." tha FAEI poini o $row->callee_user_id gt argise na apantisei toses meres: ".$answerLatency."<br>";
			givePenalty($row->callee_user_id);
			mysql_query("update r_calls set call_accepted=-1 where call_id =".$row->call_id);
		}
	}
	
	/*Give penalty for outdated calls*/
	$res=mysql_query("select * from r_calls where call_accepted = 1 and call_completed=0");
	while ($row=mysql_fetch_object($res)){
		$dateSubmitLatency=0;
		$scoreSubmitLatency=0;
		if ($row->match_date=='0000-00-00'){
			$diff = abs(strtotime($todayDate) - strtotime($row->call_date));
			$dateSubmitLatency = floor($diff / (60*60*24));
			//echo $row->call_id." diafora: ".$diff."<br>";
		}
		$diff = abs(strtotime($todayDate) - strtotime($row->call_date));
		$scoreSubmitLatency = floor($diff / (60*60*24));
		
		if ($dateSubmitLatency>12 || $scoreSubmitLatency>12){
			//echo $row->call_id." tha fane poini o $row->caller_user_id kai o $row->callee_user_id: ".$dateSubmitLatency." - ".$scoreSubmitLatency."<br>";
			givePenalty($row->caller_user_id);
			givePenalty($row->callee_user_id);
			mysql_query("update r_calls set call_accepted=-1 where call_id =".$row->call_id);
		}
	}
	require_once('../lib/Email/Messages/CallReminderEmail.php');
	require_once('../lib/Email/Messages/InsertCallScoreEmail.php');		
	require_once('../lib/Email/Messages/InsertCallDateEmail.php');
	require_once('../Domain/Access/UserRepository.php');
	$userrep=new UserRepository();
	/*Accept/Decline email reminder*/
	$res=mysql_query("select * from r_calls where call_accepted = 0");
	while ($row=mysql_fetch_object($res)){
		$answerLatency=0;
		$diff = abs(strtotime($todayDate) - strtotime($row->call_date));
		$answerLatency = floor($diff / (60*60*24));
		
		if($answerLatency==10){
			$callee=$userrep->LoadById($row->callee_user_id);
			$caller=$userrep->LoadById($row->caller_user_id);
			include('config.php');
			ServiceLocator::GetEmailService()->Send(new CallReminderEmail($callee,$caller));
		}
	}
	
	/*insert call date email reminder*/
	$res=mysql_query("select * from r_calls where call_accepted=1 and match_date='0000-00-00'");
	while ($row=mysql_fetch_object($res)){
		$answerLatency=0;
		$diff = abs(strtotime($todayDate) - strtotime($row->call_date));
		$answerLatency = floor($diff / (60*60*24));
		
		if($answerLatency==12){
			$callee=$userrep->LoadById($row->callee_user_id);
			$caller=$userrep->LoadById($row->caller_user_id);
			include('config.php');
 			ServiceLocator::GetEmailService()->Send(new InsertCallDateEmail($caller,$callee));
			ServiceLocator::GetEmailService()->Send(new InsertCallDateEmail($callee,$caller));
		}
	}
	
	
	/*insert call score email reminder*/
	$res=mysql_query("select * from r_calls where call_accepted=1 and call_completed=0 and match_date!='0000-00-00'");
	while ($row=mysql_fetch_object($res)){
		$answerLatency=0;
		$diff = abs(strtotime($todayDate) - strtotime($row->call_date));
		$answerLatency = floor($diff / (60*60*24));
		
		if($answerLatency==12){			
			$callee=$userrep->LoadById($row->callee_user_id);
			$caller=$userrep->LoadById($row->caller_user_id);
			include('config.php');
			ServiceLocator::GetEmailService()->Send(new InsertCallScoreEmail($caller,$callee));
			ServiceLocator::GetEmailService()->Send(new InsertCallScoreEmail($callee,$caller));
		}
	}
	
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
		
		/*Update ranking points from calls once a week!*/
		$res=mysql_query("select * from r_tours where counts = 1");
		while ($row=mysql_fetch_object($res)){
			updateRankings_insertCallPoints($row->tour_id);
		}
		
		//update heightest ranking
		$now = date("Y-m-d");
		$week_start=(date('w', strtotime($now)) == 1) ? $now : date("Y-m-d",strtotime('last monday', strtotime($now)));
		$week_start.=" 00:00:00";
		
		/*$week_end=(date('w', strtotime($now)) == 0) ? $now : date("Y-m-d",strtotime('next sunday', strtotime($now)));
		$week_end.=" 23:59:59";*/
		
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
}
?>