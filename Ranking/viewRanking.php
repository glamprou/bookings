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
<div class="rankingDiv">
    <table class="list userList" width="780" style="min-width: 575px;">
         <tr align="center">
            <th width="51">Θέση</th>
            <th>Παίκτες</th>
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
                <td style="padding-right: 2px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td style="border: 0px solid; padding-left: 10px;" align="left"><?= $plr->fullname ?></td>
                            <?php
                                if (isBlocked($plr->user_id)){
                                    ?>
                                    <td style="border: 0px solid; color:#F47D3D ;" width="42"><div class="inline" style="cursor:default;" title="Ο παίκτης είναι μπλοκαρισμένος και δεν μπορεί προς το παρών να προσκαλεστεί">BLOCKED</div></td>
                                    <script type="text/javascript">
                                        $('td[userid="<?= $plr->user_id ?>"]').css('color','#F47D3D ');
                                    </script>
                                <?php
                                }
                                if (isInjured($plr->user_id)){
                                    ?>
                                    <td style="border: 0px solid; color:#3375a9;" width="42"><div class="inline" style="cursor:default;" title="Ο παίκτης είναι τραυματίας και δεν μπορεί προς το παρών να προσκαλεστεί" >INJURED</div></td>
                                    <script type="text/javascript">
                                        $('td[userid="<?= $plr->user_id ?>"]').css('color','#3375a9');
                                    </script>
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
                        <td style="border: 0px solid;" width="33%" align="center" id="showLast5Matches"><div title="Τελευταίοι 5 αγώνες" class="tip inline" rel="Τελευταίοι 5 αγώνες" >L5M</div></td>
                        <td style="border: 0px solid;" width="33%" align="center" id="showPlrStats"><div title="Στατιστικά παίκτη" class="tip inline" rel="Αναλυτικά στατιστικά παίκτη<br /> (Win rates, Sets, Games, etc.)" >STATS</div></td>
                        <td style="border: 0px solid;" width="33%" align="center" id="showLastTourPos"><div title="Θέση στο τελευταίο τουρνουά" class="tip inline" rel="Θέση στην τελευταία συμμετοχή σε τουρνουά" >LTP</div></td>
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
});
</script>
</div>