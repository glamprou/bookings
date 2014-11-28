<script type="text/javascript" src="scripts/autocomplete.js"></script>
<div id="participantDialog" title="Επιλογή παίκτη" class="dialog"></div>
<?php
@include_once('../config.php');	
@include_once('config.php');	
@include_once('../functions.php');
@include_once('functions.php');

if (isset($_POST['ajaxize'])){
	$res112=mysql_query("select calls_block_schedule,calls_block_scheduled from r_blocks");
	$res112=mysql_fetch_object($res112);
	if($res112->calls_block_scheduled){
		$tmparr=explode('-',$res112->calls_block_schedule);
		$block_date=$tmparr[2]."-".$tmparr[1]."-".$tmparr[0];
	}
	if(isset($_GET['sex'])){
		if($_GET['sex']=='male'){
			$table="r_rankings";
		}
		else{
			$table="r_rankings_women";
		}
	}
	else{
		$table="r_rankings";
	}
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" >
	  <tr>
		<td width="200"><h1>Προσκλήσεις</h1></td>
		<td>
			<h1 style="padding-top: 23px;">
				<select id="chooseSex" class="textbox" style="margin-bottom:1px">
					<option value="male">Ανδρών</option>
					<option <?php if(isset($_GET['sex']) && $_GET['sex']=="female") echo "selected='selected'"; ?> value="female">Γυναικών</option>
				</select>	
			</h1>
		</td>
	  </tr>
	</table>
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	<link rel="stylesheet" type="text/css" href="css/jquery.qtip.min.css">
	<link rel="stylesheet" type="text/css" href="inc/styles.css">
	<script type="text/javascript" src="scripts/js/jquery.qtip.min.js" ></script>
	
	<table width="860" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td colspan="2"><h2 style="border-bottom:0px solid;padding-top: 10px;">Οι προσκλήσεις μου</h2></td>
	  </tr>
	  <tr>
		<td  valign="top">
			<table class="list userList" border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<th align="left" width=490"">Έχετε προσκληθεί</th>
					<th align="left">Έχετε προσκαλέσει</th>
				</tr>
			<?php
				$res=mysql_query("select * from r_calls where callee_user_id=$userid and call_accepted=0");
				$res1=mysql_query("select * from r_calls where caller_user_id=$userid and call_accepted=0");
				$i=0;
				$row=mysql_fetch_object($res);  
				$row1=mysql_fetch_object($res1);
				while ($row || $row1){
					echo "<tr class='row".($i%2)."'>";
					$i++;
					?>
					<td>
						<table border="0" cellspacing="0" cellpadding="0" width="100%">
						  <tr>
						  <?php
							if ($row){
						  ?>
							<td style="border:0px solid;" width="250"><?= fetch_player_name($row->caller_user_id) ?></td>
							<td style="border:0px solid;" width="80"><?= changeDate($row->call_date) ?></td>
                            <td align="center" style="border:0px solid; padding:0px;" width="80"><div class="btn accept_call" style="color:green; width:60px;" value="<?= $row->call_id ?>">ΑΠΟΔΟΧΗ</div></td>
							<td style="border:0px solid;" width="80"><div class="btn decline_call" style="color:#FF0000" value="<?= $row->call_id ?>">ΑΠΟΡΡΙΨΗ</div></td>
							<?php
							}
							else{
							?>
							<td colspan="4" style="border:0px solid;">&nbsp;</td>
							<?php
							}
							?>
						  </tr>
						</table>
					</td>
					<td>
						<table border="0" cellspacing="0" cellpadding="0" width="100%">
						  <tr>
							<?php
							if ($row1){
							?>
							<td style="border:0px solid;" width="250"><?= fetch_player_name($row1->callee_user_id) ?></td>
							<td style="border:0px solid;" width="80"><?= changeDate($row1->call_date) ?></td>
							<?php
							}
							else{
							?>
							<td colspan="2" style="border:0px solid;">&nbsp;</td>
							<?php
							}
							?>
						  </tr>
						</table>
					</td>
					<?php
					echo "</tr>";
					$row=mysql_fetch_object($res);  	
					$row1=mysql_fetch_object($res1);
				}
				if (!$i)
					echo "<tr class='row1'><td colspan='2'>Δεν έχετε ανοιχτές προσκλήσεις</td></tr>";
			?>                      	
			</table>
		</td>
	  </tr>
	  
	  
	  <tr>
		<td colspan="2"><h2 style="border-bottom:0px solid;padding-top: 10px;">Οι εκκρεμότητες μου</h2>	</td>
	  </tr>
	  <tr>
		<td  valign="top">
			<table class="list userList" width="100%" border="0" cellspacing="0" cellpadding="0" style="min-height:265px;">
			<tr>
				<th width="490">AceGame</th>
				<th>Εκκρεμότητα</th>
				<th width="43">Points</th>   
				<th width="70">Date</th>
			</tr> 
	<?php
		$res=mysql_query("select * from r_calls where ((caller_user_id=$userid or callee_user_id=$userid) and (call_accepted=1 and call_completed=0))");
		$i=0;
		while ($row=mysql_fetch_object($res)){
	?>
			<tr class="row<?= $i%2 ?>">
				<td class="aceGameTD"><?= fetch_player_call_rank($row->call_id,$row->caller_user_id,0) ?>.<?= fetch_player_name($row->caller_user_id) ?> <strong>called</strong> <?= fetch_player_call_rank($row->call_id,$row->callee_user_id,1) ?>.<?= fetch_player_name($row->callee_user_id)  
				//	<span class="btn cancelCallByAdmin" style="display:none; color:#FF0000;" title="Akyrwsi tou call" value=" $row->call_id ">x</span> ?>
				</td>
				<td  align="center">
				<?php
				if ($row->match_date=='0000-00-00'){
				?>
				<a href="schedule.php?call=<?= $row->call_id ?>" style="color:transparent;"><button class="button" id="insertDateBtn" style="width:190px; margin:0;">Εισαγωγή ημερομηνίας</button></a>     
				<?php
				}
				else{
				?>
				<button class="button submitMatchScore tip" id="insertScoreBtn" rel="<?= $row->call_id ?>" style="width:190px; margin:0;">Εισαγωγή αποτελέσματος</button>      
				<?php
				}
				?>
				</td>
				<td  align="center">
		<?php 	if($row->match_points_won!=0){ 
					echo $row->match_points_won; 
				}
				else{
					echo fetch_points_by_callid($row->caller_user_id,$row->callee_user_id,$row->caller_user_id,$row->call_id)." or ".fetch_points_by_callid($row->caller_user_id,$row->callee_user_id,$row->callee_user_id,$row->call_id);
				}
				?></td>   
				<td  align="center"><?php 
				if($row->match_date!='0000-00-00'){ ?>
					<span style="color:#000000"><?= changeDate($row->match_date) ?></span>
	<?php		}
				else{ ?> 
					<span style="color:#FF0000"><?= changeDate($row->call_date) ?></span>			 
	<?php		}	
				?></td>
			</tr> 
	
	<?php		
			$i++;
			}
			if (!$i)
					echo "<tr class='row1'><td colspan='4'>Δεν έχετε εκκρεμότητες</td></tr>";
	?>
	</table>
		</td>
	  </tr>
	  
	  
	  <tr>
		<td colspan="2"><h2 style="border-bottom:0px solid;">Αποτελέσματα προσκλήσεων</h2></td>
	  </tr>
	  <tr>
		 <td colspan="2">
			<table width="860" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td><input type="text" id="autocompletenames" name="choosenUser" onfocus="javascript: if($(this).val()=='Όλοι οι Παίκτες'){$(this).val('');  }" onblur="javascript: if($(this).val()==''){$(this).val('Όλοι οι Παίκτες');  }" value="Όλοι οι Παίκτες" /></td>
				<td>
					<select id="matchtypeselection">
                        <option value="all">Όλοι οι αγώνες</option>
                        <option value="-1">Ακυρωμένοι αγώνες</option>
                        <option value="0">Εκκρεμείς προσκλήσεις</option>
		    	 		<option value="2">Δεν έχουν οριστεί</option>
                        <option value="1">Προγραμματισμένοι αγώνες</option>
                        <option value="3">Ολοκληρωμένοι αγώνες</option>
                    </select>
				</td>
			  </tr>
			</table>
		</td>
	  </tr>
	  <tr height="5">
		<td></td>
	  </tr>
	  <tr>
		<td id="allCallsOuter" colspan="2">&nbsp;</td>
	  </tr>
	</table>
	<script type="text/javascript">
	$(document).ready(function(){
		$(function() {
			var players = ["Όλοι οι Παίκτες",<?php		$res=mysql_query("select users.fname,users.lname,$table.rank_pos from users inner join $table on users.user_id = $table.rank_user_id where 1 order by $table.rank_pos asc");
											$i=0;
											while ($row=mysql_fetch_object($res)){
												if ($i)
													echo ", ";
												else
													$i=1;
												echo "\"".$row->rank_pos.".".$row->fname." ".$row->lname."\"";
											}
										?>
			];
			$( "#autocompletenames" ).off().autocomplete({
				source: function(request, response) {
							var results = $.ui.autocomplete.filter(players, request.term);
					
							response(results.slice(0, 7));
						}, 
				minLength: 0
			});
			$( "#autocompletenames" ).off().focus(function(){
				$( "#autocompletenames" ).autocomplete( "search", "" );
			});
			
		});
		<?php 
		if(isset($_GET['sex'])){
			echo "$('#allCallsOuter').load('fetchAllCalls.php',{calltype: $('#matchtypeselection').val(),sex: '".$_GET['sex']."'});";
			
		}
		else{
			echo "$('#allCallsOuter').load('fetchAllCalls.php',{calltype: $('#matchtypeselection').val(),sex: 'male'});";
		}
		?>
		
		$('#plrnumselection').off().change(function(){
			if ($(this).val()==1)
				$('#autocompletenames').show();
			else
				$('#autocompletenames').hide();
		//	$('#callsTableArea').html('mpike');
		});
		$('#matchtypeselection').off().change(function(){
			if ($('#autocompletenames').val().indexOf('.')==-1 && $('#autocompletenames').val()!='Όλοι οι Παίκτες'){
				return false;
			}
			var wntname=$('#autocompletenames').val().substring($('#autocompletenames').val().indexOf('.')+1,$('#autocompletenames').val().length);
			var calltype=$('#matchtypeselection').val();
			$('#allCallsOuter').load("fetchAllCalls.php",{plrname: wntname, calltype: calltype, sex: $('#chooseSex').val()});
		});
		$('#chooseSex').off().change(function(){
			var old_url=window.location.href;
			var new_url = old_url.substring(0, old_url.indexOf('?'));
			if (new_url=='')
				new_url=old_url;
			window.location.href=new_url+"?sex="+$('#chooseSex').val();
		});
		$('#autocompletenames').off().blur(function(){
			if ($('#autocompletenames').val().indexOf('.')==-1 && $('#autocompletenames').val()!='Όλοι οι Παίκτες'){
				return false;
			}
			var wntname=$('#autocompletenames').val().substring($('#autocompletenames').val().indexOf('.')+1,$('#autocompletenames').val().length);
			var calltype=$('#matchtypeselection').val();
			$('#allCallsOuter').load("fetchAllCalls.php",{plrname: wntname, calltype: calltype, sex: $('#chooseSex').val()});
		});/*
		$('#blockBtn').click(function(){
			if ($('#datepicker').val()==''){
				alert('Parakalw dwste imerominia');
				return;
			}		
			$.ajax({
			  type: "POST",
			  url: "inc/calls.php",
			  data: { blocking: "ok", date:  $('#datepicker').val()}
			}).done(function( msg ) {
				var old_url=window.location.href;
				var new_url = old_url.substring(0, old_url.indexOf('&'));
				if (new_url=='')
					new_url=old_url;
				window.location.href=new_url;
			});
			return false;
		});	
		$('#unblockBtn').click(function(){
			$.ajax({
			  type: "POST",
			  url: "inc/calls.php",
			  data: { unblocking: "ok"}
			}).done(function( msg ) {
				var old_url=window.location.href;
				var new_url = old_url.substring(0, old_url.indexOf('&'));
				if (new_url=='')
					new_url=old_url;
				window.location.href=new_url;
			});
			return false;
		});
		$('#updateblockBtn').click(function(){
			$.ajax({
			  type: "POST",
			  url: "inc/calls.php",
			  data: { updateblock: "ok", updateblockdate:  $('#datepicker').val()}
			}).done(function( msg ) {
			//  alert( msg );
			});
			return false;
		});*/
		$('.accept_call').off().one('click',function(){
			var parent=$(this).parent();
			parent.html('<div style="width: 60px;"><img height="16" src="img/admin-ajax-indicator.gif" /></div>');
            $.ajax({
              type: "POST",
              url: "calls.php",
              data: { acceptCall: "ok", callid:  $(this).attr('value')}
            }).done(function( msg ) {
                if ($(".success")[0]){
				   // Do something here if class exists
					$('.success').remove();
					$('#content').prepend('<div class="success" style="" id="profileUpdatedMessage">Αποδεχτήκατε την πρόσκληση με επιτυχία.</div>');
				}
				else{
					$('#content').prepend('<div class="success" style="" id="profileUpdatedMessage">Αποδεχτήκατε την πρόσκληση με επιτυχία.</div>');
				}
				$.ajax({
				type: "POST",
				url: "calls.php",
				data: { ajaxize: "true"}
				}).done(function( data ) {
					$('.callsDiv').html(data);
				});
            });
            return false;
        });
		$('.decline_call').off().click(function(){
			$('.declineHim').attr('value',$(this).attr('value'));
			$("#declineCallMessage").dialog("open");	
        });	
        
        function fetchContent(){
            return $('.submitMatchScore').html();
        }
        
		$("#declineCallMessage").dialog({
			autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
			minHeight: 400, minWidth: 700, width: 700,
			open: function(event, ui) {
				$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
			}
			
		});
		$('.declineHim').off().one('click',function(){
			$.ajax({
              type: "POST",
              url: "calls.php",
              data: { declineCall: "ok", callid:  $(this).attr('value')}
            }).done(function( msg ) {
				window.location.reload();
            });
            return false;
		});
		$('.cancelDecline').off().click(function(){
			 $("#declineCallMessage").dialog("close");
		});
		
		function fetchContent(){
			return $('.submitMatchScore').html();
		}
		
		$('.submitMatchScore').off().each(function(){
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
				url: "updateScoreFields.php",
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
	return;
}
if (isset($_POST['cancelCall'])){
	mysql_query("update r_calls set call_accepted=-1 where call_id=".$_POST['callid']);
	exit();
}
if (isset($_POST['acceptCall'])){
	mysql_query("update r_calls set call_accepted=1 where call_id=".$_POST['callid']);
	mysql_query("delete from r_call_activation_codes where ac_call_id=".$_POST['callid']);
	require_once('../lib/Email/Messages/CallAcceptedEmail.php');
	$res=mysql_query("select caller_user_id,callee_user_id from r_calls where call_id=".$_POST['callid']);
	$row=mysql_fetch_object($res);
	$userrep=new UserRepository();
	$user=$userrep->LoadById($row->callee_user_id);
	$calleruser=$userrep->LoadById($row->caller_user_id);
	ServiceLocator::GetEmailService()->Send(new CallAcceptedEmail($user, $calleruser));
	ServiceLocator::GetEmailService()->Send(new CallAcceptedEmail($calleruser, $user));
	
	$db=ServiceLocator::GetDatabase();
	$db->Connection->Connect(); 
	sms($_POST['callid'],$row->caller_user_id,1);
	exit();
}
if (isset($_POST['declineCall'])){
	mysql_query("update r_calls set call_accepted=-1 where call_id=".$_POST['callid']);
	mysql_query("delete from r_call_activation_codes where ac_call_id=".$_POST['callid']);
	require_once('../lib/Email/Messages/CallDeclinedEmail.php');
	$res=mysql_query("select caller_user_id,callee_user_id from r_calls where call_id=".$_POST['callid']);
	$row=mysql_fetch_object($res);
	givePenalty($userid);
	$userrep=new UserRepository();
	$user=$userrep->LoadById($row->callee_user_id);
	$calleruser=$userrep->LoadById($row->caller_user_id);
	ServiceLocator::GetEmailService()->Send(new CallDeclinedEmail($user, $calleruser));
	
	$morethanthreematches=false;//three is dynamic now
	
	$db=ServiceLocator::GetDatabase();
	$db->Connection->Connect();
	
	$tmpres=mysql_query("select numAGFreeDecl from r_options");
	$tmprow=mysql_fetch_object($tmpres);
	$numofmatchesforfreedecl=$tmprow->numAGFreeDecl;
	
	$r=mysql_query("select * from r_calls where (caller_user_id=$row->callee_user_id or callee_user_id=$row->callee_user_id) and call_accepted=1 and call_completed=0");
	if (mysql_num_rows($r)>=$numofmatchesforfreedecl){//den tha dexthei poini
		$morethanthreematches=true;
	}
	ServiceLocator::GetEmailService()->Send(new CallDeclinedEmail($calleruser, $user, $morethanthreematches));
	
	$db=ServiceLocator::GetDatabase();
	$db->Connection->Connect();
	sms($_POST['callid'],$row->caller_user_id,2);
	exit();
}
if (isset($_POST['updateblock'])){
	if ($_POST['updateblockdate'] <= date('d-m-Y')){
		mysql_query("update r_blocks set calls_block=1, calls_block_scheduled=0, calls_block_schedule='0000-00-00'");
		exit();
	}
	$date=$_POST['updateblockdate'];
	$newarr=explode('-',$date);
	$date=$newarr[2]."-".$newarr[1]."-".$newarr[0];
	$res=mysql_query("update r_blocks set calls_block_scheduled=1,calls_block_schedule='$date', calls_block=0 where 1");
	if ($res)
		echo "Η ενημέρωση έγινε με επιτυχία!";
	else
		echo "Η ενημέρωση επέτυχε! Παρακαλώ ξαναπροσπαθήστε!";
	exit();
}
if (isset($_POST['getPlrs'])){
	if ($_POST['partPlr']){
		if ($_POST['mType']=="all")
			$c1res=mysql_query("select * from r_calls where (caller_user_id=".$_POST['plrid']." or callee_user_id=".$_POST['plrid'].")");
		else
			$c1res=mysql_query("select * from r_calls where ((caller_user_id=".$_POST['plrid']." or callee_user_id=".$_POST['plrid'].") and call_completed=".$_POST['mType'].")");
	}
	else{
		if ($_POST['mType']=="all")
			$c1res=mysql_query("select * from r_calls where 1");
		else
			$c1res=mysql_query("select * from r_calls where (call_completed=".$_POST['mType'].")");
	}?>
	<table cellpadding="1" cellspacing="0" border="1" width="100%">
		<tr>
			<td>AceGame</td>
			<td>Set1</td>
			<td>Set1</td>
			<td>Set1</td>
			<td title="Κερδισμένοι πόντοι">ΚΠ</td>
			<td>Ημ. αγώνα</td>
			<td>Ημ. κλήσης</td>
		</tr>        
	<?php 	
    while ($c1row=mysql_fetch_object($c1res)){ ?>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="150"><?= fetch_player_call_rank($c1row->call_id,$c1row->caller_user_id,0) ?>.<?= fetch_player_name($c1row->caller_user_id) ?></td>  
                    <td>&nbsp;<b>called</b>&nbsp;</td>
                    <td width="150"><?= fetch_player_call_rank($c1row->call_id,$c1row->callee_user_id,1) ?>.<?= fetch_player_name($c1row->callee_user_id) ?></td>
                  </tr>
                </table>	
            </td>
            <td><?= $c1row->match_set1 ?></td>
            <td><?= $c1row->match_set2 ?></td>
            <td><?= $c1row->match_set3 ?></td>
            <td><?= fetch_points_by_callid($c1row->caller_user_id,$c1row->callee_user_id,$c1row->match_winner_user_id,$c1row->call_id) ?></td>
            <td><?php if($c1row->match_datetime!="0000-00-00 00:00:00") echo date ("d/m/Y",strtotime($c1row->match_datetime)); else echo "Δεν έχει οριστεί"; ?></td>
            <td><?= date ("d/m/Y",strtotime($c1row->call_datetime));  ?></td>
        </tr>
    <?php 	
    }
    ?>
	</table><?php
	exit();
}	
if (isset($_POST['blocking'])){
	$date=$_POST['date'];
	if ($_POST['date'] <= date('d-m-Y')){
		mysql_query("update r_blocks set calls_block=1");
	}
	else{
		$newarr=explode('-',$date);
		$date=$newarr[2]."-".$newarr[1]."-".$newarr[0];
		mysql_query("update r_blocks set calls_block_scheduled=1,calls_block_schedule='$date'");
	}
	exit;
}
if (isset($_POST['unblocking'])){
	mysql_query("update r_blocks set calls_block=0,calls_block_scheduled=0,calls_block_schedule='0000-00-00'");
	exit;
}
$res112=mysql_query("select calls_block_schedule,calls_block_scheduled from r_blocks");
$res112=mysql_fetch_object($res112);
if($res112->calls_block_scheduled){
	$tmparr=explode('-',$res112->calls_block_schedule);
	$block_date=$tmparr[2]."-".$tmparr[1]."-".$tmparr[0];
}
if(isset($_GET['sex'])){
	if($_GET['sex']=='male'){
		$table="r_rankings";
	}
	else{
		$table="r_rankings_women";
	}
}
else{
	$table="r_rankings";
}
?>
<div class="callsDiv">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" >
      <tr>
        <td width="200"><h1>Προσκλήσεις</h1></td>
        <td>
            <h1 style="padding-top: 23px;">
                <select id="chooseSex" class="textbox" style="margin-bottom:1px">
                    <option value="male">Ανδρών</option>
                    <option <?php if(isset($_GET['sex']) && $_GET['sex']=="female") echo "selected='selected'"; ?> value="female">Γυναικών</option>
                </select>	
            </h1>
        </td>
      </tr>
    </table>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.qtip.min.css">
    <link rel="stylesheet" type="text/css" href="inc/styles.css">
    <script type="text/javascript" src="scripts/js/jquery.qtip.min.js" ></script>
    
    <table width="860" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2"><h2 style="border-bottom:0px solid;padding-top: 10px;">Οι προσκλήσεις μου</h2></td>
      </tr>
      <tr>
        <td  valign="top">
            <table class="list userList" border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <th align="left" width=490"">Έχετε προσκληθεί</th>
                    <th align="left">Έχετε προσκαλέσει</th>
                </tr>
            <?php
                $res=mysql_query("select * from r_calls where callee_user_id=$userid and call_accepted=0");
                $res1=mysql_query("select * from r_calls where caller_user_id=$userid and call_accepted=0");
                $i=0;
                $row=mysql_fetch_object($res);  
                $row1=mysql_fetch_object($res1);
                while ($row || $row1){
                    echo "<tr class='row".($i%2)."'>";
                    $i++;
                    ?>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                          <tr>
                          <?php
                            if ($row){
                          ?>
                            <td style="border:0px solid;" width="250"><?= fetch_player_name($row->caller_user_id) ?></td>
                            <td style="border:0px solid;" width="80"><?= changeDate($row->call_date) ?></td>
                            <td align="center" style="border:0px solid; padding:0px;" width="80"><div class="btn accept_call" style="color:green; width:60px;" value="<?= $row->call_id ?>">ΑΠΟΔΟΧΗ</div></td>
                            <td style="border:0px solid;" width="80"><div class="btn decline_call" style="color:#FF0000" value="<?= $row->call_id ?>">ΑΠΟΡΡΙΨΗ</div></td>
                            <?php
                            }
                            else{
                            ?>
                            <td colspan="4" style="border:0px solid;">&nbsp;</td>
                            <?php
                            }
                            ?>
                          </tr>
                        </table>
                    </td>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                          <tr>
                            <?php
                            if ($row1){
                            ?>
                            <td style="border:0px solid;" width="250"><?= fetch_player_name($row1->callee_user_id) ?></td>
                            <td style="border:0px solid;" width="80"><?= changeDate($row1->call_date) ?></td>
                            <?php
                            }
                            else{
                            ?>
                            <td colspan="2" style="border:0px solid;">&nbsp;</td>
                            <?php
                            }
                            ?>
                          </tr>
                        </table>
                    </td>
                    <?php
                    echo "</tr>";
                    $row=mysql_fetch_object($res);  	
                    $row1=mysql_fetch_object($res1);
                }
                if (!$i)
                    echo "<tr class='row1'><td colspan='2'>Δεν έχετε ανοιχτές προσκλήσεις</td></tr>";
            ?>                      	
            </table>
        </td>
      </tr>
      
      
      <tr>
        <td colspan="2"><h2 style="border-bottom:0px solid;padding-top: 10px;">Οι εκκρεμότητες μου</h2>	</td>
      </tr>
      <tr>
        <td  valign="top">
            <table class="list userList" width="100%" border="0" cellspacing="0" cellpadding="0" style="min-height:265px;">
            <tr>
                <th width="490">AceGame</th>
                <th>Εκκρεμότητα</th>
                <th width="43">Points</th>   
                <th width="70">Date</th>
            </tr> 
    <?php
        $res=mysql_query("select * from r_calls where ((caller_user_id=$userid or callee_user_id=$userid) and (call_accepted=1 and call_completed=0))");
        $i=0;
        while ($row=mysql_fetch_object($res)){
    ?>
            <tr class="row<?= $i%2 ?>">
                <td class="aceGameTD"><?= fetch_player_call_rank($row->call_id,$row->caller_user_id,0) ?>.<?= fetch_player_name($row->caller_user_id) ?> <strong>called</strong> <?= fetch_player_call_rank($row->call_id,$row->callee_user_id,1) ?>.<?= fetch_player_name($row->callee_user_id)  
                //	<span class="btn cancelCallByAdmin" style="display:none; color:#FF0000;" title="Akyrwsi tou call" value=" $row->call_id ">x</span> ?>
                </td>
                <td  align="center">
                <?php
                if ($row->match_date=='0000-00-00'){
                ?>
                <a href="schedule.php?call=<?= $row->call_id ?>" style="color:transparent;"><button class="button" id="insertDateBtn" style="width:190px; margin:0;">Εισαγωγή ημερομηνίας</button></a>     
                <?php
                }
                else{
                ?>
                <button class="button submitMatchScore tip" id="insertScoreBtn" rel="<?= $row->call_id ?>" style="width:190px; margin:0;">Εισαγωγή αποτελέσματος</button>      
                <?php
                }
                ?>
                </td>
                <td  align="center">
        <?php 	if($row->match_points_won!=0){ 
                    echo $row->match_points_won; 
                }
                else{
                    echo fetch_points_by_callid($row->caller_user_id,$row->callee_user_id,$row->caller_user_id,$row->call_id)." or ".fetch_points_by_callid($row->caller_user_id,$row->callee_user_id,$row->callee_user_id,$row->call_id); 
                }
                ?></td>   
                <td  align="center"><?php 
                if($row->match_date!='0000-00-00'){ ?>
                    <span style="color:#000000"><?= changeDate($row->match_date) ?></span>
    <?php		}
                else{ ?> 
                    <span style="color:#FF0000"><?= changeDate($row->call_date) ?></span>			 
    <?php		}	
                ?></td>
            </tr> 
    
    <?php		
            $i++;
            }
            if (!$i)
                    echo "<tr class='row1'><td colspan='4'>Δεν έχετε εκκρεμότητες</td></tr>";
    ?>
    </table>
        </td>
      </tr>
      
      
      <tr>
        <td colspan="2"><h2 style="border-bottom:0px solid;">Αποτελέσματα προσκλήσεων</h2></td>
      </tr>
      <tr>
         <td colspan="2">
            <table width="860" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
                <button id="promptForParticipants" type="button" class="button" style="display:inline; padding:0px; margin:0 0 1px 6px; vertical-align:bottom;"><img src="img/user-plus.png"/>Επιλέξτε</button>
                <input type="text" class="textbox" id="playerselection_visible" style="margin-bottom:1px; height:17px;" value="Όλοι οι παίκτες" /><button class="textbox" id="clearSearch" style="cursor:pointer; visibility:hidden;">X</button>
                <input type="hidden" class="textbox" id="playerselection" style="margin-bottom:1px" value="-1" />
                <script type="text/javascript">
                  $('#clearSearch').click(function(){
                     $(this).css('visibility','hidden');
                     $('#playerselection_visible').val('');
                     $('#playerselection_visible').change();
                  });
                  $('#playerselection_visible').click(function(){
                    if($(this).val()!='Όλοι οι παίκτες'){
                      $(this).select();
                    }
                    else{
                      $(this).val('');
                    }
                  }).blur(function(){
                    if($(this).val()==''){
                      $(this).val('Όλοι οι παίκτες');
                      $('#playerselection').val(-1);
                    }
                  });
                  
                  $('#playerselection_visible').userAutoComplete('ajax/autocomplete.php?type=user&oneAceGame=true', function(ui) {
                    $('#playerselection').val(ui.item.value);
                    $('#clearSearch').css('visibility','visible');
                    $('#matchtypeselection').change();
                  });
                  $('#playerselection_visible').change(function(){
                    if($(this).val()==''){
                      $(this).val('Όλοι οι παίκτες');
                      $('#playerselection').val(-1);
                      $('#clearSearch').css('visibility','hidden');
                      $('#matchtypeselection').change();
                    }
                  });
									
									//////////
									var participation = {};
									participation.addedUsers = [];
									
									var elements = {
										participantDialogPrompt: $('#promptForParticipants'),
										participantDialog: $('#participantDialog'),
										participantList: $('#participantList'),
										participantAutocomplete: $('#participantAutocomplete'),
								
										changeUserAutocomplete: $('#changeUserAutocomplete'),
										userName: $('#userName'),
										userId: $('#userId'),
									};
									$('#promptForParticipants').click(function() {
										participation.showAllUsersToAdd(elements.participantDialog);
									});
									participation.showAllUsersToAdd = function(dialogElement) {
										var allUserList;
										if (allUserList == null) {
											$.ajax({
												url: 'ajax/autocomplete.php?type=user&oneAceGame=true',
												dataType: 'json',
												async: false,
												success: function(data) {
													allUserList = data;
												}
											});
								
											var items = [];
											$.map(allUserList, function(item) {
												items.push('<li><a href="#" class="add" onclick="javascript: addPlayerToSearch($(this));" title="Add"><input type="hidden" class="id" value="' + item.Id + '" name="' + item.Name + '" />' +
														'<img src="img/plus-button.png" /></a> ' +
														item.Name + '</li>')
											});
											
										}
										dialogElement.empty();
								
										$('<ul/>', {'class': 'no-style', html: items.join('')}).appendTo(dialogElement);
								
										$('#participantDialog').dialog();
										
									};
									function addPlayerToSearch($elem){
										$('#playerselection_visible').val($elem.children('.id').attr('name'));
										$('#playerselection').val($elem.children('.id').val());
										$('#clearSearch').css('visibility','visible');
										$('#matchtypeselection').change();
										$('#participantDialog').dialog('close');
									}
                </script>
                </td>
                <td>
                    <select id="matchtypeselection">
                        <option value="all">Όλοι οι αγώνες</option>
                        <option value="-1">Ακυρωμένοι αγώνες</option>
                        <option value="0">Εκκρεμείς προσκλήσεις</option>
		    	 		<option value="2">Δεν έχουν οριστεί</option>
                        <option value="1">Προγραμματισμένοι αγώνες</option>
                        <option value="3">Ολοκληρωμένοι αγώνες</option>
                    </select>
                </td>
              </tr>
            </table>
        </td>
      </tr>
      <tr height="5">
        <td></td>
      </tr>
      <tr>
        <td id="allCallsOuter" colspan="2" align="center"><div><img src="img/admin-ajax-indicator.gif" /></div></td>
      </tr>
    </table>
    <?php
		$tmpres=mysql_query("select numAGFreeDecl from r_options");
		$tmprow=mysql_fetch_object($tmpres);
		$numofmatchesforfreedecl=$tmprow->numAGFreeDecl;
		?>
    <div id="declineCallMessage" style="display:none">
    	<div><img src="img/alert.png"  /></div>
    	<div>Είστε σίγουροι ότι θέλετε να απορρίψετε την συγκεκριμένη πρόσκληση; <br/>Σε περίπτωση που δεν έχετε ήδη προγραμματισμένα παιχνίδια (<?php echo $numofmatchesforfreedecl ?>) θα πάρετε ποινή!</div>
        <div><button class="button declineHim">Αποδοχή</button><button class="button cancelDecline">Ακύρωση</button></div>
    </div>
    <script type="text/javascript">
    $(document).ready(function(){
        <?php 
        if(isset($_GET['sex'])){
            echo "$('#allCallsOuter').load('fetchAllCalls.php',{calltype: $('#matchtypeselection').val(),sex: '".$_GET['sex']."'});";
            
        }
        else{
            echo "$('#allCallsOuter').load('fetchAllCalls.php',{calltype: $('#matchtypeselection').val(),sex: 'male'});";
        }
        ?>
        
        $('#plrnumselection').change(function(){
            if ($(this).val()==1)
                $('#autocompletenames').show();
            else
                $('#autocompletenames').hide();
        //	$('#callsTableArea').html('mpike');
        });
        $('#matchtypeselection').change(function(){
            fetchThem();
        });
        $('#chooseSex').change(function(){
            var old_url=window.location.href;
            var new_url = old_url.substring(0, old_url.indexOf('?'));
            if (new_url=='')
                new_url=old_url;
            window.location.href=new_url+"?sex="+$('#chooseSex').val();
        });
       function fetchThem(){
            var wntid=$('#playerselection').val();
            var calltype=$('#matchtypeselection').val();
            $('#allCallsOuter').load("fetchAllCalls.php",{plrid: wntid, calltype: calltype, sex: $('#chooseSex').val()});
        }/*
        $('#blockBtn').click(function(){
            if ($('#datepicker').val()==''){
                alert('Parakalw dwste imerominia');
                return;
            }		
            $.ajax({
              type: "POST",
              url: "inc/calls.php",
              data: { blocking: "ok", date:  $('#datepicker').val()}
            }).done(function( msg ) {
                var old_url=window.location.href;
                var new_url = old_url.substring(0, old_url.indexOf('&'));
                if (new_url=='')
                    new_url=old_url;
                window.location.href=new_url;
            });
            return false;
        });	
        $('#unblockBtn').click(function(){
            $.ajax({
              type: "POST",
              url: "inc/calls.php",
              data: { unblocking: "ok"}
            }).done(function( msg ) {
                var old_url=window.location.href;
                var new_url = old_url.substring(0, old_url.indexOf('&'));
                if (new_url=='')
                    new_url=old_url;
                window.location.href=new_url;
            });
            return false;
        });
        $('#updateblockBtn').click(function(){
            $.ajax({
              type: "POST",
              url: "inc/calls.php",
              data: { updateblock: "ok", updateblockdate:  $('#datepicker').val()}
            }).done(function( msg ) {
            //  alert( msg );
            });
            return false;
        });*/
        $('.accept_call').one('click',function(){
			var parent=$(this).parent();
			parent.html('<div style="width: 60px;"><img height="16" src="img/admin-ajax-indicator.gif" /></div>');
            $.ajax({
              type: "POST",
              url: "calls.php",
              data: { acceptCall: "ok", callid:  $(this).attr('value')}
            }).done(function( msg ) {
                if ($(".success")[0]){
				   // Do something here if class exists
					$('.success').remove();
					$('#content').prepend('<div class="success" style="" id="profileUpdatedMessage">Αποδεχτήκατε την πρόσκληση με επιτυχία.</div>');
				}
				else{
					$('#content').prepend('<div class="success" style="" id="profileUpdatedMessage">Αποδεχτήκατε την πρόσκληση με επιτυχία.</div>');
				}
				$.ajax({
				type: "POST",
				url: "calls.php",
				data: { ajaxize: "true"}
				}).done(function( data ) {
					$('.callsDiv').html(data);
				});
            });
            return false;
        });
        $('.decline_call').click(function(){
			$('.declineHim').attr('value',$(this).attr('value'));
			$("#declineCallMessage").dialog("open");	
        });	
        
        function fetchContent(){
            return $('.submitMatchScore').html();
        }
        
        $('.submitMatchScore').each(function(){
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
                url: "updateScoreFields.php",
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
		$("#declineCallMessage").dialog({
			autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
			minHeight: 400, minWidth: 700, width: 700,
			open: function(event, ui) {
				$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
			}
			
		});
		$('.declineHim').one('click',function(){
			$.ajax({
              type: "POST",
              url: "calls.php",
              data: { declineCall: "ok", callid:  $(this).attr('value')}
            }).done(function( msg ) {
				window.location.reload();
            });
            return false;
		});
		$('.cancelDecline').click(function(){
			 $("#declineCallMessage").dialog("close");
		});
    });
    </script>
</div>