<?php

class RankingTableUser{
    public $ranking_id=NULL;
    public $user_id=NULL;
    public $fullname=NULL;
    public $position=NULL;
    public $position_difference=NULL;
    public $points=NULL;
    public $isBlocked=NULL;
    public $isInjured=NULL;
    /*
     * true, ean o logged in xristis mporei na kalesei ton sygkekrimeno
     */
    public $canBeCalled=false;

    public function __construct($userid,$rankingid){        
            $rows=pdoq("select us.user_id, us.fname, us.lname, rt.position, rt.ranking_id, rt.points, ub.user_id as blocked, ui.user_id as injured, upd.last_position from ranking_tables rt inner join users us on rt.user_id=us.user_id left join ranking_user_blocks ub on rt.user_id=ub.user_id left join ranking_user_injuries ui on rt.user_id=ui.user_id left join ranking_user_position_details upd on rt.user_id=upd.user_id where rt.user_id=? and rt.ranking_id=?",array($userid,$rankingid),false,true);
            if($rows){
                $this->ranking_id=$rows[0]->ranking_id;
                $this->user_id=$rows[0]->user_id;
                $this->fullname=$rows[0]->fname." ".$rows[0]->lname;
                $this->position=$rows[0]->position;
                $this->position_difference=$rows[0]->last_position-$this->position;
                $this->points=$rows[0]->points;
                $this->isBlocked = $rows[0]->blocked ? TRUE : FALSE;
                $this->isInjured = $rows[0]->injured ? TRUE : FALSE;
                $this->canBeCalled=$this->canBeCalled();
            }
    }
    
    private function canBeCalled(){
        
        //to mono pou menei einai na ipologizw to epitrepto-pragmatiko call distance 
        //+ na dw ama doulevei ontws swsta to query me tis prosfates imeres
        
        $userSession = ServiceLocator::GetServer()->GetUserSession();
        
        /*
         * den mporei na kalesei ton eafto tou
         */
        if($userSession->UserId===$this->user_id){
            return FALSE;
        }
        return TRUE;
        /*
         * blocked calls
         */
        if(sp_calls_block()){
            return FALSE;
        }
        
        /*
         * vriskontai k oi 2 sto idio ranking table
         */
        $row=pdoq("select user_id from ranking_tables where user_id=? and ranking_id=?", array($userSession->UserId, $this->ranking_id));
        if(!$row){
            return FALSE;
        }
        
        /*
         * blocked enas apo tous dyo
         */
        $row=pdoq("select block_id from ranking_user_blocks where user_id=? and ranking_id=?", array($userSession->UserId, $this->ranking_id));
        if($row || $this->isBlocked){
            return FALSE;
        }
        
        /*
         * injured enas apo tous dyo
         */
        $row=pdoq("select injury_id from ranking_user_injuries where user_id=?", $userSession->UserId);
        if($row || $this->isInjured){
            return FALSE;
        }
        
        /*
         * yparxei prosfato idio call
         */
        $furthest_day=date("Y-m-d",strtotime("- ".sp_numofdays_same_call()." days", strtotime("now")));//pio kontini sto now imera gia tin opoia DEN thewreitai prosfato to call
        $cancel_furthest_day=date("Y-m-d",strtotime("- ".sp_numofdays_same_cancelled_call()." days", strtotime("now")));
        
        $rows=pdoq("select call_id from ranking_calls where (((caller_user_id=? and callee_user_id=?) or (caller_user_id=? and callee_user_id=?)) and ((call_accepted=1 and call_completed=0) or (call_accepted=1 and call_completed=1 and match_date>=?) or (call_accepted=-1 and DATE(call_created)>=?)))",array($userSession->UserId,$this->user_id,$this->user_id,$userSession->UserId,$furthest_day,$cancel_furthest_day));
        if($rows){
            return FALSE;
        }
        
        return TRUE;
    }
}
