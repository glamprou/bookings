<script type="text/javascript" src="scripts/autocomplete.js"></script>
<?php
@include_once('../config.php');	
@include_once('config.php');	
@include_once('../functions.php');
@include_once('functions.php');

if (isset($_POST['addPlr'])){
	mysql_query("insert into r_tours_participants values(null,".$_POST['tourid'].",".$_POST['plrid'].",".$_POST['plrpos'].",-1,".$_POST['sex'].")");
	exit();
}	
if (isset($_POST['remove'])){
	//echo $_POST['partid'];
	$res=mysql_query("select r_tours_positions.pos_points,r_tours_participants.user_id,r_tours_participants.countedToRank from r_tours_positions inner join r_tours_participants on r_tours_positions.position_id = r_tours_participants.position_id where r_tours_participants.tours_part_id=".$_POST['partid']);
	$res=mysql_fetch_object($res);
	if ($res->countedToRank==1){
		mysql_query("update r_rankings set rank_tot_points=rank_tot_points-$res->pos_points where rank_user_id=$res->user_id");
	}
	if ($res->countedToRank==1){
		mysql_query("update r_rankings_women set rank_tot_points=rank_tot_points-$res->pos_points where rank_user_id=$res->user_id");
	}
	mysql_query("delete from r_tours_participants where tours_part_id=".$_POST['partid']);
	sortRankings();
	exit();
}	
?>
<table width="860" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h2>Αντρών</h2></td>
    <td><h2>Γυναικών</h2></td>
  </tr>
  <tr>
    <td valign="top">
    	<table class="list userList" cellpadding="0" cellspacing="0" border="1">
            <tr>
                <th><?= fetch_tour_name($_POST['tourid']) ?></th>
                <th colspan="2" style="text-align:center !important;">
                    <button class="button updtThisTourBtn"  sex="0" style="margin:0px;">update ranking</button>
                </th>
            </tr>
            <tr class="row0">
                <th>Παίκτης</th>
                <th style=" text-align:center !important;">Θέση</th>
                <th>Επιλογές</th>
            </tr>
        <?php
        //$_POST['tourid'];
            $res=mysql_query("select users.fname,users.lname,r_tours_participants.position_id,r_tours_participants.user_id,r_tours_participants.countedToRank,r_tours_participants.tours_part_id from r_tours_participants inner join users on r_tours_participants.user_id = users.user_id where r_tours_participants.tour_id = ".$_POST['tourid']." and r_tours_participants.sex=0 order by r_tours_participants.position_id asc");
            $rowtmp=1;
            while($row=mysql_fetch_object($res)){
                $res2=mysql_query("select pos_description, position_id from r_tours_positions where position_id = $row->position_id");
                $row2=mysql_fetch_object($res2);
                ?>
                <tr class="row<?= $rowtmp%2 ?>">
                    <td><?php if($row->countedToRank==1) echo $row->fname." ".$row->lname; else echo "<div class='red' title='Δεν έχει ενημερωθεί στην κατάταξη'>$row->fname $row->lname</div>"; ?></td>
                    <td align="center"><?= $row2->pos_description ?></td>
                    <td align="center"><div class="btn delPart" sex="0" style="display:inline" value="<?= $row->tours_part_id ?>"><img src="img/cross-button.png" title="" alt=""  /></div></td>
                </tr>
                <?php	
                $rowtmp+=1;
            }
        ?>
                <tr>
                    <td>
                        <input type="text" class="textbox" id="choosenPlrToAdd_visible0" style="margin-bottom:1px; height:17px;" Placeholder="Αναζήτηση" /><button class="textbox" id="clearSearch0" style="cursor:pointer; visibility:hidden;">X</button>
                        <input type="hidden" class="textbox" id="choosenPlrToAdd0" style="margin-bottom:1px" value="0" />
                        <script type="text/javascript">
                          $('#clearSearch0').click(function(){
                             $(this).css('visibility','hidden');
                             $('#choosenPlrToAdd_visible0').val('');
                             $('#choosenPlrToAdd_visible0').change();
                          });
                          $('#choosenPlrToAdd_visible0').click(function(){
                            if($(this).val()!=''){
                              $(this).select();
                            }
                          });
                          
                          $('#choosenPlrToAdd_visible0').userAutoComplete('ajax/autocomplete.php?type=user&tourid=<?= $_POST['tourid'] ?>', function(ui) {
                            $('#choosenPlrToAdd0').val(ui.item.value);
                            $('#clearSearch0').css('visibility','visible');
                          });
                          $('#choosenPlrToAdd_visible0').change(function(){
                            if($(this).val()==''){
                              $('#choosenPlrToAdd0').val(0);
                              $('#clearSearch0').css('visibility','hidden');
                            }
                          });
                        </script>
                    </td>
                    <td>
                        <?php
                            if (!$i){
                        ?>
                                <select id="addPlrToThisTourSelectionPos0" class="textbox">
                                <?php
                                    if (!$i){
                                        $res3=mysql_query("select position_id, pos_description from r_tours_positions order by position_id asc");
                                        while ($row3=mysql_fetch_object($res3)){
                                            echo "<option value='$row3->position_id'>$row3->pos_description</option>";
                                        }
                                    }
                                ?>
                                </select>
                        <?php
                            }
                        ?>
                    </td>
                    <td align="center">
                        <?php 	
                            if (!$i){
                        ?>
                                <img class="btn addPlrToThisTourBtn" sex="0" src="img/plus-button.png" title="" alt=""  />
                        <?php
                            }
                        ?>
                    </td>
                </tr>
        </table>
    </td>
    <td valign="top">
    	<table class="list userList" cellpadding="0" cellspacing="0" border="1">
            <tr>
                <th><?= fetch_tour_name($_POST['tourid']) ?></th>
                <th colspan="2" style="text-align:center !important;">
                    <button class="button updtThisTourBtn"  sex="1" style="margin:0px;">update ranking</button>
                </th>
            </tr>
            <tr class="row0">
                <th>Παίκτης</th>
                <th style=" text-align:center !important;">Θέση</th>
                <th>Επιλογές</th>
            </tr>
        <?php
        //$_POST['tourid'];
            $res=mysql_query("select users.fname,users.lname,r_tours_participants.position_id,r_tours_participants.user_id,r_tours_participants.countedToRank,r_tours_participants.tours_part_id from r_tours_participants inner join users on r_tours_participants.user_id = users.user_id where r_tours_participants.tour_id = ".$_POST['tourid']."  and r_tours_participants.sex=1 order by r_tours_participants.position_id asc");
            $rowtmp=1;
            while($row=mysql_fetch_object($res)){
                $res2=mysql_query("select pos_description, position_id from r_tours_positions where position_id = $row->position_id");
                $row2=mysql_fetch_object($res2);
                ?>
                <tr class="row<?= $rowtmp%2 ?>">
                    <td><?php if($row->countedToRank==1) echo $row->fname." ".$row->lname; else echo "<div class='red' title='Δεν έχει ενημερωθεί στην κατάταξη'>$row->fname $row->lname</div>"; ?></td>
                    <td align="center"><?= $row2->pos_description ?></td>
                    <td align="center"><div class="btn delPart" sex="1" style="display:inline" value="<?= $row->tours_part_id ?>"><img src="img/cross-button.png" title="" alt=""  /></div></td>
                </tr>
                <?php	
                $rowtmp+=1;
            }
        ?>
                <tr>
                    <td>
                        <input type="text" class="textbox" id="choosenPlrToAdd_visible1" style="margin-bottom:1px; height:17px;" Placeholder="Αναζήτηση" /><button class="textbox" id="clearSearch1" style="cursor:pointer; visibility:hidden;">X</button>
                        <input type="hidden" class="textbox" id="choosenPlrToAdd1" style="margin-bottom:1px" value="0" />
                        <script type="text/javascript">
                          $('#clearSearch1').click(function(){
                             $(this).css('visibility','hidden');
                             $('#choosenPlrToAdd_visible1').val('');
                             $('#choosenPlrToAdd_visible1').change();
                          });
                          $('#choosenPlrToAdd_visible1').click(function(){
                            if($(this).val()!=''){
                              $(this).select();
                            }
                          });
                          
                          $('#choosenPlrToAdd_visible1').userAutoComplete('ajax/autocomplete.php?type=user&tourid=<?= $_POST['tourid'] ?>', function(ui) {
                            $('#choosenPlrToAdd1').val(ui.item.value);
                            $('#clearSearch1').css('visibility','visible');
                          });
                          $('#choosenPlrToAdd_visible1').change(function(){
                            if($(this).val()==''){
                              $('#choosenPlrToAdd1').val(0);
                              $('#clearSearch1').css('visibility','hidden');
                            }
                          });
                        </script>
                    </td>
                    <td>
                        <?php
                            if (!$i){
                        ?>
                                <select id="addPlrToThisTourSelectionPos1" class="textbox">
                                <?php
                                    if (!$i){
                                        $res3=mysql_query("select position_id, pos_description from r_tours_positions order by position_id asc");
                                        while ($row3=mysql_fetch_object($res3)){
                                            echo "<option value='$row3->position_id'>$row3->pos_description</option>";
                                        }
                                    }
                                ?>
                                </select>
                        <?php
                            }
                        ?>
                    </td>
                    <td align="center">
                        <?php 	
                            if (!$i){
                        ?>
                                <img class="btn addPlrToThisTourBtn" sex="1" src="img/plus-button.png" title="" alt=""  />
                        <?php
                            }
                        ?>
                    </td>
                </tr>
        </table>
    </td>
  </tr>
</table>

<script type="text/javascript">
$(document).ready(function(){
	$('.updtThisTourBtn').click(function(){
		$.ajax({
		  type: "POST",
		  url: "tournaments.php",
		  data: { insertTour: "ok", tourid: <?= $_POST['tourid'] ?>, sex: $(this).attr('sex') }
		}).done(function( msg ) {
			if ($(".success")[0]){
			   // Do something here if class exists
				$('.success').remove();
				$('#content').prepend('<div class="success" style="" id="profileUpdatedMessage">Η κατάταξη του τουρνουά <?= fetch_tour_name($_POST['tourid']) ?> ενημερώθηκε με επιτυχία!</div>');
			}
			else{
				$('#content').prepend('<div class="success" style="" id="profileUpdatedMessage">Η κατάταξη του τουρνουά <?= fetch_tour_name($_POST['tourid']) ?> ενημερώθηκε με επιτυχία!</div>');
			}
			$('#selTourForEdit').change();
			return false;
		});
	});
	$('.delPart').click(function(){
		var con= confirm('Αφαίρεση παίκτη;');
		if (!con)
			return false;
		
		$.ajax({
		  type: "POST",
		  url: "editToursOnly.php",
		  data: { remove: "ok", partid: $(this).attr('value'), sex: $(this).attr('sex')}
		}).done(function( msg ) {
		 	$('#selTourForEdit').change();
			return false;
		});
	});
	$('.addPlrToThisTourBtn').click(function(){
		var sex=$(this).attr('sex');
		$.ajax({
		  type: "POST",
		  url: "editToursOnly.php",
		  data: { addPlr: "ok", plrid: $('#choosenPlrToAdd'+sex).val(), plrpos: $('#addPlrToThisTourSelectionPos'+sex).val(), tourid: <?= $_POST['tourid'] ?>, sex: sex}
		}).done(function( msg ) {
		 	$('#selTourForEdit').change();
			return false;
		});
	});
});
</script>