<script type="text/javascript" src="scripts/autocomplete.js"></script>
<?php
define('ROOT_DIR', '../');
require_once(ROOT_DIR . 'config/config.php');
require_once(ROOT_DIR . 'Ranking/functions.php');
require_once(ROOT_DIR . 'lib/Common/ServiceLocator.php');

$db=ServiceLocator::GetDatabase();
$db->Connection->Connect(); 

?>
<table width="860" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h2>Ανδρών</h2></td>
    <td><h2>Γυναικών</h2></td>
  </tr>
  <tr>
    <td valign="top">
    	<table class="list userList" cellpadding="0" cellspacing="0" border="1">
            <tr>
                <th><?= fetch_tour_name($_POST['tourid']) ?></th>
                <th colspan="2" style="text-align:center !important;">
                    <button class="button updtThisTourBtn"  ranking="1" style="margin:0px;">update ranking</button>
                </th>
            </tr>
            <tr class="row0">
                <th>Παίκτης</th>
                <th style=" text-align:center !important;">Θέση</th>
                <th>Επιλογές</th>
            </tr>
        <?php
        //$_POST['tourid'];
            $res=mysql_query("select users.fname,users.lname,r_tours_participants.position_id,r_tours_participants.user_id,r_tours_participants.countedToRank,r_tours_participants.tours_part_id from r_tours_participants inner join users on r_tours_participants.user_id = users.user_id where r_tours_participants.tour_id = ".$_POST['tourid']." and r_tours_participants.ranking_id=1 order by r_tours_participants.position_id asc");
            $rowtmp=1;
            while($row=mysql_fetch_object($res)){
                $res2=mysql_query("select pos_description, position_id from r_tours_positions where position_id = $row->position_id");
                $row2=mysql_fetch_object($res2);
                ?>
                <tr class="row<?= $rowtmp%2 ?>">
                    <td><?php if($row->countedToRank==1) echo $row->fname." ".$row->lname; else echo "<div class='red' title='Δεν έχει ενημερωθεί στην κατάταξη'>$row->fname $row->lname</div>"; ?></td>
                    <td align="center"><?= $row2->pos_description ?></td>
                    <td align="center"><div class="btn delPart" ranking="1" style="display:inline" value="<?= $row->tours_part_id ?>"><img src="img/cross-button.png" title="" alt=""  /></div></td>
                </tr>
                <?php	
                $rowtmp+=1;
            }
        ?>
                <tr>
                    <td>
                        <input type="text" class="textbox" id="choosenPlrToAdd_visible1" style="margin-bottom:1px; height:17px;" Placeholder="Αναζήτηση" /><button class="textbox" id="clearSearch0" style="cursor:pointer; visibility:hidden;">X</button>
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
                                <img class="btn addPlrToThisTourBtn" ranking="1" src="img/plus-button.png" title="" alt=""  />
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
                    <button class="button updtThisTourBtn"  ranking="2" style="margin:0px;">update ranking</button>
                </th>
            </tr>
            <tr class="row0">
                <th>Παίκτης</th>
                <th style=" text-align:center !important;">Θέση</th>
                <th>Επιλογές</th>
            </tr>
        <?php
        //$_POST['tourid'];
            $res=mysql_query("select users.fname,users.lname,r_tours_participants.position_id,r_tours_participants.user_id,r_tours_participants.countedToRank,r_tours_participants.tours_part_id from r_tours_participants inner join users on r_tours_participants.user_id = users.user_id where r_tours_participants.tour_id = ".$_POST['tourid']."  and r_tours_participants.ranking_id=2 order by r_tours_participants.position_id asc");
            $rowtmp=1;
            while($row=mysql_fetch_object($res)){
                $res2=mysql_query("select pos_description, position_id from r_tours_positions where position_id = $row->position_id");
                $row2=mysql_fetch_object($res2);
                ?>
                <tr class="row<?= $rowtmp%2 ?>">
                    <td><?php if($row->countedToRank==1) echo $row->fname." ".$row->lname; else echo "<div class='red' title='Δεν έχει ενημερωθεί στην κατάταξη'>$row->fname $row->lname</div>"; ?></td>
                    <td align="center"><?= $row2->pos_description ?></td>
                    <td align="center"><div class="btn delPart" ranking="2" style="display:inline" value="<?= $row->tours_part_id ?>"><img src="img/cross-button.png" title="" alt=""  /></div></td>
                </tr>
                <?php	
                $rowtmp+=1;
            }
        ?>
                <tr>
                    <td>
                        <input type="text" class="textbox" id="choosenPlrToAdd_visible3" style="margin-bottom:1px; height:17px;" Placeholder="Αναζήτηση" /><button class="textbox" id="clearSearch1" style="cursor:pointer; visibility:hidden;">X</button>
                        <input type="hidden" class="textbox" id="choosenPlrToAdd3" style="margin-bottom:1px" value="0" />
                        <script type="text/javascript">
                          $('#clearSearch3').click(function(){
                             $(this).css('visibility','hidden');
                             $('#choosenPlrToAdd_visible3').val('');
                             $('#choosenPlrToAdd_visible3').change();
                          });
                          $('#choosenPlrToAdd_visible3').click(function(){
                            if($(this).val()!=''){
                              $(this).select();
                            }
                          });
                          
                          $('#choosenPlrToAdd_visible3').userAutoComplete('ajax/autocomplete.php?type=user&tourid=<?= $_POST['tourid'] ?>', function(ui) {
                            $('#choosenPlrToAdd3').val(ui.item.value);
                            $('#clearSearch3').css('visibility','visible');
                          });
                          $('#choosenPlrToAdd_visible3').change(function(){
                            if($(this).val()==''){
                              $('#choosenPlrToAdd3').val(0);
                              $('#clearSearch3').css('visibility','hidden');
                            }
                          });
                        </script>
                    </td>
                    <td>
                        <?php
                            if (!$i){
                        ?>
                                <select id="addPlrToThisTourSelectionPos3" class="textbox">
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
                                <img class="btn addPlrToThisTourBtn" ranking="2" src="img/plus-button.png" title="" alt=""  />
                        <?php
                            }
                        ?>
                    </td>
                </tr>
        </table>
    </td>
  </tr>
  <tr>
      <td colspan="2" height="10"></td>
  </tr>
<?php /*?>  <tr> 
    <td><h2>Ανδρών 45+</h2></td>
    <td></td>
  </tr>
  <tr>
    <td valign="top">
    	<table class="list userList" cellpadding="0" cellspacing="0" border="1">
            <tr>
                <th><?= fetch_tour_name($_POST['tourid']) ?></th>
                <th colspan="2" style="text-align:center !important;">
                    <button class="button updtThisTourBtn"  ranking="2" style="margin:0px;">update ranking</button>
                </th>
            </tr>
            <tr class="row0">
                <th>Παίκτης</th>
                <th style=" text-align:center !important;">Θέση</th>
                <th>Επιλογές</th>
            </tr>
        <?php
        //$_POST['tourid'];
            $res=mysql_query("select users.fname,users.lname,r_tours_participants.position_id,r_tours_participants.user_id,r_tours_participants.countedToRank,r_tours_participants.tours_part_id from r_tours_participants inner join users on r_tours_participants.user_id = users.user_id where r_tours_participants.tour_id = ".$_POST['tourid']." and r_tours_participants.ranking_id=2 order by r_tours_participants.position_id asc");
            $rowtmp=1;
            while($row=mysql_fetch_object($res)){
                $res2=mysql_query("select pos_description, position_id from r_tours_positions where position_id = $row->position_id");
                $row2=mysql_fetch_object($res2);
                ?>
                <tr class="row<?= $rowtmp%2 ?>">
                    <td><?php if($row->countedToRank==1) echo $row->fname." ".$row->lname; else echo "<div class='red' title='Δεν έχει ενημερωθεί στην κατάταξη'>$row->fname $row->lname</div>"; ?></td>
                    <td align="center"><?= $row2->pos_description ?></td>
                    <td align="center"><div class="btn delPart" ranking="2" style="display:inline" value="<?= $row->tours_part_id ?>"><img src="img/cross-button.png" title="" alt=""  /></div></td>
                </tr>
                <?php	
                $rowtmp+=1;
            }
        ?>
                <tr>
                    <td>
                        <input type="text" class="textbox" id="choosenPlrToAdd_visible2" style="margin-bottom:1px; height:17px;" Placeholder="Αναζήτηση" /><button class="textbox" id="clearSearch0" style="cursor:pointer; visibility:hidden;">X</button>
                        <input type="hidden" class="textbox" id="choosenPlrToAdd2" style="margin-bottom:1px" value="0" />
                        <script type="text/javascript">
                          $('#clearSearch2').click(function(){
                             $(this).css('visibility','hidden');
                             $('#choosenPlrToAdd_visible2').val('');
                             $('#choosenPlrToAdd_visible2').change();
                          });
                          $('#choosenPlrToAdd_visible2').click(function(){
                            if($(this).val()!=''){
                              $(this).select();
                            }
                          });
                          
                          $('#choosenPlrToAdd_visible2').userAutoComplete('ajax/autocomplete.php?type=user&tourid=<?= $_POST['tourid'] ?>', function(ui) {
                            $('#choosenPlrToAdd2').val(ui.item.value);
                            $('#clearSearch2').css('visibility','visible');
                          });
                          $('#choosenPlrToAdd_visible2').change(function(){
                            if($(this).val()==''){
                              $('#choosenPlrToAdd2').val(0);
                              $('#clearSearch2').css('visibility','hidden');
                            }
                          });
                        </script>
                    </td>
                    <td>
                        <?php
                            if (!$i){
                        ?>
                                <select id="addPlrToThisTourSelectionPos2" class="textbox">
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
                                <img class="btn addPlrToThisTourBtn" ranking="2" src="img/plus-button.png" title="" alt=""  />
                        <?php
                            }
                        ?>
                    </td>
                </tr>
        </table>
    </td>
    <td></td>
  </tr><?php */?>
</table>

<script type="text/javascript">
$(document).ready(function(){
	$('.updtThisTourBtn').click(function(){
		$.ajax({
		  type: "POST",
		  url: "../Ranking/ajax.php",
		  data: { action: "insertTour", tourid: <?= $_POST['tourid'] ?>, ranking: $(this).attr('ranking') }
		}).done(function( msg ) {
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
		  url: "../Ranking/ajax.php",
		  data: { action: "removeTourPart", partid: $(this).attr('value'), ranking: $(this).attr('ranking')}
		}).done(function( msg ) {
		 	$('#selTourForEdit').change();
			return false;
		});
	});
	$('.addPlrToThisTourBtn').click(function(){
		var ranking=$(this).attr('ranking');
		$.ajax({
		  type: "POST",
		  url: "../Ranking/ajax.php",
		  data: { action: "insertTourPart", plrid: $('#choosenPlrToAdd'+ranking).val(), plrpos: $('#addPlrToThisTourSelectionPos'+ranking).val(), tourid: <?= $_POST['tourid'] ?>, ranking: ranking}
		}).done(function( msg ) {
		 	$('#selTourForEdit').change();
			return false;
		});
	});
});
</script>