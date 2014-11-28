<?php 
@include_once('../config.php');	
@include_once('config.php');	
@include_once('../functions.php');
@include_once('functions.php');

if (isset($_POST['updateRanking'])){
	updateRankings_Tours($_POST['tourid']);
	echo "To ranking ananewthike me epityxia!";
	exit;
}
if (isset($_POST['insertParticipant'])){	
	$res=mysql_query("select * from r_tours_participants where tour_id = ".$_POST['tourid']." and user_id = ".$_POST['plrid']);
	if (mysql_num_rows($res)==0){
		$res=mysql_query("insert into r_tours_participants values(null,".$_POST['tourid'].",".$_POST['plrid'].",".$_POST['posid'].",-1,0)");
		if ($res==1)
			echo "Η εισαγωγή στη βάση έγινε με επιτυχία!!";
		else
			echo "Η εισαγωγή στη βάση απέτυχε! Παρακαλώ ξαναπροσπαθήστε!";
	}
	else{
		echo "Iparxei idi kataxwrisi gia afton ton syndiasmo paikti - tournoua";
	}
	exit();
}
if (isset($_POST['insertTour'])){	
	//no automatic update. 
	//	updateRankings_insertTourPoints($_POST['tourid'],$_POST['sex']);
	//	updateRankings_insertCallPoints($_POST['tourid'],$_POST['sex']);
	//update points every monday
	$res=mysql_query("select * from r_tour_updates where tour_id=".$_POST['tourid']);
	if($row=mysql_fetch_object($res)){
		if($row->type==='remove'){//eksoudeterwse to remove
			mysql_query("delete from r_tour_updates where id=$row->id");
		}
	}
	else{//eisagwgi kanonika
		mysql_query("insert into r_tour_updates (type,tour_id) values ('insert',".$_POST['tourid'].")");
	}
	mysql_query("update r_tours set counts=1 where tour_id=".$_POST['tourid']);
	exit;
}
if (isset($_POST['removeTour'])){	
	//no automatic update. 
	//	updateRankings_removeTourPoints($_POST['tourid']);
	//	updateRankings_removeCallPoints($_POST['tourid']);
	//update points every monday
	$res=mysql_query("select * from r_tour_updates where tour_id=".$_POST['tourid']);
	if($row=mysql_fetch_object($res)){
		if($row->type==='insert'){//eksoudeterwse to insert
			mysql_query("delete from r_tour_updates where id=$row->id");
		}
	}
	else{//eisagwgi kanonika
		mysql_query("insert into r_tour_updates (type,tour_id) values ('remove',".$_POST['tourid'].")");
	}
	mysql_query("update r_tours set counts=-1 where tour_id=".$_POST['tourid']);	
	exit;
}
if (isset($_GET['tourname'])){
	$res=mysql_query("select * from r_tours where tour_name='".$_GET['tourname']."'");
	if (mysql_num_rows($res)==0){
		$date=$_GET['tourdate'];
		$newarr=explode('-',$date);
		$date=$newarr[2]."-".$newarr[1]."-".$newarr[0];
		$date2=$_GET['tourdateend'];
		$newarr=explode('-',$date2);
		$date2=$newarr[2]."-".$newarr[1]."-".$newarr[0];
		insertTour($_GET['tourname'],$date,$date2);
		echo "<script type='text/javascript'>$(document).ready(function(){alert('Η εισαγωγή του τουρνουά έγινε με επιτυχία!')});</script>";
	}
	else{
		echo "<script type='text/javascript'>$(document).ready(function(){alert('Η εισαγωγή του τουρνουά απέτυχε! Υπάρχει ήδη ένα τουρνουά με το ίδιο όνομα!')});</script>";
	}
}
if($_POST['sex']=="men"){
	$table="r_rankings";
	$sex=0;
}
else{
	$table="r_rankings_women";
	$sex=1;
}
if (isset($_POST['getPlrs'])){
	if ($_POST['tourid']==-1){
		if ($_POST['plrid']){
			$c1res=mysql_query("select r_tours_participants.tour_id,r_tours_participants.user_id,r_tours_participants.position_id from r_tours_participants inner join r_tours on r_tours_participants.tour_id = r_tours.tour_id  where r_tours_participants.user_id=".$_POST['plrid']." and sex=$sex order by r_tours.tour_date desc");
		}
		else{
			$c1res=mysql_query("select r_tours_participants.tour_id,r_tours_participants.user_id,r_tours_participants.position_id from r_tours_participants inner join r_tours on r_tours_participants.tour_id = r_tours.tour_id  where sex=$sex order by r_tours.tour_date desc");
		}
	}
	else{
		if ($_POST['plrid']){
			$c1res=mysql_query("select tour_id,user_id,position_id from r_tours_participants where ( sex=$sex and tour_id=".$_POST['tourid']." and user_id=".$_POST['plrid'].")");
		}
		else{
			$c1res=mysql_query("select tour_id,user_id,position_id from r_tours_participants where sex=$sex and tour_id=".$_POST['tourid']);
		}
	}
	$i=2;
	while ($trow=mysql_fetch_object($c1res)){
		if($i==2){
			?>
            <table class="list userList" cellpadding="0" cellspacing="0" border="1" width="430">
            	<tr>
                    <th width="151">Διοργάνωση</th><th width="191">Παίκτης</th><th>Θέση</th>
                </tr>
            <?php
		}
		?>    	
                <tr class="row<?= $i%2 ?>">
                    <td><?= fetch_tour_name($trow->tour_id) ?></td><td><?= fetch_player_name($trow->user_id) ?></td><td align="center"><?= fetch_position_name($trow->position_id) ?></td>
                </tr>
		<?php
			$i++;
	}
	if ($i==2){
		?>
	<table class="list userList" cellpadding="0" cellspacing="0" border="1" width="430" style="opacity: 0.5;">
        <tr>
            <th width="151">Διοργάνωση</th><th width="191">Παίκτης</th><th>Θέση</th>
        </tr>
		<tr class="row1">
            <td colspan="3">Δεν υπάρχει καταχώρηση</td>
        </tr>        
        <?php
	}
	?>
    </table>
    <?php
}
else{
?>
<script type="text/javascript" src="scripts/autocomplete.js"></script>
<script type="text/javascript" src="scripts/js/jquery-ui-1.8.17.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="scripts/css/smoothness/jquery-ui-1.8.17.custom.css">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200"><h1>Τουρνουά</h1></td>
    <td width="200">
    	<h1 style="padding-top: 23px;">	
            <select  class="textbox"id="searchTourselection" style="margin-bottom:1px">
                <option value="-1">Όλα τα τουρνουά</option>
            <?php
                $tr=mysql_query("select tour_name,tour_id from r_tours order by tour_date desc");
                while ($trow=mysql_fetch_object($tr)){
                    echo "<option value=\"".$trow->tour_id."\">".$trow->tour_name."</option>";
                }
            ?>
        	</select>
    	</h1>
    </td>
    <td>
    	<h1 style="padding-top: 23px;">	
	      <button id="promptForParticipants" type="button" class="button" style="display:inline; padding:0px; margin:0 -5px 1px 6px; vertical-align:bottom;"><img src="img/user-plus.png"/>Επιλέξτε</button>
      	<input type="text" class="textbox" id="playerselection_visible" style="margin-bottom:1px; height:17px;" value="Όλοι οι παίκτες" /><button class="textbox" id="clearSearch" style="cursor:pointer; visibility:hidden;">X</button>
        <input type="hidden" class="textbox" id="playerselection" style="margin-bottom:1px" value="0" />
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
							$('#playerselection').val(0);
						}
					});
					
					$('#playerselection_visible').userAutoComplete('ajax/autocomplete.php?type=user', function(ui) {
						$('#playerselection').val(ui.item.value);
						$('#clearSearch').css('visibility','visible');
						$('#searchTourselection').change();
          });
					$('#playerselection_visible').change(function(){
						if($(this).val()==''){
							$(this).val('Όλοι οι παίκτες');
							$('#playerselection').val(0);
							$('#clearSearch').css('visibility','hidden');
							$('#searchTourselection').change();
						}
					});
        </script>
    	</h1>
    </td>
  </tr>
</table>
<link rel="stylesheet" type="text/css" href="css/admin.css">
<link rel="stylesheet" type="text/css" href="inc/styles.css">
<table border="0" cellspacing="0" cellpadding="0" width="900">
  <tr>
  	<td align="center" width="430"><h2 style="border:0px solid">Ανδρών</h2></td>
    <td width="25">&nbsp;</td>
    <td align="center" width="430"><h2 style="border:0px solid">Γυναικών</h2></td>
    <td width="15">&nbsp;</td>
  </tr>
  <tr>
    <td width="430" id="foundtoursmen" valign="top" align="center"><div><img src="img/admin-ajax-indicator.gif" /></div></td>
    <td width="25">&nbsp;</td>
    <td width="430" id="foundtourswomen" valign="top" align="center"><div><img src="img/admin-ajax-indicator.gif" /></div></td>
    <td width="15">&nbsp;</td>
    <script type="text/javascript">
		$('#foundtoursmen').load("tournaments.php",{getPlrs:'ok',plrid:0,tourid:-1,sex: 'men'});
		$('#foundtourswomen').load("tournaments.php",{getPlrs:'ok',plrid:0,tourid:-1,sex: 'women'});
	</script>
  </tr>
</table>
<div id="participantDialog" title="Επιλογή παίκτη" class="dialog"></div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#searchTourselection, #playerselection').change(function(){
			$('#foundtoursmen').load("tournaments.php",{getPlrs:'ok',plrid:$('#playerselection').val(),tourid:$('#searchTourselection').val(), sex: "men"});
			$('#foundtourswomen').load("tournaments.php",{getPlrs:'ok',plrid:$('#playerselection').val(),tourid:$('#searchTourselection').val(), sex: "women"});
		});	
		$('#newtourform').submit(function(){
			if($('#tournameid').val()==''){
				alert('Dwste to onoma tou tournoua');
				$('#tournameid').focus();
				return false;
			}
			if($('#datepicker').val()==''){
				alert('Dwste imerominia enarksis tou tournoua');
				$('#datepicker').focus();
				return false;
			}
			if($('#datepicker_end').val()==''){
				alert('Dwste imerominia liksis tou tournoua');
				$('#datepicker_end').focus();
				return false;
			}
			var old_url=window.location.href;
			var new_url = old_url.substring(0, old_url.indexOf('&'));
			if (new_url=='')
				new_url=old_url;
			new_url=new_url+"&tourname="+$('#tournameid').val()+"&tourdate="+$('#datepicker').val()+"&tourdateend="+$('#datepicker_end').val();
			window.location.href=new_url;
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
				var new_url = old_url.substring(0, old_url.indexOf('&'));
				if (new_url=='')
					new_url=old_url;
				window.location.href=new_url;
				return false;
			});
		});
		$('#insertTourForm').submit(function(event){
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
			  data: { insertTour: "ok", tourid: $('#insertTourSelection').val()}
			}).done(function( msg ) {
				var old_url=window.location.href;
				var new_url = old_url.substring(0, old_url.indexOf('?'));
				if (new_url=='')
					new_url=old_url;
				window.location.href=new_url;
				return false;
			});
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
			if ($(this).val()==-1)
				return false;
			$('#foundtours').load("inc/editTours.php",{tourid:$(this).val()});
		});	
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
				url: 'ajax/autocomplete.php?type=user',
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
		$('#searchTourselection').change();
		$('#participantDialog').dialog('close');
	}
</script>
<?php
}
?>