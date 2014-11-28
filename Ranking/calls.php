<?php
require_once (ROOT_DIR.'Ranking/functions.php');
$userid=$userSession->UserId;
        
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
?>
<link rel="stylesheet" type="text/css" href="../Ranking/styles.css">
<script type="text/javascript" src="scripts/autocomplete.js"></script>
<div id="participantDialog" title="Επιλογή παίκτη" class="dialog"></div>
<?php

$res112=mysql_query("select calls_block_schedule,calls_block_scheduled from r_blocks");
$res112=mysql_fetch_object($res112);
if($res112->calls_block_scheduled){
	$tmparr=explode('-',$res112->calls_block_schedule);
	$block_date=$tmparr[2]."-".$tmparr[1]."-".$tmparr[0];
}
?>
<div class="callsDiv">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" >
      <tr>
        <td width="300"><h1>Αγώνες κατάταξης</h1></td>
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
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.qtip.min.css">
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
            <table class="list userList" width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th width="490" style="text-align: left;">AceGame</th>
                <th style="text-align: left;">Εκκρεμότητα</th>
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
                <td style="position: relative;">
                <?php
                if (!$row->match_date){
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
        <td colspan="2"><h2 style="border-bottom:0px solid; padding-top: 10px;">Αποτελέσματα προσκλήσεων</h2></td>
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
        $('#allCallsOuter').load('../Ranking/fetchAllCalls.php',{calltype: $('#matchtypeselection').val(),ranking: <?php echo $curr_ranking_id ?>});
        
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
        $('#chooseRanking').change(function(){
            var old_url=window.location.href;
            var new_url = old_url.substring(0, old_url.indexOf('?'));
            if (new_url=='')
                new_url=old_url;
            window.location.href=new_url+"?ranking="+$('#chooseRanking').val();
        });
       function fetchThem(){
            var wntid=$('#playerselection').val();
            var calltype=$('#matchtypeselection').val();

            $('#allCallsOuter').load("../Ranking/fetchAllCalls.php",{plrid: wntid, calltype: calltype, ranking: <?php echo $curr_ranking_id ?>});
        }
        $('.accept_call').one('click',function(){
			var parent=$(this).parent();
			parent.html('<div style="width: 60px;"><img height="16" src="img/admin-ajax-indicator.gif" /></div>');
            $.ajax({
              type: "POST",
              url: "../Ranking/ajax.php",
              data: { action: "acceptCall", callid:  $(this).attr('value')}
            }).done(function( msg ) {
                window.location.reload();
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
              url: "../Ranking/ajax.php",
              data: { action: "declineCall", callid:  $(this).attr('value')}
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