<?php
@include_once('../config.php');	
@include_once('config.php');	
@include_once('../functions.php');
@include_once('functions.php');

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
            <th>Παίκτες</th>
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
					if (isBlocked($row->rank_user_id)){
							?>
							<td style="border: 0px solid; color:#F47D3D ;" width="42"><div class="inline" style="cursor:default;" title="Ο παίκτης είναι μπλοκαρισμένος και δεν μπορεί προς το παρών να προσκαλεστεί">BLOCKED</div></td>
                            <script type="text/javascript">
								$('td[userid="<?= $row->rank_user_id ?>"]').css('color','#F47D3D ');
							</script>
              <?php
					}
					if (isInjured($row->rank_user_id)){
					
						?>
						<td style="border: 0px solid; color:#3375a9;" width="42"><div class="inline" style="cursor:default;" title="Ο παίκτης είναι τραυματίας και δεν μπορεί προς το παρών να προσκαλεστεί" >INJURED</div></td>
													<script type="text/javascript">
							$('td[userid="<?= $row->rank_user_id ?>"]').css('color','#3375a9');
						</script>
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
                    <td style="border: 0px solid;" width="33%" align="center" id="showLast5Matches"><div title="Τελευταίοι 5 αγώνες" class="tip inline" rel="Τελευταίοι 5 αγώνες" >L5M</div></td>
                    <td style="border: 0px solid;" width="33%" align="center" id="showPlrStats"><div title="Αναλυτικά στατιστικά παίκτη<br />(Win rates, Sets, Games, etc.)" class="tip inline" rel="Αναλυτικά στατιστικά παίκτη<br /> (Win rates, Sets, Games, etc.)" >STATS</div></td>
                    <td style="border: 0px solid;" width="33%" align="center" id="showLastTourPos"><div title="Θέση στην τελευταία συμμετοχή σε τουρνουά" class="tip inline" rel="Θέση στην τελευταία συμμετοχή σε τουρνουά" >LTP</div></td>
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
	$('#chooseRanking').change(function(){
		var old_url=window.location.href;
		var new_url = old_url.substring(0, old_url.indexOf('?'));
		if (new_url=='')
			new_url=old_url;
		new_url+="?sex="+$(this).val();
		window.location.href=new_url;
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
			content: $(this).attr('rel'),
			show: {
			event: 'mouseover'
			}
				
		}); 
	});
});
$('.sticky_tip').each(function(){
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
			text: 'Αναλυτικό προφίλ παίκτη<br />(Career Heightest Rank, Weeks at No1, Titles, History, etc.)'},
			show: {
			event: 'click'
			}
		}); 
	});
</script>
</div>