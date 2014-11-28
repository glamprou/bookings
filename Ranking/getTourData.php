<?php
define('ROOT_DIR', '../');
require_once(ROOT_DIR . 'config/config.php');
require_once(ROOT_DIR . 'Ranking/functions.php');
require_once(ROOT_DIR . 'lib/Common/ServiceLocator.php');

if(isset($_POST['action']) && $_POST['action']=='ajax'){
    $rid=(int)$_POST['rid'];
    $plrid=(int)$_POST['plrid'];
    $tourid=(int)$_POST['tourid'];
    
    if($tourid<=0){
        $tourid=NULL;
    }
    if($plrid<=0){
        $plrid=NULL;
    }
    getTourData($rid, $tourid, $plrid);
}

function getTourData($rid, $tourid=NULL, $plrid=NULL){
    $db=ServiceLocator::GetDatabase();
    $db->Connection->Connect();  

    if (!$tourid){
        if ($plrid){
            $c1res=mysql_query("select r_tours_participants.tour_id,r_tours_participants.user_id,r_tours_participants.position_id from r_tours_participants inner join r_tours on r_tours_participants.tour_id = r_tours.tour_id  where r_tours_participants.user_id=$plrid and ranking_id=$rid order by r_tours.tour_date desc");
        }
        else{
            $c1res=mysql_query("select r_tours_participants.tour_id,r_tours_participants.user_id,r_tours_participants.position_id from r_tours_participants inner join r_tours on r_tours_participants.tour_id = r_tours.tour_id  where ranking_id=$rid order by r_tours.tour_date desc");
        }
    }
    else{
        if ($plrid){
            $c1res=mysql_query("select tour_id,user_id,position_id from r_tours_participants where ( ranking_id=$rid and tour_id=$tourid and user_id=".$_POST['plrid'].")");
        }
        else{
            $c1res=mysql_query("select tour_id,user_id,position_id from r_tours_participants where ranking_id=$rid and tour_id=$tourid");
        }
    }
    $i=1;
    while ($trow=mysql_fetch_object($c1res)){
        if($i==1){
            ?>
            <table class="list userList" cellpadding="0" cellspacing="0" border="1" width="430">
                <tr>
                    <th width="151" style="text-align: left;">Διοργάνωση</th><th width="191" style="text-align: left;">Παίκτης</th><th>Θέση</th>
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
    if ($i==1){
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