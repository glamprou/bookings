<?php 
define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'lib/Common/ServiceLocator.php');
require_once(ROOT_DIR . 'Ranking/functions.php');

$db=ServiceLocator::GetDatabase();
$db->Connection->Connect(); 

$userSession = ServiceLocator::GetServer()->GetUserSession();
$current_userid=$userSession->UserId;

$userid=filter_var($_GET['userid'] , FILTER_VALIDATE_INT);
if(!$userid){
	return "";
}

$res=mysql_query("select user_profile_img from user_profile_info where user_id=$userid");
if($row=mysql_fetch_object($res)){
	$img_src=$row->user_profile_img;
}
else{
	$img_src='uploads/profile_images/default_image.png';
}

$res=mysql_query("select heightest_rank from player_rank_details where user_id=$userid");
if($row=mysql_fetch_object($res)){
	$heightest_rank=$row->heightest_rank;
}
else{
	$heightest_rank="";
}

$res=mysql_query("select * from week_positions where user_id=$userid and position=1");
$weeks_at_no1=mysql_num_rows($res);

$tours=array();
$res=mysql_query("select rt.tour_name,pos.pos_description,pos.pos_points from r_tours_participants tp inner join r_tours rt on tp.tour_id=rt.tour_id inner join r_tours_positions pos on tp.position_id=pos.position_id where tp.user_id=$userid and tp.countedToRank=1");
while($row=mysql_fetch_object($res)){
	$tours[]=array($row->tour_name => $row->pos_description.'-'.$row->pos_points.' pts');
}

$res=mysql_query("select * from r_tours_participants where user_id=$userid and position_id=1");
$titles=mysql_num_rows($res);

$res=mysql_query("select * from r_tours_participants where user_id=$userid and (position_id=1 or position_id=2)");
$finals=mysql_num_rows($res);

$res=mysql_query("select * from custom_attribute_values where custom_attribute_id=2 and entity_id=$userid");
if($row=mysql_fetch_object($res)){
	$handed=$row->attribute_value;
}
else{
	$handed="";
}

$res=mysql_query("select * from custom_attribute_values where custom_attribute_id=3 and entity_id=$userid");
if($row=mysql_fetch_object($res)){
	$twohandedbackhand=$row->attribute_value;
}
else{
	$twohandedbackhand="";
}

$numofdeclines='';
if($current_userid==$userid){
	$res=mysql_query("select * from r_numofdeclines where user_id=$userid");
	if($row=mysql_fetch_object($res)){
		$numofdeclines=$row->numofdeclines;
		if($row->bonus_date!='0000-00-00'){
			$days_to_bonus=ceil((strtotime($row->bonus_date)-strtotime('now'))/(60*60*24));
			if($days_to_bonus==1){
				$days_to_bonus_text='Ο αριθμός των ποινών σας θα μειωθεί κατά μία αύριο';
			}
			else if($days_to_bonus==2){
				$days_to_bonus_text='Ο αριθμός των ποινών σας θα μειωθεί κατά μία μεθαύριο';
			}
			else{
				$days_to_bonus_text="Ο αριθμός των ποινών σας θα μειωθεί κατά μία σε $days_to_bonus ημέρες";
			}
		}
		else{
			$days_to_bonus=false;
		}
	}
	else{
		$numofdeclines=0;$days_to_bonus_text=''; 
	}
}else{
	$res=mysql_query("select * from r_numofdeclines where user_id=$userid");
	if($row=mysql_fetch_object($res)){
		$numofdeclines=$row->numofdeclines;
		if($row->bonus_date!='0000-00-00'){
			$days_to_bonus=ceil((strtotime($row->bonus_date)-strtotime('now'))/(60*60*24));
			if($days_to_bonus==1){
				$days_to_bonus_text='Ο αριθμός των ποινών θα μειωθεί κατά μία αύριο';
			}
			else if($days_to_bonus==2){
				$days_to_bonus_text='Ο αριθμός των ποινών θα μειωθεί κατά μία μεθαύριο';
			}
			else{
				$days_to_bonus_text="Ο αριθμός των ποινών θα μειωθεί κατά μία σε $days_to_bonus ημέρες";
			}
		}
		else{
			$days_to_bonus=false;
		}
	}
	else{
		$numofdeclines=0;$days_to_bonus_text=''; 
	}
}

//points to defend
//if($current_userid==$userid){
	$showPointsToDefend=true;
	$data=array();
	
	$res=mysql_query("select sum(match_points_won) as total_points from r_calls where yearweek = '".date('oW',strtotime('-1 year +1 day'))."' and match_winner_user_id=$userid");
	$data['Week0'][0]="W".date('W',strtotime('-1 year +1 day'));
	$week_start= date('N',strtotime('-1 year +1 day'))==1 ? date('d-m-Y',strtotime('-1 year')) : date('d-m-Y',strtotime('last monday',strtotime('-1 year')));
	$week_end=   date('N',strtotime('-1 year +1 day'))==7 ? date('d-m-Y',strtotime('-1 year')) : date('d-m-Y',strtotime('next sunday',strtotime('-1 year')));
	if($row=mysql_fetch_object($res)){
		$data['Week0'][1] = empty($row->total_points) ? '0 pts' : $row->total_points." pts";
	}
	$data['Week0'][2]=$week_start.' - '.$week_end;
	$data['Week0'][3]=date('d-m-Y',strtotime('next monday'));
	
	$res=mysql_query("select sum(match_points_won) as total_points from r_calls where yearweek = '".date('oW',strtotime('-1 year +1 week +1 day'))."' and match_winner_user_id=$userid");
	$data['Week1'][0]="W".date('W',strtotime('-1 year +1 week  +1 day'));
	$week_start= date('N',strtotime('-1 year +1 week +1 day'))==1 ? date('d-m-Y',strtotime('-1 year +1 week')) : date('d-m-Y',strtotime('last monday',strtotime('-1 year +1 week')));
	$week_end=   date('N',strtotime('-1 year +1 week +1 day'))==7 ? date('d-m-Y',strtotime('-1 year +1 week')) : date('d-m-Y',strtotime('next sunday',strtotime('-1 year +1 week')));
	if($row=mysql_fetch_object($res)){
		$data['Week1'][1] = empty($row->total_points) ? '0 pts' : $row->total_points." pts";
	}
	$data['Week1'][2]=$week_start.' - '.$week_end;
	$data['Week1'][3]=date('d-m-Y',strtotime('next monday',strtotime('+1 weeks')));
	
	$res=mysql_query("select sum(match_points_won) as total_points from r_calls where yearweek = '".date('oW',strtotime('-1 year +2 week +1 day'))."' and match_winner_user_id=$userid");
	$data['Week2'][0]="W".date('W',strtotime('-1 year +2 weeks +1 day'));
	$week_start= date('N',strtotime('-1 year +2 week +1 day'))==1 ? date('d-m-Y',strtotime('-1 year +2 week')) : date('d-m-Y',strtotime('last monday',strtotime('-1 year +2 week')));
	$week_end=   date('N',strtotime('-1 year +2 week +1 day'))==7 ? date('d-m-Y',strtotime('-1 year +2 week')) : date('d-m-Y',strtotime('next sunday',strtotime('-1 year +2 week')));
	if($row=mysql_fetch_object($res)){
		$data['Week2'][1] = empty($row->total_points) ? '0 pts' : $row->total_points." pts";
	}
	$data['Week2'][2]=$week_start.' - '.$week_end;
	$data['Week2'][3]=date('d-m-Y',strtotime('next monday',strtotime('+2 weeks')));
	
	$res=mysql_query("select sum(match_points_won) as total_points from r_calls where yearweek = '".date('oW',strtotime('-1 year +3 week +1 day'))."' and match_winner_user_id=$userid");
	$data['Week3'][0]="W".date('W',strtotime('-1 year +3 weeks +1 day'));
	$week_start= date('N',strtotime('-1 year +3 week +1 day'))==1 ? date('d-m-Y',strtotime('-1 year +3 week')) : date('d-m-Y',strtotime('last monday',strtotime('-1 year +3 week')));
	$week_end=   date('N',strtotime('-1 year +3 week +1 day'))==7 ? date('d-m-Y',strtotime('-1 year +3 week')) : date('d-m-Y',strtotime('next sunday',strtotime('-1 year +3 week')));
	if($row=mysql_fetch_object($res)){
		$data['Week3'][1] = empty($row->total_points) ? '0 pts' : $row->total_points." pts";
	}
	$data['Week3'][2]=$week_start.' - '.$week_end;
	$data['Week3'][3]=date('d-m-Y',strtotime('next monday',strtotime('+3 weeks')));
//}
//else{
//	$showPointsToDefend=false;
//}
$res1=mysql_query("select sum(call_completed) from r_calls where ((caller_user_id=$userid and callee_user_id=$current_userid) or (callee_user_id=$userid and caller_user_id=$current_userid)) and call_completed=1 and match_winner_user_id=$userid order by match_date desc");
$res2=mysql_query("select sum(call_completed) from r_calls where ((caller_user_id=$userid and callee_user_id=$current_userid) or (callee_user_id=$userid and caller_user_id=$current_userid)) and call_completed=1 and match_winner_user_id=$current_userid order by match_date desc");
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Player Profile</title>
</head>
<body>
	<div style="margin-bottom:10px; font-weight:bold;"><?php echo fetch_player_name($userid); ?></div>
  <div style="width:300px;">
  	<img width="100" style="padding-left:10px; padding-bottom:10px;" src="<?php echo $img_src; ?>" align="right" />
    <b>Χαρακτηριστικά παίκτη:</b><br>
  	<?php
		if($handed!=''){
			echo $handed."<br>";
		}
		if($twohandedbackhand!=''){
			echo $twohandedbackhand."<br><br>";
		}
		echo "<b>Επιδόσεις παίκτη.:</b><br>";
		?>
		<table border="0" cellspacing="0" cellpadding="0">
		<?php
    if($heightest_rank!=''){
		?>
    	<tr>
    		<td width="130">Career Heightest Rank:</td><td><?php echo $heightest_rank; ?></td>
      </tr>
    <?php
		}
		?>
    	<tr>
    		<td width="130">Weeks at No1:</td><td><?php echo $weeks_at_no1; ?></td>
      </tr>
      <tr>
    		<td>Τίτλοι/Τελικοί:</td><td><?php echo $titles; ?>/<?php echo $finals; ?></td>
      </tr>
    </table>
    <br>
    <?php
		$first=true;
    foreach($tours as $tour){
      if($first){
				$first=false;
				?>
        <b>Συμμετοχές σε τουρνουά:</b><br>
		    <ul style="list-style-type:none;">
				<?php
			}
			foreach($tour as $tourname => $tourpos){
        echo "<li style='padding-left:5px;'>&bull; ".$tourname." <b>(".$tourpos.")</b></li>";
      }
    }
		if(!$first) echo "</ul><br>";

		if(true){
		?>
    <table border="0" cellspacing="0" cellpadding="0" width="100%"><tr><td width="130">
    <?php
    if(strcmp($numofdeclines,'')!=0){
		?>
		<b>Αριθμός ποινών:</b></td><td><?php echo $numofdeclines; ?></td></tr></table>
    <?php
		}
		if($days_to_bonus>0) echo $days_to_bonus_text."<br>";
		}
		if($userid!=$current_userid){
			$row1=mysql_fetch_array($res1); //$userid
			$row2=mysql_fetch_array($res2); //$current_userid
			$won1 = empty ($row1['sum(call_completed)']) ? '0' : $row1['sum(call_completed)'];
			$won2 = empty ($row2['sum(call_completed)']) ? '0' : $row2['sum(call_completed)'];
			echo "<br><b>Προϊστορία:</b><br>";
			echo fetch_player_name($userid)."&nbsp;<b>(".$won1."-".$won2.")</b>&nbsp;".fetch_player_name($current_userid)."<br>";
		}
//          $i=1;
//          while ($row=mysql_fetch_object($res)){ 
//						if($i==1) echo "<b>Προϊστορία:</b><br>";
//						echo changeDate($row->match_date)."<br>";
//						if($row->match_winner_user_id==$row->caller_user_id){
//							echo '<b>'.fetch_player_name($row->caller_user_id)."</b>&nbsp;vs&nbsp;".fetch_player_name($row->callee_user_id);
//						}
//						else{
//							echo fetch_player_name($row->caller_user_id)."&nbsp;vs&nbsp;<b>".fetch_player_name($row->callee_user_id).'</b>';
//						}
//						echo ' (';
//						if($row->match_set1!='0-0') echo $row->match_set1;
//						if($row->match_set1_tb!='0-0'){ 
//							$tmp=explode('-',$row->match_set1_tb);
//							if($tmp[0]>$tmp[1])
//								echo '('.$tmp[1].')';
//							else	
//								echo '('.$tmp[0].')';
//						}
//						if($row->match_set2!='0-0') echo ','.$row->match_set2;
//						if($row->match_set2_tb!='0-0'){
//							$tmp=explode('-',$row->match_set2_tb);
//							if($tmp[0]>$tmp[1])
//								echo '('.$tmp[1].')';
//							else	
//								echo '('.$tmp[0].')';
//						}
//						if($row->match_stb!='0-0') echo ','.$row->match_stb;
//						echo ')';
//						if($row->retired==1) echo "(Ret)";
//						$i=0;
//          	echo "<br>";
//					}
//			}
			?>
    <?php
	if($showPointsToDefend){
	?>
  	<br>
    <b>Πόντοι προς υπεράσπιση ανά εβδομάδα:</b>
    <table  border="0" cellspacing="0" cellpadding="0" id="pointsToDefendTable">
      <tr>
      	<td colspan="5" height="5"></td>
      </tr>
      <tr>
      	<th>Εβδ.</th>
        <th width="10">&nbsp;</th>
        <th>Ημερομηνίες</th>
        <th width="10">&nbsp;</th>
        <th align="right">Πόντοι</th>
        <th width="10">&nbsp;</th>
        <th>Drop Date</th>
      </tr>
      <tr>
      	<td colspan="5" height="3"></td>
      </tr>
      <tr>
        <td><?php echo $data['Week0'][0] ?></td>
        <td width="10">&nbsp;</td>
        <td><?php echo $data['Week0'][2] ?></td>
        <td width="10">&nbsp;</td>
        <td align="right"><b><?php echo $data['Week0'][1] ?></b></td>
        <td width="10">&nbsp;</td>
        <td><?php echo $data['Week0'][3] ?></td>
      </tr>
      <tr>
        <td><?php echo $data['Week1'][0] ?></td>
        <td width="10">&nbsp;</td>
        <td><?php echo $data['Week1'][2] ?></td>
        <td width="10">&nbsp;</td>
        <td align="right"><b><?php echo $data['Week1'][1] ?></b></td>
        <td width="10">&nbsp;</td>
        <td><?php echo $data['Week1'][3] ?></td>
      </tr>
      <tr>
        <td><?php echo $data['Week2'][0] ?></td>
        <td width="10">&nbsp;</td>
        <td><?php echo $data['Week2'][2] ?></td>
        <td width="10">&nbsp;</td>
        <td align="right"><b><?php echo $data['Week2'][1] ?></b></td>
        <td width="10">&nbsp;</td>
        <td><?php echo $data['Week2'][3] ?></td>
      </tr>
      <tr>
        <td><?php echo $data['Week3'][0] ?></td>
        <td width="10">&nbsp;</td>
        <td><?php echo $data['Week3'][2] ?></td>
        <td width="10">&nbsp;</td>
        <td align="right"><b><?php echo $data['Week3'][1] ?></b></td>
        <td width="10">&nbsp;</td>
        <td><?php echo $data['Week3'][3] ?></td>
      </tr>
    </table>
    <?php
	}
	?>
  </div>
</body>
</html>
<?php
$db->Connection->Disconnect();
?>