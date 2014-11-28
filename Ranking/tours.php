<?php
require_once(ROOT_DIR . 'Ranking/getTourData.php');
?>
<link rel="stylesheet" type="text/css" href="../Ranking/styles.css">
<script type="text/javascript" src="scripts/autocomplete.js"></script>
<link rel="stylesheet" type="text/css" href="scripts/css/smoothness/jquery-ui-1.8.17.custom.css">
<link rel="stylesheet" type="text/css" href="css/admin.css">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="300"><h1>Τουρνουά</h1></td>
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
					
					$('#playerselection_visible').userAutoComplete('ajax/autocomplete.php?type=user&onlyActive=true', function(ui) {
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
<div style="width: 910px; overflow: hidden;">
    <div style="width: 455px; float: left">
    <?php
    $rows=pdoq("select * from r_rankings order by ranking_id asc");
    $i=0;
    foreach ($rows as $row){
        if($i==2){
            echo '</div><div style="width: 455px; float: left">';
        }
        ?>
        <div class="rdiv" rid="<?php echo $row->ranking_id ?>" style="float: left; width: 430px; margin-bottom: 25px;">
            <div style="text-align: center;"><h2 style="border:0px solid"><?php echo $row->ranking_name ?></h2></div>
            <div class="table_container" rid="<?php echo $row->ranking_id ?>">
                <?php
                getTourData($row->ranking_id);
                ?>
            </div>
        </div>
        <?php
        $i++;
    }
    ?>
    </div>
</div>
<div id="participantDialog" title="Επιλογή παίκτη" class="dialog"></div>
<script type="text/javascript">
	$(document).ready(function(){
        $('#searchTourselection, #playerselection').change(function(){   
            $('.table_container').each(function(){
                $(this).load('../Ranking/getTourData.php',{action: 'ajax',rid: $(this).attr('rid'),plrid:$('#playerselection').val(),tourid:$('#searchTourselection').val()});
            });
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
				url: 'ajax/autocomplete.php?type=user&onlyActive=true',
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