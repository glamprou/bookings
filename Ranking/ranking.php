<?php
require_once (ROOT_DIR.'Ranking/functions.php');
$userid=$userSession->UserId;

$curr_ranking_id=NULL;
$getDefaultRanking=TRUE;
if(isset($_GET['ranking'])){
    if (ctype_digit($_GET['ranking'])){
        $ranking=pdoq("select * from r_rankings where ranking_id=?",$_GET['ranking']);
        if($ranking){
            $getDefaultRanking=FALSE;
            $curr_ranking_id=$ranking[0]->ranking_id;
        }
    }    
}

if($getDefaultRanking){
    $curr_ranking_id=getRankingId($userid);
    if(!$curr_ranking_id){
        $ranking=pdoq("select * from r_rankings order by ranking_id asc limit 1");
        if(!$ranking){
            echo "no ranking tables";
            return;
        }
        else{
            $curr_ranking_id=$ranking[0]->ranking_id;
        }
    }
}
$row=pdoq("select ranking_table_name from r_rankings where ranking_id=?", $curr_ranking_id);
if($row){
    $ranking_table_name=$row[0]->ranking_table_name;
}

$players=pdoq("select ran.rank_pos as position, ran.rank_user_id as user_id, ran.rank_tot_points as points, CONCAT(us.fname, ' ',us.lname) as fullname from ".$ranking_table_name." ran inner join users us on ran.rank_user_id=us.user_id order by ran.rank_pos asc");
?>
<script type="text/javascript" src="scripts/autocomplete.js"></script>
<link rel="stylesheet" type="text/css" href="../Ranking/styles.css">
<link rel="stylesheet" type="text/css" href="css/admin.css">
<link rel="stylesheet" type="text/css" href="css/ranking/styles.css">
<link rel="stylesheet" type="text/css" href="css/jquery.qtip.min.css">
<script type="text/javascript" src="scripts/js/jquery.qtip.min.js" ></script>
<div id="participantDialog" title="Επιλογή παίκτη" class="dialog"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="300"><h1>Κατάταξη</h1></td>
    <td>
    	<h1 style="padding-top: 23px;">
        	<select id="chooseRanking" class="textbox" style="margin-bottom:1px">
                <?php
                $rankings=pdoq("select * from r_rankings");
                foreach ($rankings as $r){
                    $selected='';
                    if($r->ranking_id==$curr_ranking_id){
                        $selected='selected="seledted"';
                    }
                    echo '<option value="'.$r->ranking_id.'" '.$selected.'>'.$r->ranking_name.'</option>';
                }
                ?>
        	</select>	
    	</h1>
    </td>
  </tr>
</table>
<?php
if(!empty($_SESSION['rankingMessage'])){
    ?>
    <div class="success rankingMessage" style="" id="profileUpdatedMessage"><?php echo $_SESSION['rankingMessage']; ?></div>
    <script>
        $('.rankingMessage').click(function(){
            $(this).slideUp('fast');
        });
    </script>
    <?php
    unset($_SESSION['rankingMessage']);
}
?>
<div class="rankingDiv">
    <table class="list userList" width="780" style="min-width: 575px;">
         <tr align="center">
            <th width="51">Θέση</th>
            <th>
            <?php
			if($userSession->IsAdmin==1){
			?>
                <label for="addToRankings">Παίκτες</label>
            	<div id="addToRankings" title="Εισαγωγή παίκτη στο ranking" style="vertical-align: middle;"><img src="img/plus-button.png" style="vertical-align: middle;" /></div>
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
                      
                      $('#choosenPlrToAdd_visible').userAutoComplete('ajax/autocomplete.php?type=user&ranking=<?php echo $curr_ranking_id; ?>', function(ui) {
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
        if($players){
            foreach ($players as $plr){
            ?>
            <tr align="center" class="row<?= $i%2 ?>">
                    <?php
                    $last_rank=pdoq("select last_rank from  player_rank_details where user_id=?",$plr->user_id);  

                    if($last_rank){
                        $position_difference=$last_rank[0]->last_rank-$plr->position;
                        if($last_rank[0]->last_rank==0 || $position_difference==0){
                            $position_difference='';
                        }
                        else if($position_difference>0){
                            $position_difference='<span style="color: #47B247">(+'.$position_difference.')</span>';
                        }
                        else{
                            $position_difference='<span style="color: #FF4747">('.$position_difference.')</span>';
                        }
                    }
                    ?>
                <td>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="45%" align="right" style="padding:0; border:none;"><?= $plr->position ?></td>
                      <td width="55%" align="right" style="padding:0; border:none;"><?php echo $position_difference; ?></td>
                    </tr>
                  </table>
                            </td>
                            <td style="padding-right: 2px;"><?php canBeCalled($userSession->UserId,$plr->user_id) ?>
                 <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td style="border: 0px solid; padding-left: 10px;" class="<?php if (canBeCalled($userSession->UserId,$plr->user_id)) echo "user btn"; ?>" align="left" sex="<?= $sex ?>" userid="<?= $plr->user_id ?>"><?php
                        echo $plr->fullname; 
                     ?></td>
                    <?php
                        if (!isBlocked($plr->user_id)){
                            if($userSession->IsAdmin==1){
                                ?>
                                <td style="border: 0px solid; color:#F47D3D ;" width="42"><div class="btn inline blockPlr"  userid="<?= $plr->user_id ?>" title="Μπλοκάρισμα παίκτη">block</div></td>
                                <?php
                            }
                        }
                        else{
                            if($userSession->IsAdmin==1){
                                ?>
                                <td style="border: 0px solid; color:#F47D3D ;" width="42"><div class="btn inline unblockPlr"  userid="<?= $plr->user_id ?>" title="Ξεμπλοκάρισμα παίκτη">unblock</div></td>
                                <script type="text/javascript">
                                    $('td[userid="<?= $plr->user_id ?>"]').css('color','#F47D3D ');
                                </script>
                                <?php
                            }
                            else{
                                ?>
                                <td style="border: 0px solid; color:#F47D3D ;" width="42"><div class="inline" style="cursor:default;" title="Ο παίκτης είναι μπλοκαρισμένος και δεν μπορεί προς το παρών να προσκαλεστεί">BLOCKED</div></td>
                                <script type="text/javascript">
                                    $('td[userid="<?= $plr->user_id ?>"]').css('color','#F47D3D ');
                                </script>
                                <?php
                            }
                        }
                        if (!isInjured($plr->user_id)){
                            if($userSession->IsAdmin==1){
                                ?>
                                <td style="border: 0px solid; color:#3375a9;" width="42"><div class="btn inline injury" userid="<?= $plr->user_id ?>" title="Ορισμός ως τραυματίας">injury</div></td>
                                <?php
                            }
                        }
                        else{
                            if($userSession->IsAdmin==1){
                                ?>
                                <td style="border: 0px solid; color:#3375a9;" width="42"><div class="btn inline uninjury" userid="<?= $plr->user_id ?>" title="Αφαίρεση ορισμού ως τραυματίας">injured</div></td>
                                <script type="text/javascript">
                                    $('td[userid="<?= $plr->user_id ?>"]').css('color','#3375a9');
                                </script>
                                <?php
                            }
                            else{
                                ?>
                                <td style="border: 0px solid; color:#3375a9;" width="42"><div class="inline" style="cursor:default;" title="Ο παίκτης είναι τραυματίας και δεν μπορεί προς το παρών να προσκαλεστεί" >INJURED</div></td>
                                <script type="text/javascript">
                                    $('td[userid="<?= $plr->user_id ?>"]').css('color','#3375a9');
                                </script>
                                <?php
                            }
                        }
                        if($userSession->IsAdmin==1){
                            ?>
                            <td style="border: 0px solid; color:#FF0000;" width="42"><div class="btn inline removePlr" userid="<?= $plr->user_id ?>" title="Αφαίρεση του παίκτη απο την κατάταξη!!!">remove</div></td>
                            <?php
                        }
                    ?>
                            <td style="border: 0px solid; padding:0px; width:20px;"><img class="profile_base sticky_tip" rel="../Ranking/get_profile.php?userid=<?= $plr->user_id ?>" src="img/user_default_0_mini.png" style="vertical-align:middle; cursor:pointer;" /></td>
                  </tr>
                </table>
                 </td>
                <td style="background-color: #e8e8e8;"><?= $plr->points ?></td>
                <td >	
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td style="border: 0px solid;" width="33%" align="center" id="showLast5Matches"><div title="Τελευταίοι 5 αγώνες" class="tip inline" rel="../Ranking/last5matches.php?user=<?= $plr->user_id ?>" >L5M</div></td>
                        <td style="border: 0px solid;" width="33%" align="center" id="showPlrStats"><div title="Στατιστικά παίκτη" class="tip inline" rel="../Ranking/stats.php?user=<?= $plr->user_id ?>" >STATS</div></td>
                        <td style="border: 0px solid;" width="33%" align="center" id="showLastTourPos"><div title="Θέση στο τελευταίο τουρνουά" class="tip inline" rel="../Ranking/lastTourPos.php?user=<?= $plr->user_id ?>" >LTP</div></td>
                      </tr>
                    </table>
                </td>
            </tr>
                <?php
                $i++;
            } 
        }
        else{
            ?>
            <tr class="row0">
                <td colspan="4">Δεν υπάρχουν παίκτες</td>
            </tr>
            <?php
        }
        ?>
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
            url: "../Ranking/ajax.php",
            data: { 
                action: "insertToRanking",
                player: $('#choosenPlrToAdd').val(), 
                ranking: <?php echo $curr_ranking_id; ?>
            }
		}).done(function( msg ) {
            window.location.reload();
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
		new_url+="?ranking="+$(this).val();
		window.location.href=new_url;
	});
	$('.user').click(function(){
		$('#callPlayerMessage').attr('plrname',$(this).html());
		$('#callPlayerMessage').attr('userid',$(this).attr('userid'));
		if(true){
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
			effect: false,
            viewport: $(window)
			},
			style: { 
	      		classes: 'profileTip'
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
			},
			hide: {
					event: 'mouseout',
					fixed: true
			}
		}); 
	});
	$('.sticky_tip').each(function(){
		$(this).qtip({
			
			position: {
			my: 'bottom right',
			at: 'bottom left',
			target: $(this),
			effect: false,
            viewport: $(window)
			},
			style: { 
	      		classes: 'profileTip'
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
      	autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: true,
		minHeight: 400, minWidth: 700, width: 700,
		open: function(event, ui) {
			$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
		}
		
    });
	$("#unBlockMessage").dialog({
      	autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: true,
		minHeight: 400, minWidth: 700, width: 700,
		open: function(event, ui) {
			$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
		}
    });
	$("#injureMessage").dialog({
      	autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: true,
		minHeight: 400, minWidth: 700, width: 700,
		open: function(event, ui) {
			$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
		}
    });
	$("#uninjureMessage").dialog({
      	autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: true,
		minHeight: 400, minWidth: 700, width: 700,
		open: function(event, ui) {
			$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
		}
    });
	$("#removeMessage").dialog({
      	autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: true,
		minHeight: 400, minWidth: 700, width: 700,
		open: function(event, ui) {
			$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
		}
    });
	$("#callPlayerMessage").dialog({
      	autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: true,
		minHeight: 400, minWidth: 700, width: 700,
		open: function(event, ui) {
			$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
		}
    });
	$('.blockHim').click(function(){
		$.ajax({
            type: "POST",
            url: "../Ranking/ajax.php",
            data: { 
                action: "blockPlr", 
                player:  $('#blockMessage').attr('which')
            }
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
            url: "../Ranking/ajax.php",
            data: { 
                action: "unblockPlr", 
                player:  $('#unBlockMessage').attr('which')
            }
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
            url: "../Ranking/ajax.php",
            data: { 
                action: "injure", 
                player:  $('#injureMessage').attr('which')
            }
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
            url: "../Ranking/ajax.php",
            data: { 
                action: "uninjure", 
                player:  $('#uninjureMessage').attr('which')
            }
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
            url: "../Ranking/ajax.php",
            data: { 
                action: "removePlr", 
                player:  $('#removeMessage').attr('which')
            }
		}).done(function( msg ) {
			window.location.reload();
		});
	});
	$('.cancelRemove').click(function(){
		 $("#removeMessage").dialog("close");
	});
	$('.callHim').off().one('click',function(){
        $.ajax({
            type: "POST",
            url: "../Ranking/ajax.php",
            data: { 
                action: "newCall",
                caller: <?php echo $userSession->UserId ?>, 
                callee:$('#callPlayerMessage').attr('userid')
            }
		}).done(function( msg ) {
			window.location.reload();
		});
	});
	$('.cancelCall').click(function(){
		 $("#callPlayerMessage").dialog("close");
	});
});
</script>
</div>