<?php
/*
 * afto to arxeio periexei oles tis sinartiseis pou epistrefoun times apo tin 
 * parametropoiisi tis efarmogis alla kai alles global synartiseis
 */

/*
 * 
 * 
 * 
 * 
 * global functions
 * 
 * 
 * 
 * 
 */

/*
 * styled var_dump with optional exit parameter
 */
function anal($var, $exit = false){
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    if ($exit) {
        exit();
    }
}
/**
 * vriskei to ranking table pou anoikei o paiktis. An den iparxei se kanena tote FALSE
 * @param int $userid
 * @return string|FALSE
 */
function getRankingId($userid){
    $rankings=pdoq("select ranking_id,ranking_table_name from r_rankings");
    foreach($rankings as $ranking){
        $exists=pdoq("select rank_id from $ranking->ranking_table_name where rank_user_id=?",$userid);
        if($exists){
            return $ranking->ranking_id;
        }
    }
    return FALSE;
}
function getRankingTable($userid){
    $rankings=pdoq("select ranking_table_name from r_rankings");
    foreach($rankings as $ranking){
        $exists=pdoq("select rank_id from $ranking->ranking_table_name where rank_user_id=?",$userid);
        if($exists){
            return $ranking->ranking_table_name;
        }
    }
    return FALSE;
}
function getRankingName($userid){
    $rankings=pdoq("select ranking_table_name, ranking_name from r_rankings");
    foreach($rankings as $ranking){
        $exists=pdoq("select rank_id from $ranking->ranking_table_name where rank_user_id=?",$userid);
        if($exists){
            return $ranking->ranking_name;
        }
    }
    return FALSE;
}

/**
 * 
 * @param int $userid
 * @return FALSE|int
 */
function getPlayerPosition($userid) {
    $ranking_table_name=getRankingTable($userid);
    if(!$ranking_table_name) return FALSE;
    
    $plrPos=pdoq("select rank_pos from $ranking_table_name where rank_user_id=?",$userid);

    return $plrPos[0]->rank_pos;
}
/**
 * afairei tin wra apo datetime
 */
function datetimeToDate($datetime){
    $tmp=explode(" ",$datetime);
    return $tmp[0];
}

/**
 * true an to series id einai training false diaforetika
 * @param $seriesId
 * @return bool
 */
function isTraining($seriesId){
    $row=pdoq("select particular_type from reservation_details where series_id=?", $seriesId);

    if($row && $row[0]->particular_type=='training'){
        return TRUE;
    }

    return FALSE;
}

function isCancelledTraining($seriesId){
    $row=pdoq("select cancelledTraining from reservation_details where series_id=?", $seriesId);

    if($row && $row[0]->cancelledTraining){
        return $row[0]->cancelledTraining;
    }

    return false;
}

/**
 * true an einai open reservation, false alliws
 * @param $referenceNumber
 * @return bool
 */
function isOpenRes($referenceNumber){
    $row=pdoq("select * from open_reservations where reference_number=?", $referenceNumber);

    if($row){
        return TRUE;
    }

    return FALSE;
}

/*
 * 
 * 
 * 
 * 
 * System Preferences functions
 * 
 * 
 * 
 * 
 */

/*
 * return: number (int or float) epistrefei ta elaxista defterolepta pou prepei 
 * na apexei i kratisi gia na mporei na ginei edit apo aplo xristi an parei 
 * orisma true, epistrefei tin idia timi se wres
 */
function sp_get_min_edit_time_seconds($hours=false){
    $row=pdoq("select min_edit_time_seconds from system_preferences");

    if ($hours) {
        return $row[0]->min_edit_time_seconds / 3600;
    } else {
        return $row[0]->min_edit_time_seconds;
    }
}

/*
 * return: boolean an mporei o coach na epeksergastei kratisi pou ksekinaei 
 * syntoma ( < edit_time )
 */
function sp_too_soon_coach_edit(){
    $row=pdoq("select too_soon_coach_edit from system_preferences");
    return $row[0]->too_soon_coach_edit==1;
}

/*
 * return: epistrefei megisti apostasi se theseis katataksis (pros ta panw sto 
 * ranking) gia na mporei na ginei to call
 */
function sp_max_call_distance_up(){
    $row=pdoq("select max_call_distance_up from system_preferences");
    return $row[0]->max_call_distance_up;
}

/*
 * return: epistrefei megisti apostasi se theseis katataksis (pros ta katw sto 
 * ranking) gia na mporei na ginei to call
 */
function sp_max_call_distance_down(){
    $row=pdoq("select max_call_distance_up from system_preferences");
    return $row[0]->max_call_distance_down;
}

/*
 * return: boolean an einai blockarismena ta calls
 */
function sp_calls_block(){
    $row=pdoq("select calls_block from system_preferences");
    return $row[0]->calls_block==1;
}

/*
 * return: int, arithmos imerwn pou prepei na perasoun gia idio call me paiktes 
 * pou ksanapaiksan
 */
function sp_numofdays_same_call(){
    $row=pdoq("select numofdays_same_call from system_preferences");
    return $row[0]->numofdays_same_call;
}

/*
 * return: int, arithmos imerwn pou prepei na perasoun gia idio call (to opoio exei akyrwthei) 
 * me paiktes pou ksanapaiksan
 */
function sp_numofdays_same_cancelled_call(){
    $row=pdoq("select numofdays_same_cancelled_call from system_preferences");
    return $row[0]->numofdays_same_cancelled_call;
}