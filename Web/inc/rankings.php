<script type="text/javascript" src="scripts/autocomplete.js"></script>
<div id="participantDialog" title="Επιλογή παίκτη" class="dialog"></div>
<?php
@include_once('../config.php');	
@include_once('config.php');	
@include_once('../functions.php');
@include_once('functions.php');

if(isset($_POST['ajaxize'])){
	if (isset($_POST['sex'])){
		if($_POST['sex']=='male'){
			$res=mysql_query("select * from r_rankings order by rank_pos asc");
		}
		else{
			$res=mysql_query("select * from r_rankings_women order by rank_pos asc");
		}
	}
	else{
		$res=mysql_query("select * from r_rankings order by rank_pos asc");
	}
	?>
    <table class="list userList" width="880" style="min-width: 575px;">       
         <tr align="center">
            <th width="51">Θέση</th>
            <th>
            <?php
			if($userSession->IsAdmin==1){
			?>
            Παίκτες
            	<div id="addToRankings" title="Eisagwgi neou paikti sto Ranking" style="vertical-align: middle;"><img src="img/plus-button.png" /></div>
                <div class="chPlrToAddClass" id="chPlrToAdd">
                		<button id="promptForParticipants" type="button" class="button" style="display:inline; padding:0px; margin:0 0px 1px 6px; vertical-align:bottom;"><img src="img/user-plus.png"/>Επιλέξτε</button>  
                    <input type="text" class="textbox" id="choosenPlrToAdd_visible" style="margin-bottom:1px; height:17px;" Placeholder="Αναζήτηση" /><button class="textbox" id="clearSearch" style="cursor:pointer; visibility:hidden;">X</button>
                    <input type="hidden" class="textbox" id="choosenPlrToAdd" style="margin-bottom:1px" value="0" />
                    <script type="text/javascript">
                      $('#clearSearch').click(function(){
                         $(this).css('visibility','hidden');
                         $('#choosenPlrToAdd_visible').val('');
                         $('#choosenPlrToAdd_visible').change();
                      });
                      $('#choosenPlrToAdd_visible').click(function(){
                        if($(this).val()!=''){
                          $(this).select();
                        }
                      });
                      
                      $('#choosenPlrToAdd_visible').userAutoComplete('ajax/autocomplete.php?type=user&ranking=true', function(ui) {
                        $('#choosenPlrToAdd').val(ui.item.value);
                        $('#clearSearch').css('visibility','visible');
                      });
                      $('#choosenPlrToAdd_visible').change(function(){
                        if($(this).val()==''){
                          $('#choosenPlrToAdd').val(0);
                          $('#clearSearch').css('visibility','hidden');
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
														url: 'ajax/autocomplete.php?type=user&ranking=true',
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
												$('#choosenPlrToAdd_visible').val($elem.children('.id').attr('name'));
												$('#choosenPlrToAdd').val($elem.children('.id').val());
												$('#clearSearch').css('visibility','visible');
												$('#choosenPlrToAdd_visible').change();
												$('#participantDialog').dialog('close');
											}
                    </script>
                    
                </div>
                <div class="chPlrToAddClass" id="chPlrToAddBtndiv"><button id="chPlrToAddBtn" class="button" style="width:150px; vertical-align:middle;">Προσθήκη παίκτη στο ranking</button></div>
            <?php
			}
			else{
			?>
            Παίκτες
            <?php
			}
			?>
            </th>
            <th width="51">Πόντοι</th>
            <th width="171">Επιλογές</th>
         </tr>
<?php  
		$i=2;
		while ($row=mysql_fetch_object($res)){?>
        <tr align="center" class="row<?= $i%2 ?>">
        		<?php
						$newres=mysql_query("select last_rank from  player_rank_details where user_id=$row->rank_user_id");
						$newrow=mysql_fetch_object($newres);
						
						$position_difference=$newrow->last_rank-$row->rank_pos;
						if(!$newrow || $newrow->last_rank==0 || $position_difference==0){
							$position_difference='';
						}
						else if($position_difference>0){
							$position_difference='<span style="color: #47B247">(+'.$position_difference.')</span>';
						}
						else{
							$position_difference='<span style="color: #FF4747">('.$position_difference.')</span>';
						}
						if($newrow->last_rank==0){
						//	$position_difference='<span style="color: #47B247">edww</span>';
						}
						?>
            <td>
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="45%" align="right" style="padding:0; border:none;"><?= $row->rank_pos ?></td>
                  <td width="55%" align="right" style="padding:0; border:none;"><?php echo $position_difference; ?></td>
                </tr>
              </table>
            </td>
            <td >
             <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td style="border: 0px solid;" class="<?php if ($userid!=$row->rank_user_id && canBeCalled($userid,$row->rank_user_id)) echo "user btn"; ?>" align="left" userid="<?= $row->rank_user_id ?>"><?php
					$res1=mysql_query("select fname,lname from users where user_id=$row->rank_user_id");
					$res1=mysql_fetch_object($res1);
					echo $res1->fname." ".$res1->lname;
            	 ?></td>
                <?php
					if (!isBlocked($row->rank_user_id)){
						if($userSession->IsAdmin==1){
							?>
                            <td style="border: 0px solid; color:#F47D3D ;" width="42"><div class="btn inline blockPlr"  userid="<?= $row->rank_user_id ?>" title="Μπλοκάρισμα παίκτη">block</div></td>
                            <?php
						}
					}
					else{
						if($userSession->IsAdmin==1){
							?>
                            <td style="border: 0px solid; color:#F47D3D ;" width="42"><div class="btn inline unblockPlr"  userid="<?= $row->rank_user_id ?>" title="Ξεμπλοκάρισμα παίκτη">unblock</div></td>
                            <script type="text/javascript">
								$('td[userid="<?= $row->rank_user_id ?>"]').css('color','#F47D3D ');
							</script>
                       	 	<?php
						}
						else{
							?>
							<td style="border: 0px solid; color:#F47D3D ;" width="42"><div class="inline" style="cursor:default;" title="Ο παίκτης είναι μπλοκαρισμένος και δεν μπορεί προς το παρών να προσκαλεστεί">BLOCKED</div></td>
                            <script type="text/javascript">
								$('td[userid="<?= $row->rank_user_id ?>"]').css('color','#F47D3D ');
							</script>
                            <?php
						}
					}
					if (!isInjured($row->rank_user_id)){
						if($userSession->IsAdmin==1){
							?>
                            <td style="border: 0px solid; color:#3375a9;" width="42"><div class="btn inline injury" userid="<?= $row->rank_user_id ?>" title="Ορισμός ως τραυματίας">injury</div></td>
                            <?php
						}
					}
					else{
						if($userSession->IsAdmin==1){
							?>
                            <td style="border: 0px solid; color:#3375a9;" width="42"><div class="btn inline uninjury" userid="<?= $row->rank_user_id ?>" title="Αφαίρεση ορισμού ως τραυματίας">injured</div></td>
                            <script type="text/javascript">
								$('td[userid="<?= $row->rank_user_id ?>"]').css('color','#3375a9');
							</script>
                            <?php
						}
						else{
							?>
							<td style="border: 0px solid; color:#3375a9;" width="42"><div class="inline" style="cursor:default;" title="Ο παίκτης είναι τραυματίας και δεν μπορεί προς το παρών να προσκαλεστεί" >INJURED</div></td>
                            <script type="text/javascript">
								$('td[userid="<?= $row->rank_user_id ?>"]').css('color','#3375a9');
							</script>
                            <?php
						}
					}
					if($userSession->IsAdmin==1){
						?>
						<td style="border: 0px solid; color:#FF0000;" width="42"><div class="btn inline removePlr" userid="<?= $row->rank_user_id ?>" title="Αφαίρεση του παίκτη απο την κατάταξη!!!">remove</div></td>
						<?php
					}
				?>
        				<td style="border: 0px solid; padding:0px; width:20px;"><img class="profile_base sticky_tip" rel="get_profile.php?userid=<?= $row->rank_user_id ?>" src="img/user_default_0_mini.png" style="vertical-align:middle; cursor:pointer;" /></td>
              </tr>
            </table>
             </td>
            <td ><?= $row->rank_tot_points ?></td>
            <td >	
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td style="border: 0px solid;" width="33%" align="center" id="showLast5Matches"><div title="Τελευταίοι 5 αγώνες" class="tip inline" rel="last5matches.php?user=<?= $row->rank_user_id ?>" >L5M</div></td>
                    <td style="border: 0px solid;" width="33%" align="center" id="showPlrStats"><div title="Στατιστικά παίκτη" class="tip inline" rel="stats.php?user=<?= $row->rank_user_id ?>" >STATS</div></td>
                    <td style="border: 0px solid;" width="33%" align="center" id="showLastTourPos"><div title="Θέση στο τελευταίο τουρνουά" class="tip inline" rel="lastTourPos.php?user=<?= $row->rank_user_id ?>" >LTP</div></td>
                  </tr>
                </table>
            </td>
        </tr>
        	<?php
        	$i++;
 	} ?>
    </table> 
    <style type="text/css">
		.profile_base:hover{
			outline:1px solid #ccc;
		}
		</style>
<script type="text/javascript">
$(document).ready(function(){

	$('#addToRankings').unbind();
	$('#addToRankings').click(function(){
		$('.chPlrToAddClass').each(function(){
			$(this).css('display','inline-block');
		});
		$(this).hide();
	});
	
	$('#chPlrToAddBtn').unbind();
	$('#chPlrToAddBtn').click(function(){
		if($('#choosenPlrToAdd').val()!='' && $('#choosenPlrToAdd').val()!=0){
			$(this).unbind('click');
		}
		else{
			return;
		}
		$.ajax({
		  type: "POST",
		  url: "rankingSystem.php",
		  data: { addplr: $('#choosenPlrToAdd').val(), rankType: $('#chooseRanking').val()}
		}).done(function( msg ) {
			var playername = $('#choosenPlrToAdd_visible').val();
			if ($(".success")[0]){
			   // Do something here if class exists
			   $('.success').remove();
			   $('#content').prepend('<div class="success" style="" id="profileUpdatedMessage">Εισάγατε επιτυχώς τον χρήστη '+playername+' στην κατάταξη</div>');
			}
			else{
				$('#content').prepend('<div class="success" style="" id="profileUpdatedMessage">Εισάγατε επιτυχώς τον χρήστη '+playername+' στην κατάταξη</div>');
			}
			$('.rankingDiv').html('<img href="img/admin-ajax-indicator.gif" />');
			//$('#rankingDiv').load('rankingSystem.php',{ ajaxize: "true", sex: $('#chooseRanking').val()});
			$.ajax({
			type: "POST",
			url: "rankingSystem.php",
			data: { ajaxize: "true", sex: $('#chooseRanking').val()}
			}).done(function( data ) {
				$('.rankingDiv').html(data);
			});
		});
	});
	
	$('.blockPlr').unbind();
	$('.blockPlr').click(function(){
		$('#blockMessage').attr('which',$(this).attr('userid'));
		$("#blockMessage").dialog("open");		
	});
	
	$('.unblockPlr').unbind();
	$('.unblockPlr').click(function(){
		$('#unBlockMessage').attr('which',$(this).attr('userid'));
		$("#unBlockMessage").dialog("open");		
	});
	/*$('.removePlr').click(function(){
		var con=confirm('Αφαίρεση του χρήστη από την κατάταξη;');
		if (!con)
			return false;
		$.ajax({
		  type: "POST",
		  url: "rankingSystem.php",
		  data: { removePlr: "ok", plrid:  $(this).attr('userid')}
		}).done(function( msg ) {
			window.location.reload();
		});
	});*/
	
	$('.injury').unbind();
	$('.injury').click(function(){
		$('#injureMessage').attr('which',$(this).attr('userid'));
		$("#injureMessage").dialog("open");
	});
	
	$('.uninjury').unbind();
	$('.uninjury').click(function(){
		$('#uninjureMessage').attr('which',$(this).attr('userid'));
		$("#uninjureMessage").dialog("open");
	});

	if ($('#choosenPlrToAdd').val()==-1){
		$('#chPlrToAddBtn').hide();
	}
	
	$('.removePlr').unbind();
	$('.removePlr').click(function(){
		$('#removeMessage').attr('which',$(this).attr('userid'));
		$("#removeMessage").dialog("open");
	});
	
	$('#chooseRanking').unbind();
	$('#chooseRanking').change(function(){
		var old_url=window.location.href;
		var new_url = old_url.substring(0, old_url.indexOf('?'));
		if (new_url=='')
			new_url=old_url;
		new_url+="?sex="+$(this).val();
		window.location.href=new_url;
	});
	
	//$('.user').unbind();
	$('.user').click(function(){
		$('#callPlayerMessage').attr('plrname',$(this).html());
		$('#callPlayerMessage').attr('userid',$(this).attr('userid'));
		$("#callPlayerMessage").dialog("open");
		
		/*var con=confirm('Κλήση του παίκτη '+$(this).html()+' για αγώνα;');
		if(con){
		  $.post("getCalls.php",
		  {
			caller:userid,
			callee:$(this).attr('userid')
		  },
		  function(data,status){	
		  	var old_url=window.location.href;
			var new_url = old_url.substring(0, old_url.indexOf('?'));
			if (new_url=='')
				new_url=old_url;
			window.location.href=new_url;
		  });
		}*/
		//alert($(this).attr('userid'));						  
	});
	
	$('.tip').unbind();
	$('.tip').each(function(){
		$(this).qtip({
			
			position: {
			my: 'middle right',
			at: 'middle left',
			target: $(this),
			effect: false
			},
			style: { 
	      		classes: 'myCustomStyle'
	  		},
			content: {
			text: 'Loading...',
			ajax: {
			url: $(this).attr('rel'),
			type: 'GET',
			dataType: 'html'
			}
			},
			show: {
			event: 'mouseover'
			}
				
		}); 
	});
	$('.sticky_tip').each(function(){
		$(this).qtip({
			
			position: {
			my: 'bottom right',
			at: 'bottom left',
			target: $(this),
			effect: false
			},
			style: { 
	      		classes: 'myCustomStyle'
	  		},
			content: {
			text: 'Loading...',
			ajax: {
			url: $(this).attr('rel'),
			type: 'GET',
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
									return false;
							 });
							// Tell the document itself when clicked to hide the tip and then unbind
							// the click event (the .one() method does the auto-unbinding after one time)
							$(document).one("click", function() { trigger.qtip('hide'); });
					}
			}
		}); 
	});
	$('#blockMessage').unbind();
	$("#blockMessage").dialog({
      	autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
		minHeight: 400, minWidth: 700, width: 700,
		open: function(event, ui) {
			$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
		}
		
    });
	
	$('#unBlockMessage').unbind();
	$("#unBlockMessage").dialog({
      	autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
		minHeight: 400, minWidth: 700, width: 700,
		open: function(event, ui) {
			$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
		}
    });
	
	$('#injureMessage').unbind();
	$("#injureMessage").dialog({
      	autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
		minHeight: 400, minWidth: 700, width: 700,
		open: function(event, ui) {
			$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
		}
    });
	
	$('#uninjureMessage').unbind();
	$("#uninjureMessage").dialog({
      	autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
		minHeight: 400, minWidth: 700, width: 700,
		open: function(event, ui) {
			$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
		}
    });
	
	$('#removeMessage').unbind();
	$("#removeMessage").dialog({
      	autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
		minHeight: 400, minWidth: 700, width: 700,
		open: function(event, ui) {
			$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
		}
    });
	
	$('#callPlayerMessage').unbind();
	$("#callPlayerMessage").dialog({
      	autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
		minHeight: 400, minWidth: 700, width: 700,
		open: function(event, ui) {
			$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
		}
    });
	
	$('.blockHim').unbind();
	$('.blockHim').click(function(){
		$.ajax({
		type: "POST",
		url: "rankingSystem.php",
		data: { blockPlr: "ok", plrid:  $('#blockMessage').attr('which')}
		}).done(function( msg ) {
			window.location.reload();
		});
	});
	
	$('.cancelBlock').unbind();
	$('.cancelBlock').click(function(){
		 $("#blockMessage").dialog("close");
	});
	
	$('.unBlockHim').unbind();
	$('.unBlockHim').click(function(){
		$.ajax({
		type: "POST",
		url: "rankingSystem.php",
		data: { unblockPlr: "ok", plrid:  $('#unBlockMessage').attr('which')}
		}).done(function( msg ) {
			window.location.reload();
		});
	});
	
	$('.cancelUnBlock').unbind();
	$('.cancelUnBlock').click(function(){
		 $("#unBlockMessage").dialog("close");
	});
	
	$('#injureHim').unbind();
	$('#injureHim').click(function(){
		$.ajax({
		type: "POST",
		url: "rankingSystem.php",
		data: { injury: "ok", plrid:  $('#injureMessage').attr('which')}
		}).done(function( msg ) {
			window.location.reload();
		});
	});
	
	$('#cancelInjury').unbind();
	$('#cancelInjury').click(function(){
		 $("#injureMessage").dialog("close");
	});
	
	$('#uninjureHim').unbind();
	$('#uninjureHim').click(function(){
		$.ajax({
		type: "POST",
		url: "rankingSystem.php",
		data: { injury: "ok", plrid:  $('#uninjureMessage').attr('which')}
		}).done(function( msg ) {
			window.location.reload();
		});
	});
	
	$('#cancelunInjury').unbind();
	$('#cancelunInjury').click(function(){
		 $("#uninjureMessage").dialog("close");
	});
	
	$('.removeHim').unbind();
	$('.removeHim').click(function(){
		$.ajax({
		type: "POST",
		url: "rankingSystem.php",
		data: { removePlr: "ok", plrid:  $('#removeMessage').attr('which')}
		}).done(function( msg ) {
			window.location.reload();
		});
	});
	
	$('.cancelRemove').unbind();
	$('.cancelRemove').click(function(){
		 $("#removeMessage").dialog("close");
	});
	
	//$('.callHim').unbind();
	$('.callHim').off().one('click',function(){
		$('#callPlayerMessage').html('<div style="position: relative; top: 170px; display: block;" id="creatingNotification">Δημιουργία πρόσκλησης...<br><img alt="Creating reservation" src="img/reservation_submitting.gif"></div>');
		$.post("getCalls.php",
		  {
			caller:userid,
			callee:$('#callPlayerMessage').attr('userid')
		  },
		  function(data,status){	
		  	var old_url=window.location.href;
			var new_url = old_url.substring(0, old_url.indexOf('?'));
			if (new_url=='')
				new_url=old_url;
			window.location.href=new_url;
		  });
	});
	$('.cancelCall').unbind();
	$('.cancelCall').click(function(){
		 $("#callPlayerMessage").dialog("close");
	});
});
</script>
	<?php
	exit();
}
if (isset($_POST['blockPlr'])){
	mysql_query("insert into r_user_blocks values(".$_POST['plrid'].",null)");
	echo "Ο παίκτης έχει μπλοκαριστεί με επιτυχία!";
	exit;
}
if (isset($_POST['unblockPlr'])){
	mysql_query("delete from r_user_blocks where user_id=".$_POST['plrid']."");
	echo "Ο παίκτης έχει ξεμπλοκαριστεί με επιτυχία!";
	exit;
}
if (isset($_POST['removePlr'])){
	mysql_query("delete from r_rankings where rank_user_id=".$_POST['plrid']);
	mysql_query("delete from r_rankings_women where rank_user_id=".$_POST['plrid']);
	sortRankings();
	echo "Η διαγραφή έγινε με επιτυχία!";
	exit;
}
if (isset($_POST['injury'])){
	if (!isInjured($_POST['plrid']))
		mysql_query("insert into r_injuries values(".$_POST['plrid'].")");
	else
		mysql_query("delete from r_injuries where user_id=".$_POST['plrid']);
	exit;
}
if (isset($_POST['addplr'])){
	if ($_POST['rankType']=='male'){
		$table="r_rankings";
		$sex=0;
	}
	else{
		$table="r_rankings_women";
		$sex=1;
	}
	$res=mysql_query("select * from $table where 1 limit 1");
	if($res=mysql_fetch_object($res)){
		$res=mysql_query("select max(rank_pos) as maxpos,min(rank_tot_points) as minpoints from $table");
		$res=mysql_fetch_object($res);
		if ($res->minpoints==0)
			$lastpos=$res->maxpos;
		else
			$lastpos=$res->maxpos+1;
		$res=mysql_query("select * from $table where rank_user_id=".$_POST['addplr']);
		if (mysql_num_rows($res)==0)
			$res=mysql_query("insert into $table values(null,$lastpos,".$_POST['addplr'].",0)");
	}
	else{
		$res=mysql_query("insert into $table values(1,0,".$_POST['addplr'].",0)");
	}
	
	$res=mysql_query("select * from r_tours_participants where user_id=".$_POST['addplr']." and countedToRank=1 and sex=$sex");
	while($row=mysql_fetch_object($res)){
		$res2=mysql_query("select pos_points from r_tours_positions where position_id=$row->position_id");
		$row2=mysql_fetch_object($res2);
		mysql_query("update $table set rank_tot_points=rank_tot_points+$row2->pos_points where rank_user_id=".$_POST['addplr']."");
	}
	sortRankings();
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" margin-bottom:60px">
  <tr>
    <td width="200"><h1>Κατάταξη</h1></td>
    <td>
    	<h1 style="padding-top: 23px;">
        	<select id="chooseRanking" class="textbox" style="margin-bottom:1px">
            	<option value="male">Ανδρών</option>
            	<option <?php if(isset($_GET['sex']) && $_GET['sex']=="female") echo "selected='selected'"; ?> value="female">Γυναικών</option>
        	</select>	
    	</h1>
    </td>
  </tr>
</table>
<link rel="stylesheet" type="text/css" href="css/admin.css">
<link rel="stylesheet" type="text/css" href="inc/styles.css">
<link rel="stylesheet" type="text/css" href="css/jquery.qtip.min.css">
<script type="text/javascript" src="scripts/js/jquery.qtip.min.js" ></script>
<script type="text/javascript">
	var userid=<?= $userid ?>;
</script>
<?php
function isBlocked($plrid){
	$res=mysql_query("select * from r_user_blocks where user_id=$plrid");
	if (mysql_num_rows($res)==0){
		return 0;
	}
	return 1;
}
if (isset($_GET['sex'])){
	if($_GET['sex']=='male'){
		$res=mysql_query("select * from r_rankings order by rank_pos asc");
		$sex="male";
	}
	else{
		$res=mysql_query("select * from r_rankings_women order by rank_pos asc");
		$sex="female";
	}
}
else{
	$res=mysql_query("select * from r_rankings order by rank_pos asc");
	$sex="male";
}
?>
<div class="rankingDiv">
    <table class="list userList" width="880" style="min-width: 575px;">       
         <tr align="center">
            <th width="51">Θέση</th>
            <th>
            <?php
			if($userSession->IsAdmin==1){
			?>
            Παίκτες
            	<div id="addToRankings" title="Eisagwgi neou paikti sto Ranking" style="vertical-align: middle;"><img src="img/plus-button.png" /></div>
                <div class="chPlrToAddClass" id="chPlrToAdd">  
		                <button id="promptForParticipants" type="button" class="button" style="display:inline; padding:0px; margin:0 0px 1px 6px; vertical-align:bottom;"><img src="img/user-plus.png"/>Επιλέξτε</button>
                    <input type="text" class="textbox" id="choosenPlrToAdd_visible" style="margin-bottom:1px; height:17px;" Placeholder="Αναζήτηση" /><button class="textbox" id="clearSearch" style="cursor:pointer; visibility:hidden;">X</button>
                    <input type="hidden" class="textbox" id="choosenPlrToAdd" style="margin-bottom:1px" value="0" />
                    <script type="text/javascript">
                      $('#clearSearch').click(function(){
                         $(this).css('visibility','hidden');
                         $('#choosenPlrToAdd_visible').val('');
                         $('#choosenPlrToAdd_visible').change();
                      });
                      $('#choosenPlrToAdd_visible').click(function(){
                        if($(this).val()!=''){
                          $(this).select();
                        }
                      });
                      
                      $('#choosenPlrToAdd_visible').userAutoComplete('ajax/autocomplete.php?type=user&ranking=true', function(ui) {
                        $('#choosenPlrToAdd').val(ui.item.value);
                        $('#clearSearch').css('visibility','visible');
                      });
                      $('#choosenPlrToAdd_visible').change(function(){
                        if($(this).val()==''){
                          $('#choosenPlrToAdd').val(0);
                          $('#clearSearch').css('visibility','hidden');
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
														url: 'ajax/autocomplete.php?type=user&ranking=true',
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
												$('#choosenPlrToAdd_visible').val($elem.children('.id').attr('name'));
												$('#choosenPlrToAdd').val($elem.children('.id').val());
												$('#clearSearch').css('visibility','visible');
												$('#choosenPlrToAdd_visible').change();
												$('#participantDialog').dialog('close');
											}
                    </script>
                    
                </div>
                <div class="chPlrToAddClass" id="chPlrToAddBtndiv"><button id="chPlrToAddBtn" class="button" style="width:150px; vertical-align:middle;">Προσθήκη παίκτη στο ranking</button></div>
            <?php
			}
			else{
			?>
            Παίκτες
            <?php
			}
			?>
            </th>
            <th width="51">Πόντοι</th>
            <th width="171">Επιλογές</th>
         </tr>
<?php  
		$i=2;
		while ($row=mysql_fetch_object($res)){?>
        <tr align="center" class="row<?= $i%2 ?>">
        		<?php
						$newres=mysql_query("select last_rank from  player_rank_details where user_id=$row->rank_user_id");
						$newrow=mysql_fetch_object($newres);
						
						$position_difference=$newrow->last_rank-$row->rank_pos;
						if(!$newrow || $newrow->last_rank==0 || $position_difference==0){
							$position_difference='';
						}
						else if($position_difference>0){
							$position_difference='<span style="color: #47B247">(+'.$position_difference.')</span>';
						}
						else{
							$position_difference='<span style="color: #FF4747">('.$position_difference.')</span>';
						}
						if($newrow->last_rank==0){
						//	$position_difference='<span style="color: #47B247">edww</span>';
						}
						?>
            <td>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="45%" align="right" style="padding:0; border:none;"><?= $row->rank_pos ?></td>
                  <td width="55%" align="right" style="padding:0; border:none;"><?php echo $position_difference; ?></td>
                </tr>
              </table>
						</td>
            <td >
             <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td style="border: 0px solid;" class="<?php if ($userid!=$row->rank_user_id && canBeCalled($userid,$row->rank_user_id)) echo "user btn"; ?>" align="left" sex="<?= $sex ?>" userid="<?= $row->rank_user_id ?>"><?php
					$res1=mysql_query("select fname,lname from users where user_id=$row->rank_user_id");
					$res1=mysql_fetch_object($res1);
					echo $res1->fname." ".$res1->lname;
            	 ?></td>
                <?php
					if (!isBlocked($row->rank_user_id)){
						if($userSession->IsAdmin==1){
							?>
                            <td style="border: 0px solid; color:#F47D3D ;" width="42"><div class="btn inline blockPlr"  userid="<?= $row->rank_user_id ?>" title="Μπλοκάρισμα παίκτη">block</div></td>
                            <?php
						}
					}
					else{
						if($userSession->IsAdmin==1){
							?>
                            <td style="border: 0px solid; color:#F47D3D ;" width="42"><div class="btn inline unblockPlr"  userid="<?= $row->rank_user_id ?>" title="Ξεμπλοκάρισμα παίκτη">unblock</div></td>
                            <script type="text/javascript">
								$('td[userid="<?= $row->rank_user_id ?>"]').css('color','#F47D3D ');
							</script>
                       	 	<?php
						}
						else{
							?>
							<td style="border: 0px solid; color:#F47D3D ;" width="42"><div class="inline" style="cursor:default;" title="Ο παίκτης είναι μπλοκαρισμένος και δεν μπορεί προς το παρών να προσκαλεστεί">BLOCKED</div></td>
                            <script type="text/javascript">
								$('td[userid="<?= $row->rank_user_id ?>"]').css('color','#F47D3D ');
							</script>
                            <?php
						}
					}
					if (!isInjured($row->rank_user_id)){
						if($userSession->IsAdmin==1){
							?>
                            <td style="border: 0px solid; color:#3375a9;" width="42"><div class="btn inline injury" userid="<?= $row->rank_user_id ?>" title="Ορισμός ως τραυματίας">injury</div></td>
                            <?php
						}
					}
					else{
						if($userSession->IsAdmin==1){
							?>
                            <td style="border: 0px solid; color:#3375a9;" width="42"><div class="btn inline uninjury" userid="<?= $row->rank_user_id ?>" title="Αφαίρεση ορισμού ως τραυματίας">injured</div></td>
                            <script type="text/javascript">
								$('td[userid="<?= $row->rank_user_id ?>"]').css('color','#3375a9');
							</script>
                            <?php
						}
						else{
							?>
							<td style="border: 0px solid; color:#3375a9;" width="42"><div class="inline" style="cursor:default;" title="Ο παίκτης είναι τραυματίας και δεν μπορεί προς το παρών να προσκαλεστεί" >INJURED</div></td>
                            <script type="text/javascript">
								$('td[userid="<?= $row->rank_user_id ?>"]').css('color','#3375a9');
							</script>
                            <?php
						}
					}
					if($userSession->IsAdmin==1){
						?>
						<td style="border: 0px solid; color:#FF0000;" width="42"><div class="btn inline removePlr" userid="<?= $row->rank_user_id ?>" title="Αφαίρεση του παίκτη απο την κατάταξη!!!">remove</div></td>
						<?php
					}
				?>
        				<td style="border: 0px solid; padding:0px; width:20px;"><img class="profile_base sticky_tip" rel="get_profile.php?userid=<?= $row->rank_user_id ?>" src="img/user_default_0_mini.png" style="vertical-align:middle; cursor:pointer;" /></td>
              </tr>
            </table>
             </td>
            <td ><?= $row->rank_tot_points ?></td>
            <td >	
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td style="border: 0px solid;" width="33%" align="center" id="showLast5Matches"><div title="Τελευταίοι 5 αγώνες" class="tip inline" rel="last5matches.php?user=<?= $row->rank_user_id ?>" >L5M</div></td>
                    <td style="border: 0px solid;" width="33%" align="center" id="showPlrStats"><div title="Στατιστικά παίκτη" class="tip inline" rel="stats.php?user=<?= $row->rank_user_id ?>" >STATS</div></td>
                    <td style="border: 0px solid;" width="33%" align="center" id="showLastTourPos"><div title="Θέση στο τελευταίο τουρνουά" class="tip inline" rel="lastTourPos.php?user=<?= $row->rank_user_id ?>" >LTP</div></td>
                  </tr>
                </table>
            </td>
        </tr>
        	<?php
        	$i++;
 	} ?>
    </table> 
    <style type="text/css">
		.profile_base:hover{
			outline:1px solid #ccc;
		}
		</style>
    <div id="blockMessage" style="display:none">
    	<div><img src="img/dialog-warning.png"  /></div>
    	<div>Θέλετε να ορίσετε ως "blocked" τον συγκεκριμένο παίκτη στην διαδιακασία των προσκλήσεων;<br>Προσοχή! Θα ακυρωθούν και όλες οι εκκρεμείς προσκλήσεις που τον αφορούν.</div>
        <div><button class="button blockHim">Αποδοχή</button><button class="button cancelBlock">Ακύρωση</button></div>
    </div>
    <div id="unBlockMessage" style="display:none">
    	<div><img src="img/dialog-warning.png"  /></div>
    	<div>Θέλετε να ενεργοποιήσετε τον συγκεκριμενο παίκτη;</div>
        <div><button class="button unBlockHim">Αποδοχή</button><button class="button cancelUnBlock">Ακύρωση</button></div>
    </div>
    <div id="injureMessage" style="display:none">
    	<div><img src="img/dialog-warning.png"  /></div>
    	<div>Θέλετε να ορίσετε ως "injured" τον συγκεκριμένο παίκτη στην διαδιακσία των προσκλήσεων;<br>Προσοχή! Θα ακυρωθούν και όλες οι εκκρεμείς προσκλήσεις που τον αφορούν.</div>
        <div><button class="button injureHim">Αποδοχή</button><button class="button cancelInjury">Ακύρωση</button></div>
    </div>
    <div id="uninjureMessage" style="display:none">
    	<div><img src="img/dialog-warning.png"  /></div>
    	<div>Θέλετε να ενεργοποιήσετε τον συγκερκιμένο παίκτη;</div>
        <div><button class="button uninjureHim">Αποδοχή</button><button class="button cancelunInjury">Ακύρωση</button></div>
    </div>
    <div id="removeMessage" style="display:none">
    	<div><img src="img/alert.png"  /></div>
    	<div>Θέλετε να διαγράψετε τον συγκεκριμένο παίκτη από την βαθμολογία;<br>Προσοχή! Σε περίπτωση που προχωρήσετε, θα διαγραφούν όλοι οι πόντοι του και δεν θα υπάρχει τρόπος ανάκτησής τους.</div>
        <div><button class="button removeHim">Αποδοχή</button><button class="button cancelRemove">Ακύρωση</button></div>
    </div>
    <div id="callPlayerMessage" style="display:none">
    	<div><img src="img/dialog-warning.png"  /></div>
    	<div id="callPlayerMessageText"></div>
        <div><button class="button callHim">Αποδοχή</button><button class="button cancelCall">Ακύρωση</button></div>
    </div>
<script type="text/javascript">
$(document).ready(function(){
	$('#addToRankings').click(function(){
		$('.chPlrToAddClass').each(function(){
			$(this).css('display','inline-block');
		});
		$(this).hide();
	});
	$('#chPlrToAddBtn').click(function(){
		if($('#choosenPlrToAdd').val()!='' && $('#choosenPlrToAdd').val()!=0){
			$(this).unbind('click');
		}
		else{
			return;
		}
		$.ajax({
		  type: "POST",
		  url: "rankingSystem.php",
		  data: { addplr: $('#choosenPlrToAdd').val(), rankType: $('#chooseRanking').val()}
		}).done(function( msg ) {
			var playername = $('#choosenPlrToAdd_visible').val();
			if ($(".success")[0]){
			   // Do something here if class exists
			   $('.success').remove();
			   $('#content').prepend('<div class="success" style="" id="profileUpdatedMessage">Εισάγατε επιτυχώς τον χρήστη '+playername+' στην κατάταξη</div>');
			}
			else{
				$('#content').prepend('<div class="success" style="" id="profileUpdatedMessage">Εισάγατε επιτυχώς τον χρήστη '+playername+' στην κατάταξη</div>');
			}
			$('.rankingDiv').html('<img href="img/admin-ajax-indicator.gif" />');
			//$('#rankingDiv').load('rankingSystem.php',{ ajaxize: "true", sex: $('#chooseRanking').val()});
			$.ajax({
			type: "POST",
			url: "rankingSystem.php",
			data: { ajaxize: "true", sex: $('#chooseRanking').val()}
			}).done(function( data ) {
				$('.rankingDiv').html(data);
			});
		});
	});
	$('.blockPlr').click(function(){
		$('#blockMessage').attr('which',$(this).attr('userid'));
		$("#blockMessage").dialog("open");		
	});
	$('.unblockPlr').click(function(){
		$('#unBlockMessage').attr('which',$(this).attr('userid'));
		$("#unBlockMessage").dialog("open");		
	});
	/*$('.removePlr').click(function(){
		var con=confirm('Αφαίρεση του χρήστη από την κατάταξη;');
		if (!con)
			return false;
		$.ajax({
		  type: "POST",
		  url: "rankingSystem.php",
		  data: { removePlr: "ok", plrid:  $(this).attr('userid')}
		}).done(function( msg ) {
			window.location.reload();
		});
	});*/
	$('.injury').click(function(){
		$('#injureMessage').attr('which',$(this).attr('userid'));
		$("#injureMessage").dialog("open");
	});
	$('.uninjury').click(function(){
		$('#uninjureMessage').attr('which',$(this).attr('userid'));
		$("#uninjureMessage").dialog("open");
	});
	if ($('#choosenPlrToAdd').val()==-1){
		$('#chPlrToAddBtn').hide();
	}
	$('.removePlr').click(function(){
		$('#removeMessage').attr('which',$(this).attr('userid'));
		$("#removeMessage").dialog("open");
	});
	$('#chooseRanking').change(function(){
		var old_url=window.location.href;
		var new_url = old_url.substring(0, old_url.indexOf('?'));
		if (new_url=='')
			new_url=old_url;
		new_url+="?sex="+$(this).val();
		window.location.href=new_url;
	});
	$('.user').click(function(){
		$('#callPlayerMessage').attr('plrname',$(this).html());
		$('#callPlayerMessage').attr('userid',$(this).attr('userid'));
		if($(this).attr('sex')=='male'){
			$('#callPlayerMessageText').html('Θέλετε να καλέσετε τον παίκτη '+$('#callPlayerMessage').attr('plrname')+' σε αγώνα;');
		}
		else{
			$('#callPlayerMessageText').html('Θέλετε να καλέσετε την παίκτρια '+$('#callPlayerMessage').attr('plrname')+' σε αγώνα;');
		}
		$("#callPlayerMessage").dialog("open");
		
		/*var con=confirm('Κλήση του παίκτη '+$(this).html()+' για αγώνα;');
		if(con){
		  $.post("getCalls.php",
		  {
			caller:userid,
			callee:$(this).attr('userid')
		  },
		  function(data,status){	
		  	var old_url=window.location.href;
			var new_url = old_url.substring(0, old_url.indexOf('?'));
			if (new_url=='')
				new_url=old_url;
			window.location.href=new_url;
		  });
		}*/
		//alert($(this).attr('userid'));						  
	});
	$('.tip').each(function(){
		$(this).qtip({
			
			position: {
			my: 'middle right',
			at: 'middle left',
			target: $(this),
			effect: false
			},
			style: { 
	      		classes: 'myCustomStyle'
	  		},
			content: {
			text: 'Loading...',
			ajax: {
			url: $(this).attr('rel'),
			type: 'GET',
			dataType: 'html'
			}
			},
			show: {
			event: 'mouseover'
			}
				
		}); 
	});
	$('.sticky_tip').each(function(){
		$(this).qtip({
			
			position: {
			my: 'bottom right',
			at: 'bottom left',
			target: $(this),
			effect: false
			},
			style: { 
	      		classes: 'myCustomStyle'
	  		},
			content: {
			text: 'Loading...',
			ajax: {
			url: $(this).attr('rel'),
			type: 'GET',
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
									return false;
							 });
							// Tell the document itself when clicked to hide the tip and then unbind
							// the click event (the .one() method does the auto-unbinding after one time)
							$(document).one("click", function() { trigger.qtip('hide'); });
					}
			}
		}); 
	});
	
	$("#blockMessage").dialog({
      	autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
		minHeight: 400, minWidth: 700, width: 700,
		open: function(event, ui) {
			$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
		}
		
    });
	$("#unBlockMessage").dialog({
      	autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
		minHeight: 400, minWidth: 700, width: 700,
		open: function(event, ui) {
			$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
		}
    });
	$("#injureMessage").dialog({
      	autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
		minHeight: 400, minWidth: 700, width: 700,
		open: function(event, ui) {
			$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
		}
    });
	$("#uninjureMessage").dialog({
      	autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
		minHeight: 400, minWidth: 700, width: 700,
		open: function(event, ui) {
			$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
		}
    });
	$("#removeMessage").dialog({
      	autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
		minHeight: 400, minWidth: 700, width: 700,
		open: function(event, ui) {
			$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
		}
    });
	$("#callPlayerMessage").dialog({
      	autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
		minHeight: 400, minWidth: 700, width: 700,
		open: function(event, ui) {
			$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
		}
    });
	$('.blockHim').click(function(){
		$.ajax({
		type: "POST",
		url: "rankingSystem.php",
		data: { blockPlr: "ok", plrid:  $('#blockMessage').attr('which')}
		}).done(function( msg ) {
			window.location.reload();
		});
	});
	$('.cancelBlock').click(function(){
		 $("#blockMessage").dialog("close");
	});
	$('.unBlockHim').click(function(){
		$.ajax({
		type: "POST",
		url: "rankingSystem.php",
		data: { unblockPlr: "ok", plrid:  $('#unBlockMessage').attr('which')}
		}).done(function( msg ) {
			window.location.reload();
		});
	});
	$('.cancelUnBlock').click(function(){
		 $("#unBlockMessage").dialog("close");
	});
	$('.injureHim').click(function(){
		$.ajax({
		type: "POST",
		url: "rankingSystem.php",
		data: { injury: "ok", plrid:  $('#injureMessage').attr('which')}
		}).done(function( msg ) {
			window.location.reload();
		});
	});
	$('.cancelInjury').click(function(){
		 $("#injureMessage").dialog("close");
	});
	$('.uninjureHim').click(function(){
		$.ajax({
		type: "POST",
		url: "rankingSystem.php",
		data: { injury: "ok", plrid:  $('#uninjureMessage').attr('which')}
		}).done(function( msg ) {
			window.location.reload();
		});
	});
	$('.cancelunInjury').click(function(){
		 $("#uninjureMessage").dialog("close");
	});
	$('.removeHim').click(function(){
		$.ajax({
		type: "POST",
		url: "rankingSystem.php",
		data: { removePlr: "ok", plrid:  $('#removeMessage').attr('which')}
		}).done(function( msg ) {
			window.location.reload();
		});
	});
	$('.cancelRemove').click(function(){
		 $("#removeMessage").dialog("close");
	});
	$('.callHim').off().one('click',function(){
		$('#callPlayerMessage').html('<div style="position: relative; top: 170px; display: block;" id="creatingNotification">Δημιουργία πρόσκλησης...<br><img alt="Creating reservation" src="img/reservation_submitting.gif"></div>');
		$.post("getCalls.php",
		  {
			caller:userid,
			callee:$('#callPlayerMessage').attr('userid')
		  },
		  function(data,status){	
		  	var old_url=window.location.href;
			var new_url = old_url.substring(0, old_url.indexOf('?'));
			if (new_url=='')
				new_url=old_url;
			window.location.href=new_url;
		  });
	});
	$('.cancelCall').click(function(){
		 $("#callPlayerMessage").dialog("close");
	});
});
</script>
</div>