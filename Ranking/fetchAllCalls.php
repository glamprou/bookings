<?php
define('ROOT_DIR', '../');
require_once(ROOT_DIR . 'config/config.php');
require_once(ROOT_DIR . 'Ranking/functions.php');
require_once(ROOT_DIR . 'lib/Common/ServiceLocator.php');

$db=ServiceLocator::GetDatabase();
$db->Connection->Connect();
$userSession=ServiceLocator::GetServer()->GetUserSession();

if (isset($_POST['page'])){
	$page=$_POST['page'];
	$validatedValue = filter_input(INPUT_POST, 'page', FILTER_VALIDATE_INT);
	if(!$validatedValue) $page=1;
}
else{
	$page=1;
}

$getDefaultRanking=TRUE;
if(isset($_POST['ranking'])){
    if (ctype_digit($_POST['ranking'])){
        $ranking=pdoq("select * from r_rankings where ranking_id=?",$_POST['ranking']);
        if($ranking){
            $getDefaultRanking=FALSE;
            $curr_ranking_id=$ranking[0]->ranking_id;
        }
    }    
}

if($getDefaultRanking){
    $ranking=pdoq("select * from r_rankings order by ranking_id asc limit 1");  
    if(!$ranking){
        echo "no ranking tables";
        return;
    }
    else{
        $curr_ranking_id=$ranking[0]->ranking_id;
    }
}

$table=pdoq("select ranking_table_name from r_rankings where ranking_id=?",$curr_ranking_id);
$table=$table[0]->ranking_table_name;

if(isset($_POST['plrid'])){
    $plrid=(int)$_POST['plrid'];
}
else{
    $plrid=-1;
}

$callsPerPage=10;
if ($_POST['calltype']=="all"){
	if (isset($plrid) && $plrid!=-1){
		$userid=$plrid;
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where c.caller_user_id=".$userid." or c.callee_user_id=".$userid);
		$numOfCalls=mysql_num_rows($res);
		$numOfPages=(int)($numOfCalls/$callsPerPage);
		if ($numOfCalls % $callsPerPage > 0)
			$numOfPages++;
		if($page>$numOfPages) $page=1;
		$offset = ($page - 1) * $callsPerPage;
		//echo $offset." - ".$callsPerPage;
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where c.caller_user_id=".$userid." or c.callee_user_id=".$userid." order by c.call_id desc limit $offset, $callsPerPage");
	}
	else{
		$res=mysql_query("select call_id from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id");
        $numOfCalls=mysql_num_rows($res);
		$numOfPages=(int)($numOfCalls/$callsPerPage);
		if ($numOfCalls % $callsPerPage > 0)
			$numOfPages++;
		if($page>$numOfPages) $page=1;
		$offset = ($page - 1) * $callsPerPage;
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id order by call_id desc limit $offset, $callsPerPage");
	}
}
else if ($_POST['calltype']=="1"){//all scheduled matches
	if (isset($plrid) && $plrid!="-1"){
		$userid=$plrid;
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where c.call_accepted=1 and c.call_completed=0 and c.match_date IS NOT NULL and ( c.caller_user_id=".$userid." or c.callee_user_id=".$userid.")");
		$numOfCalls=mysql_num_rows($res);
		$numOfPages=(int)($numOfCalls/$callsPerPage);
		if ($numOfCalls % $callsPerPage > 0)
			$numOfPages++;
		if($page>$numOfPages) $page=1;
		$offset = ($page - 1) * $callsPerPage;
		//echo $offset." - ".$callsPerPage;
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where c.call_accepted=1 and c.call_completed=0 and c.match_date IS NOT NULL and ( c.caller_user_id=".$userid." or c.callee_user_id=".$userid." ) order by c.call_id desc limit $offset, $callsPerPage");
	}
	else{
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where c.call_accepted=1 and c.call_completed=0 and c.match_date IS NOT NULL");
		$numOfCalls=mysql_num_rows($res);
		$numOfPages=(int)($numOfCalls/$callsPerPage);
		if ($numOfCalls % $callsPerPage > 0)
			$numOfPages++;
		if($page>$numOfPages) $page=1;
		$offset = ($page - 1) * $callsPerPage;
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where c.call_accepted=1 and c.call_completed=0 and c.match_date IS NOT NULL order by call_id desc limit $offset, $callsPerPage");
	}
}
else if ($_POST['calltype']=="-1"){
	if (isset($plrid) && $plrid!="-1"){
		$userid=$plrid;
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where c.call_accepted=-1 and ( c.caller_user_id=".$userid." or c.callee_user_id=".$userid.")");
		$numOfCalls=mysql_num_rows($res);
		$numOfPages=(int)($numOfCalls/$callsPerPage);
		if ($numOfCalls % $callsPerPage > 0)
			$numOfPages++;
		if($page>$numOfPages) $page=1;
		$offset = ($page - 1) * $callsPerPage;
		//echo $offset." - ".$callsPerPage;
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where c.call_accepted=-1 and ( c.caller_user_id=".$userid." or c.callee_user_id=".$userid." ) order by c.call_id desc limit $offset, $callsPerPage");
	}
	else{
		$res=mysql_query("select call_id from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where call_accepted=-1");
		$numOfCalls=mysql_num_rows($res);
		$numOfPages=(int)($numOfCalls/$callsPerPage);
		if ($numOfCalls % $callsPerPage > 0)
			$numOfPages++;
		if($page>$numOfPages) $page=1;
		$offset = ($page - 1) * $callsPerPage;
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where call_accepted=-1 order by call_id desc limit $offset, $callsPerPage");
	}
}
else if ($_POST['calltype']=="2"){
	if (isset($plrid) && $plrid!="-1"){
		$userid=$plrid;
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where c.call_accepted=1 and c.call_completed=0 and c.match_date IS NULL and ( c.caller_user_id=".$userid." or c.callee_user_id=".$userid.")");
		$numOfCalls=mysql_num_rows($res);
		$numOfPages=(int)($numOfCalls/$callsPerPage);
		if ($numOfCalls % $callsPerPage > 0)
			$numOfPages++;
		if($page>$numOfPages) $page=1;
		$offset = ($page - 1) * $callsPerPage;
		//echo $offset." - ".$callsPerPage;
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where c.call_accepted=1 and c.call_completed=0 and c.match_date IS NULL and ( c.caller_user_id=".$userid." or c.callee_user_id=".$userid." ) order by c.call_id desc limit $offset, $callsPerPage");
	}
	else{
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where c.call_accepted=1 and c.call_completed=0 and c.match_date IS NULL");
		$numOfCalls=mysql_num_rows($res);
		$numOfPages=(int)($numOfCalls/$callsPerPage);
		if ($numOfCalls % $callsPerPage > 0)
			$numOfPages++;
		if($page>$numOfPages) $page=1;
		$offset = ($page - 1) * $callsPerPage;
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where c.call_accepted=1 and c.call_completed=0 and c.match_date IS NULL order by call_id desc limit $offset, $callsPerPage");
	}
}
else if ($_POST['calltype']=="3"){
	if (isset($plrid) && $plrid!="-1"){
		$userid=$plrid;
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where c.call_completed=1 and ( c.caller_user_id=".$userid." or c.callee_user_id=".$userid.")");
		$numOfCalls=mysql_num_rows($res);
		$numOfPages=(int)($numOfCalls/$callsPerPage);
		if ($numOfCalls % $callsPerPage > 0)
			$numOfPages++;
		if($page>$numOfPages) $page=1;
		$offset = ($page - 1) * $callsPerPage;
		//echo $offset." - ".$callsPerPage;
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where c.call_completed=1 and ( c.caller_user_id=".$userid." or c.callee_user_id=".$userid." ) order by c.call_id desc limit $offset, $callsPerPage");
	}
	else{
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where c.call_completed=1");
		$numOfCalls=mysql_num_rows($res);
		$numOfPages=(int)($numOfCalls/$callsPerPage);
		if ($numOfCalls % $callsPerPage > 0)
			$numOfPages++;
		if($page>$numOfPages) $page=1;
		$offset = ($page - 1) * $callsPerPage;
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where c.call_completed=1 order by call_id desc limit $offset, $callsPerPage");
	}
}
else{
	if (isset($plrid) && $plrid!="-1"){
		$userid=$plrid;
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where c.call_accepted=0 and ( c.caller_user_id=".$userid." or c.callee_user_id=".$userid.")");
		$numOfCalls=mysql_num_rows($res);
		$numOfPages=(int)($numOfCalls/$callsPerPage);
		if ($numOfCalls % $callsPerPage > 0)
			$numOfPages++;
		if($page>$numOfPages) $page=1;
		$offset = ($page - 1) * $callsPerPage;
		//echo $offset." - ".$callsPerPage;
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where c.call_accepted=0 and ( c.caller_user_id=".$userid." or c.callee_user_id=".$userid." ) order by c.call_id desc limit $offset, $callsPerPage");
	}
	else{
		$res=mysql_query("select call_id from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where call_accepted=0");
		$numOfCalls=mysql_num_rows($res);
		$numOfPages=(int)($numOfCalls/$callsPerPage);
		if ($numOfCalls % $callsPerPage > 0)
			$numOfPages++;
		if($page>$numOfPages) $page=1;
		$offset = ($page - 1) * $callsPerPage;
		$res=mysql_query("select * from r_calls c inner join $table t1 on c.caller_user_id=t1.rank_user_id where call_accepted=0 order by call_id desc limit $offset, $callsPerPage");
	}
}
?>
<table class="list userList" width="100%" border="0" cellspacing="0" cellpadding="0" style="min-height:265px;">
		<tr>
            <th style="text-align: left;">AceGame</th>
            <th width="50">Set 1</th>
            <th width="50">Set 2</th>
            <th width="50">Super TB</th>
            <th width="50">Points</th>
            <th width="70">Date</th>
            <th width="120">Κατάσταση</th>   
        </tr> 
<?php
	$i=0;
	while ($row=mysql_fetch_object($res)){
		if($row->caller_user_id!=$userid && $row->callee_user_id!=$userid){
?>
		<tr class="row<?= $i%2 ?>">
            <?php
            if($row->match_winner_user_id==$row->caller_user_id && $row->call_completed==1){
                ?>
                <td style="padding:0px; padding-left:4px;" valign="middle" ><div class="aceGameTD"><div class="gamePlr _45"><?= fetch_player_call_rank($row->call_id,$row->caller_user_id,0) ?>.<b><?= fetch_player_name($row->caller_user_id) ?></b></div> <div class="gamePlr _10"><b>called</b></div> <div class="gamePlr _43"><?= fetch_player_call_rank($row->call_id,$row->callee_user_id,1) ?>.<?= fetch_player_name($row->callee_user_id)  ?></div>
                <?php
            }
            else if($row->match_winner_user_id==$row->callee_user_id && $row->call_completed==1){
                ?>
                <td style="padding:0px; padding-left:4px;" valign="middle" ><div class="aceGameTD"><div class="gamePlr _45"><?= fetch_player_call_rank($row->call_id,$row->caller_user_id,0) ?>.<?= fetch_player_name($row->caller_user_id) ?></div> <div class="gamePlr _10"><b>called</b></div> <div class="gamePlr _43"><?= fetch_player_call_rank($row->call_id,$row->callee_user_id,1) ?>.<b><?= fetch_player_name($row->callee_user_id)  ?></b></div>
                <?php
            }
            else{
                ?>
                <td style="padding:0px; padding-left:4px;" valign="middle" ><div class="aceGameTD"><div class="gamePlr _45"><?= fetch_player_call_rank($row->call_id,$row->caller_user_id,0) ?>.<?= fetch_player_name($row->caller_user_id) ?></div> <div class="gamePlr _10"><b>called</b></div> <div class="gamePlr _43"><?= fetch_player_call_rank($row->call_id,$row->callee_user_id,1) ?>.<?= fetch_player_name($row->callee_user_id)  ?></div>
                <?php
            }
            if($userSession->IsAdmin==1){
                if($row->call_completed && $row->toInsert==1){
                ?>
                <span class="btn submitMatchScore tip" edit="edit" id="insertScoreBtn" rel="<?= $row->call_id ?>" style="display:none; margin:0; vertical-align:middle; " ><img title="Επεξεργασία αποτελέσματος"  height="12" src="img/disk-arrow.png" /></span>
                <?php
                }
                else{
                    if($row->call_accepted!=-1){
                        ?>
                        <span class="btn cancelCallByAdmin" style="display:none; color:#FF0000; vertical-align:middle;" value="<?= $row->call_id ?>"><img title="Ακύρωση της πρόσκλησης" height="12" src="img/cross-button.png" /></span> 
                        <?php
                    }
                }
            }
            ?>
            </div></td>
            <td align="center">
	<?php 	if($row->match_set1!=''){ 
				echo $row->match_set1; 
			}
			else{ 
				echo "-"; 
			}
			if($row->match_set1_tb!=''){
				$tbtmp=explode('-',$row->match_set1_tb);
				if ($tbtmp[0]>$tbtmp[1])
					echo "(".$tbtmp[1].")";
				if ($tbtmp[0]<$tbtmp[1])
					echo "(".$tbtmp[0].")";
			}
	?>		</td>
            <td align="center">
	<?php 	if($row->match_set2!=''){ 
				echo $row->match_set2; 
			}
			else{ 
				echo "-"; 
			}
			if($row->match_set2_tb!=''){
				$tbtmp=explode('-',$row->match_set2_tb);
				if ($tbtmp[0]>$tbtmp[1])
					echo "(".$tbtmp[1].")";
				if ($tbtmp[0]<$tbtmp[1])
					echo "(".$tbtmp[0].")";
			}
	?>		</td>
    		<td align="center"><?php if($row->match_stb!='' && $row->match_stb!='0-0') echo $row->match_stb; else echo "-"; ?></td>
            <td align="center">
	<?php 	if($row->match_points_won!=0){ 
				echo $row->match_points_won; 
			}
			else{
			 	echo fetch_points_by_callid($row->caller_user_id,$row->callee_user_id,$row->caller_user_id,$row->call_id)." or ".fetch_points_by_callid($row->caller_user_id,$row->callee_user_id,$row->callee_user_id,$row->call_id); 
			}
			?></td>   
            <td align="center"><?php 
			if($row->match_date!=NULL){ ?>
				<span style="color:#000000"><?= changeDate($row->match_date) ?></span>
<?php		}
			else{ ?> 
				<span style="color:#FF0000"><?= changeDate($row->call_date) ?></span>			 
<?php		}	
			?></td>
               
            <td align="center"><?php  
				if ($row->call_accepted==0){
					echo "Εκκρεμεί";
				}
				else if ($row->call_accepted==-1){
					echo "Ακυρωμένο";
				}
				else {
					if($row->call_completed==0){//den exei paixtei akoma
						if(!$row->match_date){//den exei kanonistei
							echo "Δεν έχει οριστεί";
						}
						else{//exei kanonistei
							echo 'Προγραμματισμένο';//changeDate($row->match_date);
						}
					}
					else{//teleiwse to match
						echo "Ολοκληρωμένο";
					}
				}
		 ?></td>
   		</tr> 
<?php
		$i++;
		}
		else{
?>
		<tr class="row<?= $i%2 ?>">
            <?php
            if($row->match_winner_user_id==$row->caller_user_id && $row->call_completed==1){
                ?>
                <td style="padding:0px; padding-left:4px;" valign="middle" ><div class="aceGameTD"><div class="gamePlr _45"><?= fetch_player_call_rank($row->call_id,$row->caller_user_id,0) ?>.<b><?= fetch_player_name($row->caller_user_id) ?></b></div> <div class="gamePlr _10"><b>called</b></div> <div class="gamePlr _43"><?= fetch_player_call_rank($row->call_id,$row->callee_user_id,1) ?>.<?= fetch_player_name($row->callee_user_id)  ?></div>
                <?php
            }
            else if($row->match_winner_user_id==$row->callee_user_id && $row->call_completed==1){
                ?>
                <td style="padding:0px; padding-left:4px;" valign="middle" ><div class="aceGameTD"><div class="gamePlr _45"><?= fetch_player_call_rank($row->call_id,$row->caller_user_id,0) ?>.<?= fetch_player_name($row->caller_user_id) ?></div> <div class="gamePlr _10"><strong>called</strong></div> <div class="gamePlr _43"><?= fetch_player_call_rank($row->call_id,$row->callee_user_id,1) ?>.<b><?= fetch_player_name($row->callee_user_id)  ?></b></div>
                <?php
            }
            else{
                ?>
                <td style="padding:0px; padding-left:4px;" valign="middle" ><div class="aceGameTD"><div class="gamePlr _45"><?= fetch_player_call_rank($row->call_id,$row->caller_user_id,0) ?>.<?= fetch_player_name($row->caller_user_id) ?></div> <div class="gamePlr _10"><strong>called</strong></div> <div class="gamePlr _43"><?= fetch_player_call_rank($row->call_id,$row->callee_user_id,1) ?>.<?= fetch_player_name($row->callee_user_id)  ?></div>
                <?php
            }
                if($userSession->IsAdmin==1){
					if($row->call_completed && $row->toInsert==1){
					
					?>
					<span class="btn submitMatchScore tip" edit="edit" id="insertScoreBtn" rel="<?= $row->call_id ?>" style="display:none; margin:0; vertical-align:middle; " ><img title="Επεξεργασία αποτελέσματος"  height="12" src="img/disk-arrow.png" /></span>
					<?php
					}
					else{
						if($row->call_accepted!=-1){
							?>
							<span class="btn cancelCallByAdmin" style="display:none; color:#FF0000; vertical-align:middle;" value="<?= $row->call_id ?>"><img title="Ακύρωση της πρόσκλησης" height="12" src="img/cross-button.png" /></span> 
							<?php
						}
					}
                }
                ?>
            </div></td>
            <td align="center" class="set1field" value="<?= $row->call_id ?>">
	<?php 	if($row->match_set1!=''){ 
				echo $row->match_set1; 
			}
			else{ 
				echo "-"; 
			}
			if($row->match_set1_tb!=''){
				$tbtmp=explode('-',$row->match_set1_tb);
				if ($tbtmp[0]>$tbtmp[1])
					echo "(".$tbtmp[1].")";
				if ($tbtmp[0]<$tbtmp[1])
					echo "(".$tbtmp[0].")";
			}
	?>		</td>
            <td align="center" class="set2field" value="<?= $row->call_id ?>">
	<?php 	if($row->match_set2!=''){ 
				echo $row->match_set2; 
			}
			else{ 
				echo "-"; 
			}
			if($row->match_set2_tb!=''){
				$tbtmp=explode('-',$row->match_set2_tb);
				if ($tbtmp[0]>$tbtmp[1])
					echo "(".$tbtmp[1].")";
				if ($tbtmp[0]<$tbtmp[1])
					echo "(".$tbtmp[0].")";
			}
	?>		</td>
    		<td align="center" class="stbfield" value="<?= $row->call_id ?>"><?php if($row->match_stb!='' && $row->match_stb!='0-0') echo $row->match_stb; else echo "-"; ?></td>
            <td align="center">
	<?php 	if($row->match_points_won!=0){ 
				echo $row->match_points_won; 
			}
			else{
			 	echo fetch_points_by_callid($row->caller_user_id,$row->callee_user_id,$row->caller_user_id,$row->call_id)." or ".fetch_points_by_callid($row->caller_user_id,$row->callee_user_id,$row->callee_user_id,$row->call_id); 
			}
			?></td>   
            <td align="center"><?php 
			if($row->match_date!=NULL){ ?>
				<span style="color:#000000"><?= changeDate($row->match_date) ?></span>
<?php		}
			else{ ?> 
				<span style="color:#FF0000"><?= changeDate($row->call_date) ?></span>			 
<?php		}	
			?></td>
               
            <td align="center"><?php  
				if ($row->call_accepted==0){
					echo "Εκκρεμεί";
				}
				else if ($row->call_accepted==-1){
					echo "Ακυρωμένο";
				}
				else {
					if($row->call_completed==0){//den exei paixtei akoma
						if($row->match_date==NULL){//den exei kanonistei
							echo "Δεν έχει οριστεί";
						}
						else{//exei kanonistei
							echo "Προγραμματισμένο";
						}
					}
					else{//teleiwse to match
						echo "Ολοκληρωμένο";
					}
				}
		 ?></td>
   		</tr> 

<?php		
		$i++;
		}
		
	}
	
	if ($i==0)
                echo "<tr class='row1'><td colspan='7'>Δεν υπάρχουν προσκλήσεις</td></tr>";
  
  if(1<=$numOfPages){
		$first='<a href="javascript: void(0);" class="pagingBtn" page="1">First</a>';
		$prev='<a href="javascript: void(0);" class="pagingBtn" page="'.($page-1).'">Prev</a>';
		if($page==1){
			$first='<span style="color:#CCCCCC; ">First</a>';
			$prev='<span style="color:#CCCCCC; ">Prev</a>';
		}		
		$next='<a href="javascript: void(0);" class="pagingBtn" page="'.($page+1).'">Next</a>';
		$last='<a href="javascript: void(0);" class="pagingBtn" page="'.$numOfPages.'">Last</a>';
		if($page==$numOfPages){
			$next='<span style="color:#CCCCCC; ">Next</a>';
			$last='<span style="color:#CCCCCC; ">Last</a>';
		}	
?>

  <tr>
    <td id="allCallsPaging" align="center" colspan="11">
      <table cellpadding="0" cellspacing="0" border="0" width="370">
        <tr>
          <td align="right"><?php echo $first; ?></td>
          <td align="right"><?php echo $prev; ?></td>
          <td align="center"><strong>Page <?php echo $page." / ".$numOfPages; ?></strong></td>
          <td align="left"><?php echo $next; ?></td>
          <td align="left"><?php echo $last; ?></td>
          <td>|</td>
          <td align="right">go to</td>
          <td width="20"><input type="text" value="" id="specificpage" style="width:20px;"></td>
          <td align="left"><input type="image" id="gotospecificpage" src="img/upcoming-work.png" style="width:20px; vertical-align:middle" value="" /></td>
        </tr>
  		</table>    
  	</td>
  </tr>
  <?php
  }
  ?>
</table>
<style type="text/css">
	#allCallsPaging table td{
		border:none;
	}
	#allCallsPaging table td a{
		text-decoration:underline;
		
	}
	#allCallsPaging table td a:hover{
		text-decoration:none;
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$('#specificpage').keyup(function(event){
		if (event.which == 13 || event.keyCode == 13) {
			$('#allCallsOuter').load("../Ranking/fetchAllCalls.php",{
				page: $('#specificpage').val(),
                ranking: <?php echo $curr_ranking_id ?>
				<?php 
				if (isset($plrid) && $plrid!="-1")
					echo ", plrid: \"".$plrid."\"";
				if (isset($_POST['calltype']))
					echo ", calltype: \"".$_POST['calltype']."\"";
	?>	});
		}
	});
	$('#gotospecificpage').click(function(){
		$('#allCallsOuter').load("../Ranking/fetchAllCalls.php",{
			page: $('#specificpage').val(),
            ranking: <?php echo $curr_ranking_id ?>
			<?php 
			if (isset($plrid) && $plrid!="-1")
				echo ", plrid: \"".$plrid."\"";
			if (isset($_POST['calltype']))
				echo ", calltype: \"".$_POST['calltype']."\"";
	?>	});
	});

	$('.pagingBtn').click(function(){
		$('#allCallsOuter').load("../Ranking/fetchAllCalls.php",{
			page: $(this).attr('page'),
            ranking: <?php echo $curr_ranking_id ?>
			<?php 
			if (isset($plrid) && $plrid!="-1")
				echo ", plrid: \"".$plrid."\"";
			if (isset($_POST['calltype']))
				echo ", calltype: \"".$_POST['calltype']."\"";

	?>	});
	});
	$('.aceGameTD').mouseover(function(){
		$(this).children('span').css('display','inline-block');
	});
	$('.aceGameTD').mouseout(function(){
		$(this).children('span').css('display','none');
	});
	$('.cancelCallByAdmin').click(function(){
		var con = confirm('Πρόκειται να ακυρώσετε την συγκεκριμένη πρόσκληση απο τη βάση. Είστε σίγουρος;');
		if (!con) return false;
		$.ajax({
		  type: "POST",
		  url: "../Ranking/ajax.php",
		  data: { action: "cancelCall", callid: $(this).attr('value')}
		}).done(function( msg ) {
			var old_url=window.location.href;
			var new_url = old_url.substring(0, old_url.indexOf('&'));
			if (new_url=='')
				new_url=old_url;
			window.location.href=new_url;
		});
		return false;
	});
	$('.submitMatchScore[edit="edit"]').off().each(function(){
        $(this).qtip({

            position: {
                my: 'bottom left',
                at: 'top left',
                target: $(this),
                effect: false
            },
            content: {
                text: 'Loading...',
                ajax: {
                    url: "../Ranking/updateScoreFields.php",
                    type: 'GET',
                    data: { call: $(this).attr('rel') },
                    dataType: 'html'
                }
            },
            show: {
                event: 'click'
            },
            hide: {
                event: null,
                fixed: true
            },
            events: {
                show: function() {
                    var trigger=$(this);
                    // Tell the tip itself to not bubble up clicks on it
                    $($(this).qtip('api').elements.tooltip).click(function() {
                        /*$('#retiredCheckbox').change(function(){
                         if ($(this).attr('checked')!=undefined && $(this).attr('checked')=='checked'){
                         $(this).removeAttr('checked');
                         }
                         else{
                         $(this).attr('checked')=='checked';
                         }
                         });*/
                        //	$('#retiredCheckbox').$(this).attr('checked','checked');
                        return false;
                    });
                    // Tell the document itself when clicked to hide the tip and then unbind
                    // the click event (the .one() method does the auto-unbinding after one time)
                    $(document).one("click", function() { trigger.qtip('hide'); });
                }
            }

        });
    });
});
</script>
<?php
$db->Connection->Disconnect();
?>