<?php
require_once (ROOT_DIR.'Ranking/functions.php');
?>
<div class="rankingAdminDiv">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <link rel="stylesheet" type="text/css" href="../Ranking/styles.css">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><h1>Διαχείριση</h1></td>
      </tr>
      <tr>
          <td>
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
          </td>
      </tr>
      <tr>
        <td>
        <div class="admin" style=" max-width:900px;">
        <div class="title">
        Μπλοκάρισμα των προσκλήσεων
        </div>
        <div style="background-color:#FFFFFF">
            <div id="addResourceResults" class="error" style="display:none;"></div>
                <table cellpadding="0" cellspacing="0">
            <?php
                $rrr=mysql_query("select * from r_blocks");
                $rrr=mysql_fetch_object($rrr);
                if (isCallsBlocked("schedule")){
                    ?>
                    <tr>
                        <td><button class="button" id="unblockBtn"><img src="img/cross-button.png" title="" alt=""> Ακύρωση</button></td>
                        <td><input type="text" id="datepicker" /></td>
                        <td><button class="button" id="updateblockBtn">Ενημέρωση</button></td>
                        <td id="chooseDateError" style="color:#FF0000; display:none;">* πρέπει να ορίσετε ημερομηνία</td>
                    </tr>
                    <script type="text/javascript">
                        $( "#datepicker" ).datepicker({ disabled: false });
                    </script>
                    <?php
                }
                else{
                    ?>
                    <tr>
                        <td><button class="button" id="blockBtn"><img src="img/exclamation-red.png" title="" alt=""> Μπλοκάρισμα</button></td>
                        <td><input type="text" id="datepicker" /></td>
                        <td id="chooseDateError" style="color:#FF0000; display:none;">* πρέπει να ορίσετε ημερομηνία</td>
                    </tr>
                    <?php
                }
            ?>	
            </table>
            </div>
        </div>
        </td>
      </tr>
      <tr>
        <td>
        <div class="admin" style="margin-top:30px; max-width:900px;">
        <div class="title">
        Προσθήκη νέου τουρνουά
        </div>
        <div style="background-color:#FFFFFF">
            <div id="addResourceResults" class="error" style="display:none;"></div>
                <form id="newtourform" action="" method="">
                    <table>
                        <tbody><tr>
                            <th>Όνομα τουρνουά</th>
                            <th>Ημ. Έναρξης</th>
                            <th>Ημ. Λήξης</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                        <tr>
                            <td><input id="tournameid" 		type="text" name="tourname"  /></td>
                            <td><input id="datepicker_start" 		type="text" name="tourdate" /> </td>
                            <td><input id="datepicker_end" 	type="text" name="tourdate_end"  /></td>
                            <td>
                                <button type="button" id="newtourformSubmitBtn" class="button save"><img src="img/plus-button.png" title="" alt=""> Προσθήκη τουρνουά</button>
                            </td>
                            <td valign="middle" id="allfieldsreqError" style="color:#FF0000; display:none;">* όλα τα πεδία είναι υποχρεωτικά</td>
                        </tr>
                    </tbody></table>
                </form>
            </div>
        </div>
        </td>
      </tr>
      <tr>
        <td>
        <div class="admin" style="margin-top:30px; max-width:900px;">
        <div class="title">
        Εισαγωγή αποτελεσμάτων
        </div>
        <div style="background-color:#FFFFFF">
            <div id="addResourceResults" class="error" style="display:none;"></div>
                <table>
                    <tr>
                        <th colspan="2">Όνομα τουρνουά</th>
                    </tr>
                    <tr>
                        <td valign="middle" width="155">
                        <select id="selTourForEdit" class="textbox" >
                            <option value="-1">Παρακαλώ επιλέξτε</option>
                            <?php
                                $res=mysql_query("select * from r_tours order by tour_date desc");
                                while ($row=mysql_fetch_object($res)){
                                    echo "<option value='$row->tour_id' tour_date='".changeDate($row->tour_date)."' tour_date_fin='".changeDate($row->tour_date_fin)."'>$row->tour_name</option>";
                                }
                            ?>
                        </select>
                        </td>
                        <td><img id="editTourDetailsBtn" class="btn" style="cursor:pointer; display:none;" src="img/disk-arrow.png"  onclick="javascript: $('#editTourDetails').show(); $(this).hide();" /></td>
                    </tr>
                    <tr>
                    	<td id="editTourDetails" style="display:none">
                            <table border="0" cellspacing="0" cellpadding="0" width="550">
                              <tr>
                                <td><input id="tournameeditid" 		 type="text" name="tourname"  /></td>
                                <td><input id="datepickeredit_start" type="text" name="tourdate" /> </td>
                                <td><input id="datepickeredit_end" 	 type="text" name="tourdate_end"  /></td>
                                <td><button class="button" style="width:130px;" id="editTourDetailsSaveBtn"><img id="" class="btn" style="cursor:pointer; vertical-align: middle;" src="img/disk-arrow.png" />  Ενημέρωση</button></td>
                              </tr>
                            </table>
                    	</td>
                    </tr>
                    <tr>
                        <td  colspan="2" >
                            <div id="foundtours"></div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        </td>
      </tr>
     <tr>
        <td>
        <div class="admin" style="margin-top:30px; max-width:900px;">
        <div class="title">
        Εισαγωγή τουρνουά στην κατάταξη
        </div>
        <div style="background-color:#FFFFFF">
            <div id="addResourceResults" class="error" style="display:none;"></div>
                <form id="insertTourForm" action="" method="">
                    <table>
                        <tbody><tr>
                            <th>Όνομα τουρνουά</th>
                            <th>&nbsp;</th>
                        </tr>
                        <tr>
                            <td>
                            <select id="insertTourSelection" class="textbox" style="padding:5px; width:122px">
                            <?php
                                $i=0;
								$tr=mysql_query("select tour_id,tour_name from r_tours where counts!=1 order by tour_date asc");
                                while ($trow=mysql_fetch_object($tr)){
                                    echo "<option value=\"".$trow->tour_id."\">".$trow->tour_name."</option>";
                                    $i++;
                                }
                                if(!$i){
                                     echo "<option value=\"-1\">'Oλα τα τουρνουά είναι ενημερωμένα</option>";
                                }
                            ?>
                            </select>
                            </td>
                            <td>
                                <button type="button" <?php if(!$i){ echo "disabled=\"disabled\"";} ?> id="insertTourFormSubmitBtn" class="button save"><img src="img/plus-button.png" title="" alt=""> Εισαγωγή τουρνουά</button>
                            </td>
                        </tr>
                    </tbody></table>
                </form>
            </div>
        </div>
        </td>
      </tr>
      <tr>
        <td>
        <div class="admin" style="margin-top:30px; max-width:900px;">
        <div class="title">
        Αφαίρεση τουρνουά από την κατάταξη
        </div>
        <div style="background-color:#FFFFFF">
            <div id="addResourceResults" class="error" style="display:none;"></div>
                <form id="removeTourForm" action="" method="">
                    <table>
                        <tbody><tr>
                            <th>Όνομα τουρνουά</th>
                            <th>&nbsp;</th>
                        </tr>
                        <tr>
                            <td>
                            <select id="removeTourSelection" class="textbox" style="padding:5px; width:122px">
                            <?php
                                $i=0;
                                $tr=mysql_query("select tour_id,tour_name from r_tours where counts=1 order by tour_date asc");
                                while ($trow=mysql_fetch_object($tr)){
                                    echo "<option value=\"".$trow->tour_id."\">".$trow->tour_name."</option>";
                                    $i++;
                                }
                                if(!$i){
                                     echo "<option value=\"-1\">Δεν υπάρχει τουρνουά στην κατάταξη</option>";
                                }
                            ?>
                            </select>
                            </td>
                            <td>
                                <button type="button" <?php if(!$i){ echo "disabled=\"disabled\"";} ?> id="removeTourFormSubmitBtn" class="button save"><img src="img/cross-button.png" title="" alt=""> Αφαίρεση τουρνουά</button>
                            </td>
                        </tr>
                    </tbody></table>
                </form>
            </div>
        </div>
        </td>
      </tr>
    </table>
    <div id="insertToRankingMessage" style="display:none">
    	<div><img src="img/dialog-warning.png"  /></div>
    	<div id="insertToRankingMessageText"></div>
        <div><button class="button acceptInsertToRank">Αποδοχή</button><button class="button declineInsertToRank">Ακύρωση</button></div>
    </div>
    <div id="removeFromRankingMessage" style="display:none">
    	<div><img src="img/alert.png"  /></div>
    	<div id="removeFromRankingMessageText"></div>
        <div><button class="button acceptRemoveFromRank">Αποδοχή</button><button class="button declineRemoveFromRank">Ακύρωση</button></div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#searchfortours').click(function(){
                $('#foundtours').load("tournaments.php",{getPlrs:'ok',plrid:$('#playerselection').val(),tourid:$('#searchTourselection').val()});
            });	
            $('#newtourformSubmitBtn').click(function(){
                $('#newtourform').submit();
            });
            $('#newtourform').submit(function(){
                if($('#tournameid').val()==''){
                    $('#allfieldsreqError').show();
                    $('#tournameid').focus();
                    return false;
                }
                if($('#datepicker_start').val()==''){
                    $('#allfieldsreqError').show();
                    $('#datepicker_start').focus();
                    return false;
                }
                if($('#datepicker_end').val()==''){
                    $('#allfieldsreqError').show();
                    $('#datepicker_end').focus();
                    return false;
                }
                $.ajax({
                  type: "POST",
                  url: "../Ranking/ajax.php",
                  data: { action: 'insertNewTour', tourname: $('#tournameid').val(), tourdate: $('#datepicker_start').val(), tourdateend: $('#datepicker_end').val()}
                }).done(function( msg ) {
                    window.location.reload();
                });
                return false;
            });
            $('#addnewtourbtn').click(function(){
                $('#addnewtourouter').toggle();
            });	
            $('#addtourresbtn').click(function(){
                $('#addtourresouter').toggle();
            });
            $('#insertTour').click(function(){
                $('#insertTourouter').toggle();
            });	
            $('#removeTour').click(function(){
                $('#removeTourouter').toggle();
            });	
            $('#tourresultsform').submit(function(event){
                event.preventDefault()
                alert('apenergopoiimeno');
                return;
                var tname='';
                var pname='';
                var ppos='';
                $('#chtourid').children().each(function(){
                    if ($(this).attr('value')==$('#chtourid').val())
                        tname=$(this).html();
                });
                $('#chplrid').children().each(function(){
                    if ($(this).attr('value')==$('#chplrid').val())
                        pname=$(this).html();
                });
                $('#chposid').children().each(function(){
                    if ($(this).attr('value')==$('#chposid').val())
                        ppos=$(this).html();
                });
                var con=confirm("Parakalw epalithefste kai patiste OK\ntournoua: "+tname+" \npaiktis: "+pname+"\n thesi: "+ppos);
                if (!con)
                    return false;
                $.ajax({
                  type: "POST",
                  url: "tournaments.php",
                  data: { insertParticipant: "ok", tourid: $('#chtourid').val(), plrid: $('#chplrid').val(), posid: $('#chposid').val(),}
                }).done(function( msg ) {
                  alert( msg );
                    var old_url=window.location.href;
                    var new_url = old_url.substring(0, old_url.indexOf('?'));
                    if (new_url=='')
                        new_url=old_url;
                    window.location.href=new_url;
                    return false;
                });
            });
            $('#insertTourFormSubmitBtn').click(function(){
				if (!$('#insertTourSelection').val())
                    return false;
				$("#insertToRankingMessageText").html('Θέλετε να προσθέσετε το τουρνουά '+$('#insertTourSelection').children(':selected').html()+' στην κατάταξη;');
                $("#insertToRankingMessage").dialog("open");	
            });
           /* $('#insertTourForm').submit(function(event){
                event.preventDefault();
                var tourname;
                if (!$('#insertTourSelection').val())
                    return false;
                $('#insertTourSelection').children().each(function(){
                    if ($(this).attr('value')==$('#insertTourSelection').val())
                        tourname=$(this).html();
                });
                
                var con=confirm("Prosthiki tou tournoua "+tourname+" sto ranking?");
                if (!con)
                    return false;
                    
                $.ajax({
                  type: "POST",
                  url: "tournaments.php",
                  data: { insertTour: "ok", tourid: $('#insertTourSelection').val(), sex: 0}
                }).done(function( msg ) {
					$.ajax({
					  type: "POST",
					  url: "tournaments.php",
					  data: { insertTour: "ok", tourid: $('#insertTourSelection').val(), sex: 1}
					}).done(function( msg ) {
						var old_url=window.location.href;
						var new_url = old_url.substring(0, old_url.indexOf('?'));
						if (new_url=='')
							new_url=old_url;
						window.location.href=new_url;
						return false;
					});
                });
            });*/
            $('#removeTourFormSubmitBtn').click(function(){
				if (!$('#removeTourSelection').val())
                    return false;
				$("#removeFromRankingMessageText").html('Θέλετε να αφαιρέσετε το τουρνουά '+$('#removeTourSelection').children(':selected').html()+' από την κατάταξη;');
                $("#removeFromRankingMessage").dialog("open");
            });
            $('#removeTourForm').submit(function(event){
                event.preventDefault();
                var tourname;
                if (!$('#removeTourSelection').val())
                    return false;
                $('#removeTourSelection').children().each(function(){
                    if ($(this).attr('value')==$('#removeTourSelection').val())
                        tourname=$(this).html();
                });
                
                var con=confirm("Afairesi tou tournoua "+tourname+" apo to ranking?");
                if (!con)
                    return false;
                    
                $.ajax({
                  type: "POST",
                  url: "tournaments.php",
                  data: { removeTour: "ok", tourid: $('#removeTourSelection').val()}
                }).done(function( msg ) {
                    var old_url=window.location.href;
                    var new_url = old_url.substring(0, old_url.indexOf('?'));
                    if (new_url=='')
                        new_url=old_url;
                    window.location.href=new_url;
                    return false;
                });
            });
            $('#updateRankingBtn').click(function(){
                $('#TourForEditOuter').toggle();
            });	
            $('#selTourForEdit').change(function(){
                if ($(this).val()==-1){
                    $('#foundtours').hide();
					$('#editTourDetailsBtn').hide();
                    return false;
                }
				$('#editTourDetailsBtn').show();
				$('#editTourDetails').hide();
                $('#foundtours').show();
                $('#foundtours').html('Παρακαλώ περιμένετε...');
                $('#foundtours').load("../Ranking/editTours.php",{tourid:$(this).val()});
				
				$('#tournameeditid').val($(this).children(':selected').html());
				$('#datepickeredit_start').val($(this).children(':selected').attr('tour_date'));
				$('#datepickeredit_end').val($(this).children(':selected').attr('tour_date_fin'));
            });	
			$('#editTourDetailsSaveBtn').click(function(){
				if($('#tournameeditid').val()=='' || $('#datepickeredit_start').val()=='' || $('#datepickeredit_end').val()==''){
					return false;
				}
				$.ajax({
                  type: "POST",
                  url: "rankingAdmin.php",
                  data: { ajaxize: "ok", updateTour: 'ok', tourname: $('#tournameeditid').val(), date_start: $('#datepickeredit_start').val(), date_end: $('#datepickeredit_end').val(), tourid: $('#selTourForEdit').val() }
                }).done(function( data ) {
                    if ($(".success")[0]){
					    $('.success').remove();
					    $('#content').prepend('<div class="success" style="" id="profileUpdatedMessage">Η ενημέρωση των πληροφοριών του τουρνουά '+$('#tournameeditid').val()+' έγινε με επιτυχία!</div>');
					}
					else{
					    $('#content').prepend('<div class="success" style="" id="profileUpdatedMessage">Η ενημέρωση των πληροφοριών του τουρνουά '+$('#tournameeditid').val()+' έγινε με επιτυχία!</div>');
					}
					$('.rankingAdminDiv').html(data);
                });
			});
            $('#blockBtn').click(function(){
                if ($('#datepicker').val()==''){
                    $('#chooseDateError').show();
                    return;
                }		
                $.ajax({
                  type: "POST",
                  url: "../Ranking/ajax.php",
                  data: { action: "blocking", date:  $('#datepicker').val()}
                }).done(function( msg ) {
                    window.location.reload();
                });
                return false;
            });	
            $('#unblockBtn').click(function(){
                $.ajax({
                  type: "POST",
                  url: "../Ranking/ajax.php",
                  data: { action: "unblocking"}
                }).done(function( msg ) {
                    window.location.reload();
                });
                return false;
            });
            $('#updateblockBtn').click(function(){
				if ($('#datepicker').val()==''){
                    $('#chooseDateError').show();
                    return;
                }
                $.ajax({
                  type: "POST",
                  url: "../Ranking/ajax.php",
                  data: { action: "updateblock", updateblockdate:  $('#datepicker').val()}
                }).done(function( msg ) {
                  	window.location.reload();
                });
                return false;
            });
            $(function() {
                $( "#datepicker" ).datepicker();
                //$( "#datepicker" ).datepicker($.datepicker.regional['']);
                $( "#datepicker" ).datepicker( "option", "dayNamesMin",["Κυ", "Δε", "Τρ", "Τε", "Πε", "Πα", "Σα"] );
                $( "#datepicker" ).datepicker( "option", "monthNames",['Ιανουάριος','Φεβρουάριος','Μάρτιος','Απρίλιος','Μάιος','Ιούνιος', 'Ιούλιος','Αύγουστος','Σεπτέμβριος','Οκτώβριος','Νοέμβριος','Δεκέμβριος'] );
                $( "#datepicker" ).datepicker( "option", "dateFormat", "dd-mm-yy" );
                $("#datepicker").datepicker("option", "minDate", 0 );
                <?php
                    $rrr=mysql_query("select * from r_blocks");
                    $rrr=mysql_fetch_object($rrr);
                ?>
                var date = '<?php if($rrr->calls_block_schedule){ echo changeDate($rrr->calls_block_schedule); }elseif($rrr->calls_block){ echo date("d-m-Y");}?>';
                $('#datepicker').datepicker('setDate', date);
                $( "#datepicker_start" ).datepicker();
                $( "#datepicker_end" ).datepicker();
				$( "#datepickeredit_start" ).datepicker();
				$( "#datepickeredit_end" ).datepicker();
                //$( "#datepicker_end" ).datepicker($.datepicker.regional['']);
                $( "#datepicker_start" ).datepicker( "option", "dayNamesMin",["Κυ", "Δε", "Τρ", "Τε", "Πε", "Πα", "Σα"] );
                $( "#datepicker_start" ).datepicker( "option", "monthNames",['Ιανουάριος','Φεβρουάριος','Μάρτιος','Απρίλιος','Μάιος','Ιούνιος', 'Ιούλιος','Αύγουστος','Σεπτέμβριος','Οκτώβριος','Νοέμβριος','Δεκέμβριος'] );
                $( "#datepicker_start" ).datepicker( "option", "dateFormat", "dd-mm-yy" );
                $( "#datepicker_start" ).datepicker("option", "minDate", 0 );
                
                $( "#datepicker_end" ).datepicker( "option", "dayNamesMin",["Κυ", "Δε", "Τρ", "Τε", "Πε", "Πα", "Σα"] );
                $( "#datepicker_end" ).datepicker( "option", "monthNames",['Ιανουάριος','Φεβρουάριος','Μάρτιος','Απρίλιος','Μάιος','Ιούνιος', 'Ιούλιος','Αύγουστος','Σεπτέμβριος','Οκτώβριος','Νοέμβριος','Δεκέμβριος'] );
                $( "#datepicker_end" ).datepicker( "option", "dateFormat", "dd-mm-yy" );
                $( "#datepicker_end" ).datepicker("option", "minDate", 0 );
				
				$( "#datepickeredit_start" ).datepicker( "option", "dayNamesMin",["Κυ", "Δε", "Τρ", "Τε", "Πε", "Πα", "Σα"] );
                $( "#datepickeredit_start" ).datepicker( "option", "monthNames",['Ιανουάριος','Φεβρουάριος','Μάρτιος','Απρίλιος','Μάιος','Ιούνιος', 'Ιούλιος','Αύγουστος','Σεπτέμβριος','Οκτώβριος','Νοέμβριος','Δεκέμβριος'] );
                $( "#datepickeredit_start" ).datepicker( "option", "dateFormat", "dd-mm-yy" );
                $( "#datepickeredit_start" ).datepicker("option", "minDate", 0 );
				
				$( "#datepickeredit_end" ).datepicker( "option", "dayNamesMin",["Κυ", "Δε", "Τρ", "Τε", "Πε", "Πα", "Σα"] );
                $( "#datepickeredit_end" ).datepicker( "option", "monthNames",['Ιανουάριος','Φεβρουάριος','Μάρτιος','Απρίλιος','Μάιος','Ιούνιος', 'Ιούλιος','Αύγουστος','Σεπτέμβριος','Οκτώβριος','Νοέμβριος','Δεκέμβριος'] );
                $( "#datepickeredit_end" ).datepicker( "option", "dateFormat", "dd-mm-yy" );
                $( "#datepickeredit_end" ).datepicker("option", "minDate", 0 );
            //setter);
            });
			$('#datepicker').change(function(){
				if($(this).val()!=''){
					$('#chooseDateError').hide();
				}
			});
			$("#insertToRankingMessage").dialog({
				autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
				minHeight: 400, minWidth: 700, width: 700,
				open: function(event, ui) {
					$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
				}
				
			});
			$('.acceptInsertToRank').click(function(){
				$.ajax({
                  type: "POST",
                  url: "../Ranking/ajax.php",
                  data: { action: "insertTour", tourid: $('#insertTourSelection').val()}
                }).done(function( msg ) {
					window.location.reload();
                });
			});
			$('.declineInsertToRank').click(function(){
				$("#insertToRankingMessage").dialog("close");
			});
			$("#removeFromRankingMessage").dialog({
				autoOpen: false, modal: true, draggable: false, resizable: false, closeOnEscape: false,
				minHeight: 400, minWidth: 700, width: 700,
				open: function(event, ui) {
					$(this).parents(".ui-dialog:first").find(".ui-dialog-titlebar").hide();
				}
				
			});
			$('.acceptRemoveFromRank').click(function(){
				 /*event.preventDefault();*/
                var tourname;
                $('#removeTourSelection').children().each(function(){
                    if ($(this).attr('value')==$('#removeTourSelection').val())
                        tourname=$(this).html();
                });
                    
                $.ajax({
                  type: "POST",
                  url: "../Ranking/ajax.php",
                  data: { action: "removeTour", tourid: $('#removeTourSelection').val()}
                }).done(function( msg ) {
                    window.location.reload();
                });
			});
			$('.declineRemoveFromRank').click(function(){
				$("#removeFromRankingMessage").dialog("close");
			});
        });
    </script>
</div>