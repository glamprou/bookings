<?php
define('ROOT_DIR', '../');
require_once(ROOT_DIR . 'config/config.php');
require_once(ROOT_DIR . 'Ranking/functions.php');
require_once(ROOT_DIR . 'lib/Common/ServiceLocator.php');

$db=ServiceLocator::GetDatabase();
$db->Connection->Connect();
	

function validateScoreInput($score,$ret){
	//set1 validation
	$ok1=0;
	if ($score[0]==6 || $score[1]==6 ) {
		if ($score[0]+$score[1]<=10){
			$ok1=1;
		}
		else if($score[0]+$score[1]==13){
			$ok1=1;
		}
	}
	else if($score[0]==7 ){
		if ($score[1]==5){
			$ok1=1;
		}
	}
	else if($score[1]==7 ){
		if ($score[0]==5){
			$ok1=1;
		}
	}
	
	//set1tb validation
	$ok2=0;
	if (($score[2]==7 && $score[3]<7) || ($score[3]==7 && $score[2]<7)) {
		if ($score[2]+$score[3]<=12){
			$ok2=1;
		}
	}
	else if($score[2]>7 || $score[3]>7){
		if ($score[2]==$score[3]+2 || $score[3]==$score[2]+2){
			$ok2=1;
		}
	}
	else if($score[2]==0 && $score[3]==0){
		$ok2=1;
	}
	
	//set2 validation
	$ok3=0;
	if ($score[4]==6 || $score[5]==6 ) {
		if ($score[4]+$score[5]<=10){
			$ok3=1;
		}
		else if($score[4]+$score[5]==13){
			$ok3=1;
		}
	}
	else if($score[4]==7 ){
		if ($score[5]==5){
			$ok3=1;
		}
	}
	else if($score[5]==7 ){
		if ($score[4]==5){
			$ok3=1;
		}
	}
	
	//set2tb validation
	$ok4=0;
	if (($score[6]==7 && $score[7]<7) || ($score[7]==7 && $score[6]<7)) {
		if ($score[6]+$score[7]<=12){
			$ok4=1;
		}
	}
	else if($score[6]>7 || $score[7]>7){
		if ($score[6]==$score[7]+2 || $score[7]==$score[6]+2){
			$ok4=1;
		}
	}
	else if($score[6]==0 && $score[7]==0){
		$ok4=1;
	}
	
	//stb validation
	$ok5=0;
	if (($score[8]==10 && $score[9]<10)||( $score[9]==10 && $score[8]<10)) {
		if ($score[8]+$score[9]<=18){
			$ok5=1;
		}
	}
	else if($score[8]>10 || $score[9]>10){
		if ($score[8]==$score[9]+2 || $score[9]==$score[8]+2){
			$ok5=1;
		}
	}
	else if($score[8]==0 && $score[9]==0){
		$ok5=1;
	}
	
	
	
	$ok=1;
	//tie break existance
	if ((($score[0]>$score[1] && $score[4]<$score[5]) || ($score[0]<$score[1] && $score[4]>$score[5])) && ($score[8]==0 && $score[9]==0)){
		$ok=0;
	}
	else if((($score[0]>$score[1] && $score[4]>$score[5]) || ($score[0]<$score[1] && $score[4]<$score[5])) && ($score[8]!=0 || $score[9]!=0)){
		$ok=0;
	}
	else if(($score[0]+$score[1]==13) && ($score[2]==0 && $score[3]==0) ){
		$ok=0;
	}
	else if( ($score[4]+$score[5]==13) && ($score[6]==0 && $score[7]==0) ){
		$ok=0;
	}
	
	//tie break correctness
	if($score[0]+$score[1]==13){
		if ($score[0]>$score[1]){
			if ($score[2]<$score[3]){
				$ok=0;
			}
		}
		else{
			if ($score[2]>$score[3]){
				$ok=0;
			}
		}
	}
	if($score[4]+$score[5]==13){
		if ($score[4]>$score[5]){
			if ($score[6]<$score[7]){
				$ok=0;
			}
		}
		else{
			if ($score[6]>$score[7]){
				$ok=0;
			}
		}
	}
	if( ($score[0]>$score[1] && $score[4]<$score[5]) || ($score[0]<$score[1] && $score[4]>$score[5]) ){
		if ($score[8]==0 && $score[9]==0){
				$ok=0;
		}
	}

	if ($ret){
		if ($ok5==1 && ($score[8]!=0 || $score[9]!=0)){
			//echo "kai retired kai ok to mats???";
			return 0;
		}
		else if($ok3==1 && $ok4==1){
			if ($ok1==1 && $ok2==1){
				//echo "travmatistike sto stb";
				return 1;
			}
			else{
				//echo 'lathos 1o set, swsto 2o??/';
				return 0;
			}
		}
		else if($ok1==1 && $ok2==1){
			//echo "travmatistike sto 2o set";
			return 1;
		}
		else{
			//echo "travmatistike sto 1o";
			return 1;
		}
	}

	
	if ( $ok==1 && $ok1==1 && $ok2==1 && $ok3==1 && $ok4==1 && $ok5==1 )
		return 1;
	else
		return 0;
}

if (isset($_POST['submit'])){
	$score=explode('-',$_POST['score']);
	$ret=$_POST['retplrid'];
	//echo $ret; return;
	if ($ret==-1){
		$ret=0;
	}
	else{
		$ret=1;
	}
	$passed=validateScoreInput($score,$ret);
	if (!$passed){
		echo "Parakalw eisagete swsta to score";
		exit();
	}
	else{
		if ($_POST['retplrid']==-1){
			mysql_query("update r_calls set call_completed=1, match_set1='".$score[0]."-".$score[1]."', match_set1_tb='".$score[2]."-".$score[3]."',  match_set2='".$score[4]."-".$score[5]."',  match_set2_tb='".$score[6]."-".$score[7]."',  match_stb='".$score[8]."-".$score[9]."' where call_id=".$_POST['callid']);
			$winnerid=fetch_winner_id_points($_POST['callid'],NULL);
			mysql_query("update r_calls set match_winner_user_id=".$winnerid[0].", match_points_won=".$winnerid[1]." where call_id=".$_POST['callid']);
		}
		else{//iparxei retired paiktis
			//$res=mysql_query("select caller_user_id,callee_user_id from r_users where call_id=".$_POST['callid']);
			mysql_query("update r_calls set retired=1, call_completed=1, match_set1='".$score[0]."-".$score[1]."', match_set1_tb='".$score[2]."-".$score[3]."',  match_set2='".$score[4]."-".$score[5]."',  match_set2_tb='".$score[6]."-".$score[7]."',  match_stb='".$score[8]."-".$score[9]."' where call_id=".$_POST['callid']);
			$winnerid=fetch_winner_id_points($_POST['callid'],$_POST['retplrid']);
			mysql_query("update r_calls set match_winner_user_id=".$winnerid[0].", match_points_won=".$winnerid[1]." where call_id=".$_POST['callid']);
		}
		
		mysql_query("update r_calls set yearweek=YEARWEEK(match_date,1), toInsert=1 where call_id=".$_POST['callid']);
		
		$res=mysql_query("select * from r_calls where call_id=".$_POST['callid']);
		$row=mysql_fetch_object($res);
		
		$userSession = ServiceLocator::GetServer()->GetUserSession();	
		$userid=$userSession->UserId;
		if($row->caller_user_id==$userid){
			sms($row->call_id,$row->callee_user_id,4);
		}
		else{
			sms($row->call_id,$row->caller_user_id,4);
		}	
		
		echo 1;
		exit();
	}
}
if (isset($_POST['submitedit'])){
	$score=explode('-',$_POST['score']);
	$ret=$_POST['retplrid'];
	//echo $ret; return;
	if ($ret==-1){
		$ret=0;
	}
	else{
		$ret=1;
	}
	$passed=validateScoreInput($score,$ret);
	if (!$passed){
		echo "Parakalw eisagete swsta to score";
		exit();
	}
	else{
		if ($_POST['retplrid']==-1){
			mysql_query("update r_calls set call_completed=1, match_set1='".$score[0]."-".$score[1]."', match_set1_tb='".$score[2]."-".$score[3]."',  match_set2='".$score[4]."-".$score[5]."',  match_set2_tb='".$score[6]."-".$score[7]."',  match_stb='".$score[8]."-".$score[9]."' where call_id=".$_POST['callid']);
			$res=mysql_query("select * from r_calls where call_id=".$_POST['callid']);
			$row=mysql_fetch_object($res);
			$flag=0;
			if($row->countedToRank){
				$oldwinnerid=$row->match_winner_user_id;
				$oldwinnerpoints=$row->match_points_won;
				$res2=mysql_query("select * from r_rankings where rank_user_id=".$oldwinnerid);
				if($row2=mysql_fetch_object($res2)){
					mysql_query("update r_rankings set rank_tot_points=rank_tot_points-$oldwinnerpoints where rank_id=$row2->rank_id");
					$flag=1;
				}
				else{
					$res2=mysql_query("select * from r_rankings_women where rank_user_id=".$oldwinnerid);
					if($row2=mysql_fetch_object($res2)){
						mysql_query("update r_rankings_women set rank_tot_points=rank_tot_points-$oldwinnerpoints where rank_id=$row2->rank_id");
						$flag=2;
					}
				}
			}
			$winnerid=fetch_winner_id_points($_POST['callid'],NULL);
			mysql_query("update r_calls set retired=0, match_winner_user_id=".$winnerid[0].", match_points_won=".$winnerid[1]." where call_id=".$_POST['callid']);
			if($flag!=0){
				if($flag==1){
					mysql_query("update r_rankings set rank_tot_points=rank_tot_points+".$winnerid[1]." where rank_user_id=".$winnerid[0]);
				}
				else{
					mysql_query("update r_rankings_women set rank_tot_points=rank_tot_points+".$winnerid[1]." where rank_user_id=".$winnerid[0]);
				}
				sortRankings();
			}
		}
		else{//iparxei retired paiktis
			//$res=mysql_query("select caller_user_id,callee_user_id from r_users where call_id=".$_POST['callid']);
			mysql_query("update r_calls set retired=1, call_completed=1, match_set1='".$score[0]."-".$score[1]."', match_set1_tb='".$score[2]."-".$score[3]."',  match_set2='".$score[4]."-".$score[5]."',  match_set2_tb='".$score[6]."-".$score[7]."',  match_stb='".$score[8]."-".$score[9]."' where call_id=".$_POST['callid']);
			$res=mysql_query("select * from r_calls where call_id=".$_POST['callid']);
			$row=mysql_fetch_object($res);
			$flag=0;
			if($row->countedToRank){
				$oldwinnerid=$row->match_winner_user_id;
				$oldwinnerpoints=$row->match_points_won;
				$res2=mysql_query("select * from r_rankings where rank_user_id=".$oldwinnerid);
				if($row2=mysql_fetch_object($res2)){
					mysql_query("update r_rankings set rank_tot_points=rank_tot_points-$oldwinnerpoints where rank_id=$row2->rank_id");
					$flag=1;
				}
				else{
					$res2=mysql_query("select * from r_rankings_women where rank_user_id=".$oldwinnerid);
					if($row2=mysql_fetch_object($res2)){
						mysql_query("update r_rankings_women set rank_tot_points=rank_tot_points-$oldwinnerpoints where rank_id=$row2->rank_id");
						$flag=2;
					}
				}
			}
			$winnerid=fetch_winner_id_points($_POST['callid'],$_POST['retplrid']);
			mysql_query("update r_calls set retired=1, match_winner_user_id=".$winnerid[0].", match_points_won=".$winnerid[1]." where call_id=".$_POST['callid']);
			if($flag!=0){
				if($flag==1){
					mysql_query("update r_rankings set rank_tot_points=rank_tot_points+".$winnerid[1]." where rank_user_id=".$winnerid[0]);
				}
				else{
					mysql_query("update r_rankings_women set rank_tot_points=rank_tot_points+".$winnerid[1]." where rank_user_id=".$winnerid[0]);
				}
				sortRankings();
			}
		}
		
		echo 1;
		exit();
	}
}
if (isset($_GET['edit'])){
	$res=mysql_query("select * from r_calls where call_id=".$_GET['call']);
	$row=mysql_fetch_object($res);
	$tmp=explode('-',$row->match_set1);
	$set1score1=$tmp[0];
	$set1score2=$tmp[1];
	$tmp=explode('-',$row->match_set1_tb);
	$set1tbscore1=$tmp[0];
	$set1tbscore2=$tmp[1];
	$tmp=explode('-',$row->match_set2);
	$set2score1=$tmp[0];
	$set2score2=$tmp[1];
	$tmp=explode('-',$row->match_set2_tb);
	$set2tbscore1=$tmp[0];
	$set2tbscore2=$tmp[1];
	$tmp=explode('-',$row->match_stb);
	$stbscore1=$tmp[0];
	$stbscore2=$tmp[1];
	$retired=$row->retired;
	?>
	<div class="acegameopponents" call="<?php echo $row->call_id; ?>">
	<strong><?= fetch_player_rank($row->caller_user_id) ?>.<?= fetch_player_name($row->caller_user_id) ?></strong> VS <strong><?= fetch_player_rank($row->callee_user_id) ?>.<?= fetch_player_name($row->callee_user_id) ?></strong>
	</div>
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
          <td height="10"></td>
      </tr>
    <tr>
      <td width="90">Set 1</td>
      <td width="20"><input type="text" id="set1score1" style="width:20px;text-align:center;" maxlength="1" value="0" /></td>
      <td width="3">:</td>
      <td width="20"><input type="text" id="set1score2" style="width:20px;text-align:center;" maxlength="1" value="0" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <div id="set1tbhidden" style="display:none; position:relative; height:20px;">
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="position: absolute; bottom:0px;">
      <tr>
        <td width="90"><strong>Set 1 TB</strong></td>
        <td width="20"><input type="text" id="set1tbscore1" style="width:20px;text-align:center;" value="0" /></td>
        <td width="3">:</td>
        <td width="20"><input type="text" id="set1tbscore2" style="width:20px;text-align:center;" value="0" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </div>
  <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
      <td width="90">Set 2</td>
      <td width="20"><input type="text" id="set2score1" style="width:20px;text-align:center;" maxlength="1" value="0" /></td>
      <td width="3">:</td>
      <td width="20"><input type="text" id="set2score2" style="width:20px;text-align:center;" maxlength="1" value="0" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <div id="set2tbhidden" style="display:none; position:relative; height:20px;">
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="position: absolute; bottom:0px;">
      <tr>
        <td width="90"><strong>Set 2 TB</strong></td>
        <td width="20"><input type="text" id="set2tbscore1" style="width:20px;text-align:center;" value="0" /></td>
        <td width="3">:</td>
        <td width="20"><input type="text" id="set2tbscore2" style="width:20px;text-align:center;" value="0" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </div>
  <div id="stbhidden" style="display:none; position:relative; height:20px;">
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="position: absolute; bottom:0px;">
      <tr>
        <td width="90">Super TB</td>
        <td width="20"><input type="text" id="stbscore1" style="width:20px;text-align:center;" value="0"/></td>
        <td width="3">:</td>
        <td width="20"><input type="text" id="stbscore2" style="width:20px;text-align:center;" value="0"/></td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </div>
  <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="5">Αποχώρησε Τραυματίας:</td>
    <tr>
    <tr>
      <td colspan="5">
        <select id="retiredPlayer" >
            <option value="-1" selected="selected">-</option>
            <option value="<?= $row->caller_user_id ?>"><?= fetch_player_name($row->caller_user_id) ?></option>
              <option value="<?= $row->callee_user_id ?>"><?= fetch_player_name($row->callee_user_id) ?></option>
          </select>
      </td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5" id="errortabletd" valign="middle">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">
      <button class="button" id="submitScoreBtn" style="cursor:pointer">Καταχώρηση</button>
      </td>
    </tr>
  </table>
	<script type="text/javascript">
	function needForSTB(){
		var set1winner=0;
		var set2winner=0;
		if(($('#set1score1').val()==6 && $('#set1score2').val()<5) || $('#set1score1').val()==7){
			set1winner=1;
		}
		if(($('#set1score2').val()==6 && $('#set1score1').val()<5) || $('#set1score2').val()==7){
			set1winner=2;
		}
		if(($('#set2score1').val()==6 && $('#set2score2').val()<5) || $('#set2score1').val()==7){
			set2winner=1;
		}
		if(($('#set2score2').val()==6 && $('#set2score1').val()<5) || $('#set2score2').val()==7){
			set2winner=2;
		}
		if(set1winner!=set2winner && set1winner!=0 && set2winner!=0){
			return true;
		}
		else{
			return false;
		}
	}
		$('.sucScoreSubPopup').click(function(){
			$("#blockMessage").dialog("open");		
		});
		$('#set1score1,#set1score2').keyup(function(e){
		var code = (e.keyCode ? e.keyCode : e.which);
		if (($('#set1score1').val()==7 && $('#set1score2').val()==6) || ($('#set1score1').val()==6 && $('#set1score2').val()==7)){
			$('#set1tbhidden').slideDown();
		}
		
		else{
			$('#set1tbhidden').slideUp();
			$('#set1tbhidden').find('#set1tbscore1').val('0');
			$('#set1tbhidden').find('#set1tbscore2').val('0');
		}	
		if(needForSTB()){
			$('#stbhidden').slideDown();
		}
		else{
			$('#stbhidden').slideUp();
		}
	});
	$('#set2score1,#set2score2').keyup(function(e){
		var code = (e.keyCode ? e.keyCode : e.which);
		if (($('#set2score1').val()==7 && $('#set2score2').val()==6) || ($('#set2score1').val()==6 && $('#set2score2').val()==7)){
			$('#set2tbhidden').slideDown();
		}
		
		else{
			$('#set2tbhidden').slideUp();
			$('#set2tbhidden').find('#set2tbscore1').val('0');
			$('#set2tbhidden').find('#set2tbscore2').val('0');
		}	
		if(needForSTB()){
			$('#stbhidden').slideDown();
		}
		else{
			$('#stbhidden').slideUp();
		}
	});
		//('#set1score1,#set1score2').change(function(){
	//		if ($(this).val()<0 || $(this).val()>7){
	//			$(this).val('');
	//			$(this).focus();
	//		}
	//		else if ((parseInt($('#set1score1').val()) + parseInt($('#set1score2').val()))==13){
	//			$('#set1tbhidden').show();
	//		}
	//		else {
	//		}
	//	});
	//	$('#set2score1,#set2score2').change(function(){
	//		if ($(this).val()<0 || $(this).val()>7){
	//			$(this).val('');
	//			$(this).focus();
	//		}
	//		else if ((parseInt($('#set2score1').val()) + parseInt($('#set2score2').val()))==13){
	//			$('#set2tbhidden').show();
	//		}
	//		else {
	//				$('#set2tbhidden').hide();
	//		}
	//	});
		$('#set1score1,#set1score2,#set1tbscore1,#set1tbscore2,#set2tbscore1,#set2tbscore2,#set2score1,#set2score2,#stbscore1,#stbscore2 ').focus(function(){
			if ($(this).val()=='0'){
				$(this).val('');
			}
		});
		$('#set1score1,#set1score2,#set1tbscore1,#set1tbscore2,#set2tbscore1,#set2tbscore2,#set2score1,#set2score2,#stbscore1,#stbscore2 ').blur(function(){
			if ($(this).val()==''){
				$(this).val('0');
			}
		});
		$('#submitScoreBtn').click(function(){
			ret=$('#retiredPlayer').val();
			
			$.ajax({
			  type: "POST",
			  url: "../Ranking/updateScoreFields.php",
			  data: { submitedit: 'ok', callid: <?= $_GET['call'] ?>, score: $('#set1score1').val()+"-"+$('#set1score2').val()+"-"+$('#set1tbscore1').val()+"-"+$('#set1tbscore2').val()+"-"+$('#set2score1').val()+"-"+$('#set2score2').val()+"-"+$('#set2tbscore1').val()+"-"+$('#set2tbscore2').val()+"-"+$('#stbscore1').val()+"-"+$('#stbscore2').val(), retplrid: ret}
			}).done(function( msg ) {
				//alert(msg);return false;
				if (msg=='1'){
					window.location.reload();
				}
				else{
					if ($(".wrongScoreInputMess:visible")[0]){
						$('.wrongScoreInputMess:visible').remove();
						$('#errortabletd:visible').prepend('<div class="wrongScoreInputMess" style="color: #FF0000;">Το σκόρ που δώσατε δεν είναι έγκυρο!</div>');
					}
					else{
						$('#errortabletd:visible').prepend('<div class="wrongScoreInputMess" style="color: #FF0000;">Το σκόρ που δώσατε δεν είναι έγκυρο!</div>');
					}
					
				}
			});
			return false;
		});
		$('#retiredCheckbox').change(function(){
			if ($(this).attr('checked')!=undefined && $(this).attr('checked')=='checked'){
			alert($(this).attr('checked'));
				$('#retiredPlayer').show();
			}
			else{
				$('#retiredPlayer').hide();
			}
		});
	</script>
	<?php
	exit();
}

$res=mysql_query("select * from r_calls where call_id=".$_GET['call']);
$row=mysql_fetch_object($res);
	
?>
<div class="acegameopponents" call="<?php echo $row->call_id; ?>">
<strong><?= fetch_player_rank($row->caller_user_id) ?>.<?= fetch_player_name($row->caller_user_id) ?></strong> VS <strong><?= fetch_player_rank($row->callee_user_id) ?>.<?= fetch_player_name($row->callee_user_id) ?></strong>
</div>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
    		<td height="10"></td>
    </tr>
  <tr>
    <td width="90">Set 1</td>
    <td width="20"><input type="text" id="set1score1" style="width:20px;text-align:center;" maxlength="1" value="0" /></td>
    <td width="3">:</td>
    <td width="20"><input type="text" id="set1score2" style="width:20px;text-align:center;" maxlength="1" value="0" /></td>
    <td>&nbsp;</td>
  </tr>
</table>
<div id="set1tbhidden" style="display:none; position:relative; height:20px;">
  <table border="0" width="100%" cellspacing="0" cellpadding="0" style="position: absolute; bottom:0px;">
    <tr>
      <td width="90"><strong>Set 1 TB</strong></td>
      <td width="20"><input type="text" id="set1tbscore1" style="width:20px;text-align:center;" value="0" /></td>
      <td width="3">:</td>
      <td width="20"><input type="text" id="set1tbscore2" style="width:20px;text-align:center;" value="0" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="90">Set 2</td>
    <td width="20"><input type="text" id="set2score1" style="width:20px;text-align:center;" maxlength="1" value="0" /></td>
    <td width="3">:</td>
    <td width="20"><input type="text" id="set2score2" style="width:20px;text-align:center;" maxlength="1" value="0" /></td>
    <td>&nbsp;</td>
  </tr>
</table>
<div id="set2tbhidden" style="display:none; position:relative; height:20px;">
  <table border="0" width="100%" cellspacing="0" cellpadding="0" style="position: absolute; bottom:0px;">
    <tr>
      <td width="90"><strong>Set 2 TB</strong></td>
      <td width="20"><input type="text" id="set2tbscore1" style="width:20px;text-align:center;" value="0" /></td>
      <td width="3">:</td>
      <td width="20"><input type="text" id="set2tbscore2" style="width:20px;text-align:center;" value="0" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
<div id="stbhidden" style="display:none; position:relative; height:20px;">
  <table border="0" width="100%" cellspacing="0" cellpadding="0" style="position: absolute; bottom:0px;">
    <tr>
      <td width="90">Super TB</td>
      <td width="20"><input type="text" id="stbscore1" style="width:20px;text-align:center;" value="0"/></td>
      <td width="3">:</td>
      <td width="20"><input type="text" id="stbscore2" style="width:20px;text-align:center;" value="0"/></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
  	<td colspan="5">&nbsp;</td>
  </tr>
  <tr>
  		<td colspan="5">Αποχώρησε Τραυματίας:</td>
  <tr>
  <tr>
  	<td colspan="5">
    	<select id="retiredPlayer" >
        	<option value="-1" selected="selected">-</option>
        	<option value="<?= $row->caller_user_id ?>"><?= fetch_player_name($row->caller_user_id) ?></option>
            <option value="<?= $row->callee_user_id ?>"><?= fetch_player_name($row->callee_user_id) ?></option>
        </select>
    </td>
  </tr>
  <tr>
  	<td colspan="5">&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="5" id="errortabletd" valign="middle">&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="4">
		<button class="button" id="submitScoreBtn" style="cursor:pointer">Καταχώρηση</button>
    </td>
  </tr>
</table>
<script type="text/javascript">
	function needForSTB(){
		var set1winner=0;
		var set2winner=0;
		if(($('#set1score1').val()==6 && $('#set1score2').val()<5) || $('#set1score1').val()==7){
			set1winner=1;
		}
		if(($('#set1score2').val()==6 && $('#set1score1').val()<5) || $('#set1score2').val()==7){
			set1winner=2;
		}
		if(($('#set2score1').val()==6 && $('#set2score2').val()<5) || $('#set2score1').val()==7){
			set2winner=1;
		}
		if(($('#set2score2').val()==6 && $('#set2score1').val()<5) || $('#set2score2').val()==7){
			set2winner=2;
		}
		if(set1winner!=set2winner && set1winner!=0 && set2winner!=0){
			return true;
		}
		else{
			return false;
		}
	}
	$('.sucScoreSubPopup').click(function(){
		$("#blockMessage").dialog("open");		
	});
	$('#set1score1,#set1score2').keyup(function(e){
		var code = (e.keyCode ? e.keyCode : e.which);
		if (($('#set1score1').val()==7 && $('#set1score2').val()==6) || ($('#set1score1').val()==6 && $('#set1score2').val()==7)){
			$('#set1tbhidden').slideDown();
		}
		
		else{
			$('#set1tbhidden').slideUp();
			$('#set1tbhidden').find('#set1tbscore1').val('0');
			$('#set1tbhidden').find('#set1tbscore2').val('0');
		}	
		if(needForSTB()){
			$('#stbhidden').slideDown();
		}
		else{
			$('#stbhidden').slideUp();
		}
	});
	$('#set2score1,#set2score2').keyup(function(e){
		var code = (e.keyCode ? e.keyCode : e.which);
		if (($('#set2score1').val()==7 && $('#set2score2').val()==6) || ($('#set2score1').val()==6 && $('#set2score2').val()==7)){
			$('#set2tbhidden').slideDown();
		}
		
		else{
			$('#set2tbhidden').slideUp();
			$('#set2tbhidden').find('#set2tbscore1').val('0');
			$('#set2tbhidden').find('#set2tbscore2').val('0');
		}	
		if(needForSTB()){
			$('#stbhidden').slideDown();
		}
		else{
			$('#stbhidden').slideUp();
		}
	});
	//('#set1score1,#set1score2').change(function(){
//		if ($(this).val()<0 || $(this).val()>7){
//			$(this).val('');
//			$(this).focus();
//		}
//		else if ((parseInt($('#set1score1').val()) + parseInt($('#set1score2').val()))==13){
//			$('#set1tbhidden').show();
//		}
//		else {
//		}
//	});
//	$('#set2score1,#set2score2').change(function(){
//		if ($(this).val()<0 || $(this).val()>7){
//			$(this).val('');
//			$(this).focus();
//		}
//		else if ((parseInt($('#set2score1').val()) + parseInt($('#set2score2').val()))==13){
//			$('#set2tbhidden').show();
//		}
//		else {
//				$('#set2tbhidden').hide();
//		}
//	});
	$('#set1score1,#set1score2,#set1tbscore1,#set1tbscore2,#set2tbscore1,#set2tbscore2,#set2score1,#set2score2,#stbscore1,#stbscore2 ').focus(function(){
		if ($(this).val()=='0'){
			$(this).val('');
		}
	});
	$('#set1score1,#set1score2,#set1tbscore1,#set1tbscore2,#set2tbscore1,#set2tbscore2,#set2score1,#set2score2,#stbscore1,#stbscore2 ').blur(function(){
		if ($(this).val()==''){
			$(this).val('0');
		}
	});
	$('#submitScoreBtn').click(function(){
		ret=$('#retiredPlayer').val();
		
		$.ajax({
		  type: "POST",
		  url: "../Ranking/updateScoreFields.php",
		  data: { submit: 'ok', callid: <?= $_GET['call'] ?>, score: $('#set1score1').val()+"-"+$('#set1score2').val()+"-"+$('#set1tbscore1').val()+"-"+$('#set1tbscore2').val()+"-"+$('#set2score1').val()+"-"+$('#set2score2').val()+"-"+$('#set2tbscore1').val()+"-"+$('#set2tbscore2').val()+"-"+$('#stbscore1').val()+"-"+$('#stbscore2').val(), retplrid: ret}
		}).done(function( msg ) {
			//alert(msg);return false;
			if (msg=='1'){
				window.location.reload();
			}
			else{
				if ($(".wrongScoreInputMess:visible")[0]){
				   	$('.wrongScoreInputMess:visible').remove();
					$('#errortabletd:visible').prepend('<div class="wrongScoreInputMess" style="color: #FF0000;">Το σκόρ που δώσατε δεν είναι έγκυρο!</div>');
				}
				else{
					$('#errortabletd:visible').prepend('<div class="wrongScoreInputMess" style="color: #FF0000;">Το σκόρ που δώσατε δεν είναι έγκυρο!</div>');
				}
				
			}
		});
		return false;
	});
	$('#retiredCheckbox').change(function(){
		if ($(this).attr('checked')!=undefined && $(this).attr('checked')=='checked'){
		alert($(this).attr('checked'));
			$('#retiredPlayer').show();
		}
		else{
			$('#retiredPlayer').hide();
		}
	});
</script>