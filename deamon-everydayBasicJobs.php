<?php
define('ROOT_DIR','');

date_default_timezone_set ('UTC');

require_once(ROOT_DIR . 'config/config.php');
require_once(ROOT_DIR . 'Ranking/functions.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Common/ServiceLocator.php');
require_once(ROOT_DIR . 'emailSendOrSchedule.php');


$today = date("Y-m-d");
$userrep=new UserRepository();
/*
 * Everyday (one time) functions
 */
checkCallsBlock($today);
completedPlayerBlocks($today);
decreaseDeclines($today);
acceptDeclineEmailAndPenaltyHandler($today, $userrep);
outdatedCallsPenalty($today);
insertCallDateReminderEmail($today, $userrep);
insertCallScoreReminderEmail($today, $userrep);

/*
 * Only Monday (one time) functions
 */
if(date('w') == 1){
	//echo "today is Monday!<br>";
    saveLastWeeksRank();
    removePoints();
    addPoints();
    handleTourPoints();
    sortRankings();
    saveHeighestRank();
}

//
//
//
//
//
//
//
//
//
//
//
//
//
////////////////////////////
//function implementations//
////////////////////////////
//
//

/**
 * Elegxei ean prepei na blockaristoun ta calls k an nai ta mplokarei kai akyrwnei ta mi oloklirwmena
 * @param $todayDate string
 */
function checkCallsBlock($todayDate){
    $row=pdoq("select * from r_blocks");
    if ($row[0]->calls_block_scheduled){
        if ($row[0]->calls_block_schedule==$todayDate){
            pdoq("update r_blocks set calls_block = 1, calls_block_scheduled = 0, calls_block_schedule = NULL where 1");//block calls
            pdoq("update r_calls set call_accepted = -1 where (call_accepted = 0 or call_completed=0)");//cancel all open calls
        }
    }
    else if($row[0]->calls_block){
        pdoq("update r_calls set call_accepted = -1 where (call_accepted = 0 or call_completed=0)");//cancel all open calls
    }
}

/**
 * Elegxei k ksemplokarei tous paiktes pou exei teleiwsei i periodos pou einai blocked
 * @param $todayDate string
 */
function completedPlayerBlocks($todayDate){
    $rows=pdoq("select * from r_user_blocks");

    foreach($rows as $row){
        if ($row->bl_end==$todayDate){
            pdoq("delete from r_user_blocks where user_id=?",$row->user_id);//unblock player
        }
    }
}

/**
 * Meiwnei kata 1 ta declines stous xristes pou simera einai i bonus date tous.
 * Kanei NULL tin bonus date an o xristis eixe 1 decline k tha meiwthei se miden.
 * @param $todayDate string
 */
function decreaseDeclines($todayDate){
    $rows=pdoq("select * from r_numofdeclines where bonus_date=? and numofdeclines>0",$todayDate);
    foreach($rows as $row){
        $thirty_days_later=date("Y-m-d",strtotime("+ 30 days"));
        if($row->numofdeclines==1){
            pdoq("update r_numofdeclines set numofdeclines=numofdeclines-1, bonus_date=NULL where user_id=?",$row->user_id);
        }
        else{
            pdoq("update r_numofdeclines set numofdeclines=numofdeclines-1, bonus_date=? where user_id=?", array($thirty_days_later, $row->user_id));
        }
    }
}

/**
 * Stelnei email ypenthymisis kai dinei poines analogws ti mera oswn afora ta argoporimena accept/declines
 * @param $todayDate string
 * @param $userrep UserRepository
 */
function acceptDeclineEmailAndPenaltyHandler($todayDate, $userrep){
    $todayTimestamp=strtotime($todayDate);

    $rows=pdoq("select * from r_calls where call_accepted = 0");
    foreach($rows as $row){
        /**
         * TODO ta parakatw deadlines, kathws k afta twn allwn sinartisewn na ginoun dinamika
         * kathws se kathe club tha exoun alles times
         */
        $acceptDeclineTomorrowDeadline=strtotime('+4 days',strtotime($row->call_date));
        $acceptDeclineTodayDeadline=strtotime('+5 days',strtotime($row->call_date));
        $acceptDeclinePenaltyDeadline=strtotime('+6 days',strtotime($row->call_date));

        if($todayTimestamp>=$acceptDeclinePenaltyDeadline){
            givePenalty($row->callee_user_id, true);
            pdoq("update r_calls set call_accepted=-1 where call_id =?",$row->call_id);
        }
        else if($todayTimestamp>=$acceptDeclineTodayDeadline){
            $callee=$userrep->LoadById($row->callee_user_id);
            $caller=$userrep->LoadById($row->caller_user_id);

            $db=ServiceLocator::GetDatabase();
            $db->Connection->Connect();
            sendOrSchedule("CallReminderTodayEmail",$callee,$caller);
        }
        else if($todayTimestamp>=$acceptDeclineTomorrowDeadline){
            $callee=$userrep->LoadById($row->callee_user_id);
            $caller=$userrep->LoadById($row->caller_user_id);

            $db=ServiceLocator::GetDatabase();
            $db->Connection->Connect();
            sendOrSchedule("CallReminderTomorrowEmail",$callee,$caller);
        }
    }
}

/**
 * Elegxei ta calls pou den exoun oloklirwthei mesa ston epitrepto xrono,
 * ta akyrwnei, kai dinei penalty (an exoun arketa anoixta games den pairnoun poini) stous paiktes
 * @param $todayDate string
 */
function outdatedCallsPenalty($todayDate){
    $todayTimestamp=strtotime($todayDate);

    $rows=pdoq("select * from r_calls where call_accepted = 1 and call_completed=0");
    foreach($rows as $row){
        $dateScorePenaltyDeadline=strtotime('+13 days',strtotime($row->call_date));
        if($todayTimestamp>=$dateScorePenaltyDeadline){
            givePenalty($row->caller_user_id,false);//true for ignoring if has 2 open calls
            givePenalty($row->callee_user_id,false);
            pdoq("update r_calls set call_accepted=-1 where call_id = ?",$row->call_id);
        }
    }
}

/**
 * Stelnei email ypenthymisis stous paiktes twn calls pou prepei simera i avrio na exei dilwthei i mera dieksagwgis tous
 * @param $todayDate string
 * @param $userrep UserRepository
 */
function insertCallDateReminderEmail($todayDate, $userrep){
    $todayTimestamp=strtotime($todayDate);

    $rows=pdoq("select * from r_calls where call_accepted=1 and match_date IS NULL");
    foreach($rows as $row){
        $dateScorePenaltyDeadline=strtotime('+13 days',strtotime($row->call_date));
        $dateScoreTodayDeadline=strtotime('+12 days',strtotime($row->call_date));
        $dateScoreTomorrowDeadline=strtotime('+11 days',strtotime($row->call_date));
        if($todayTimestamp>=$dateScoreTodayDeadline && $todayTimestamp<$dateScorePenaltyDeadline){
            $callee=$userrep->LoadById($row->callee_user_id);
            $caller=$userrep->LoadById($row->caller_user_id);

            $db=ServiceLocator::GetDatabase();
            $db->Connection->Connect();
            sendOrSchedule("InsertCallDateTodayEmail",$callee,$caller,TRUE);
        }
        else if($todayTimestamp>=$dateScoreTomorrowDeadline && $todayTimestamp<$dateScorePenaltyDeadline){
            $callee=$userrep->LoadById($row->callee_user_id);
            $caller=$userrep->LoadById($row->caller_user_id);

            $db=ServiceLocator::GetDatabase();
            $db->Connection->Connect();
            sendOrSchedule("InsertCallDateTomorrowEmail",$callee,$caller,TRUE);
        }
    }
}

/**
 * Stelnei email ypenthymisis stous paiktes twn calls pou prepei simera i avrio na exei dilwthei to score tous
 * @param $todayDate string
 * @param $userrep UserRepository
 */
function insertCallScoreReminderEmail($todayDate, $userrep){
    $todayTimestamp=strtotime($todayDate);

    /*insert call score email reminder*/
    $rows=pdoq("select * from r_calls where call_accepted=1 and call_completed=0 and match_date is not null");
    foreach($rows as $row){
        $dateScorePenaltyDeadline=strtotime('+13 days',strtotime($row->call_date));
        $dateScoreTodayDeadline=strtotime('+12 days',strtotime($row->call_date));
        $dateScoreTomorrowDeadline=strtotime('+11 days',strtotime($row->call_date));
        if($todayTimestamp>=$dateScoreTodayDeadline && $todayTimestamp<$dateScorePenaltyDeadline){
            $callee=$userrep->LoadById($row->callee_user_id);
            $caller=$userrep->LoadById($row->caller_user_id);

            $db=ServiceLocator::GetDatabase();
            $db->Connection->Connect();
            sendOrSchedule("InsertCallScoreTodayEmail",$callee,$caller,TRUE);
        }
        else if($todayTimestamp>=$dateScoreTomorrowDeadline && $todayTimestamp<$dateScorePenaltyDeadline){
            $callee=$userrep->LoadById($row->callee_user_id);
            $caller=$userrep->LoadById($row->caller_user_id);

            $db=ServiceLocator::GetDatabase();
            $db->Connection->Connect();
            sendOrSchedule("InsertCallScoreTomorrowEmail",$callee,$caller,TRUE);
        }
    }
}
//////////////////////
//Monday's functions//
//////////////////////
/**
 * Apothikevei tin thesi tou paikti prwtou ypologistoun oi neoi pontoi gia afti ti vdomada
 * etsi wste na exoume to +- toso apo last weeks position
 */
function saveLastWeeksRank(){
    $rankings=pdoq("select ranking_table_name from r_rankings");
    foreach($rankings as $ranking){
        $rows=pdoq("select us.user_id, ra.rank_pos from users us inner join $ranking->ranking_table_name ra on us.user_id=ra.rank_user_id");
        foreach($rows as $row){
            $exists=pdoq("select user_id from player_rank_details where user_id=?",$row->user_id);
            if($exists){
                pdoq("update player_rank_details set last_rank=$row->rank_pos where user_id=?",$row->user_id);
            }
            else{
                pdoq("insert into player_rank_details (user_id,last_rank) values (?,?)",array($row->user_id,$row->rank_pos));
            }
        }
    }
}

/**
 * Afou exoun prosthafairethei oi pontoi tou paikti gia afti ti vdomada, kai meta to sorting:
 * Apothikevei, ean einai i kaliteri, tin twrini thesi tou ws tin kalyteri tou thesi.
 * Episis apothikevei tin thesi tou afti ti vdomada sto table week_positions.
 */
function saveHeighestRank(){
    $now = date("Y-m-d");
    $week_start=(date('w', strtotime($now)) == 1) ? $now : date("Y-m-d",strtotime('last monday', strtotime($now)));

    $rankings=pdoq("select ranking_table_name from r_rankings");
    foreach($rankings as $ranking){
        $players=pdoq("select u.user_id, r.rank_pos from users u inner join $ranking->ranking_table_name r on u.user_id=r.rank_user_id");

        foreach($players as $player){
            pdoq("insert into week_positions (week_start,user_id,position) values (?,?,?)", array($week_start,$player->user_id,$player->rank_pos));
            $row1=pdoq("select * from player_rank_details where user_id=?",$player->user_id);
            if($row1){
                if($row1[0]->heightest_rank>$player->rank_pos || $row1[0]->heightest_rank==0){
                    pdoq("update player_rank_details set heightest_rank=? where user_id=?", array($player->rank_pos,$player->user_id));
                }
            }
            else{
                pdoq("insert into player_rank_details (user_id,heightest_rank,last_rank) values (?,?,0)", array($player->user_id,$player->rank_pos));
            }
        }
    }
}

/**
 * Afairei tous pontous pou prepei na afairethoun apo ton kathe paikti.
 * Oi pontoi aftoi einai sinithws osoi apoktithikan tin perasmeni evdomada, ena xrono prin (52-week System)
 */
function removePoints(){
    $yearWeek=date('oW',strtotime('-1 year -1 day'));

    $rows=pdoq("select sum(match_points_won) as total_points, match_winner_user_id as user_id from r_calls where yearweek = '".$yearWeek."' group by match_winner_user_id");
    //anal($rows);
    foreach($rows as $row){
        $ranking_table_name=getRankingTable($row->user_id);
        pdoq("update $ranking_table_name set rank_tot_points=rank_tot_points-? where rank_user_id=?", array($row->total_points,$row->user_id));
    }
    pdoq("update r_calls set yearweek=NULL where yearweek = ?", $yearWeek);
}

/**
 * Prosthetei tous pontous einai na parei o kathe paiktis
 */
function addPoints(){
    $rows=pdoq("select sum(match_points_won) as total_points, match_winner_user_id as user_id from r_calls where toInsert=1 group by match_winner_user_id");
    foreach($rows as $row){
        $ranking_table_name=getRankingTable($row->user_id);
        pdoq("update $ranking_table_name set rank_tot_points=rank_tot_points+? where rank_user_id=?", array($row->total_points,$row->user_id));
    }
    pdoq("update r_calls set toInsert=0, countedToRank=1 where toInsert=1");
}

/**
 * Prosthetei i afairei pontous tournoua pou einai na eisaxthoun i na afairethoun antistoixa
 */
function handleTourPoints(){
    $rows=pdoq("select * from r_tour_updates");
    foreach($rows as $row){
        if($row->type=='insert'){
            updateRankings_insertTourPoints($row->tour_id);
        }
        else if($row->type=='remove'){
            updateRankings_removeTourPoints($row->tour_id);
        }
    }
    pdoq("delete from r_tour_updates");
}
