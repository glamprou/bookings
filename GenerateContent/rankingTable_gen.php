<?php 
require_once ROOT_DIR.'GenerateContent/classes/RankingTableUser.php';

$rankings_data=NULL;

$curr_table_id=currTableId();

$rows=pdoq("select * from rankings order by ranking_id asc");
$index=0;
if($rows){
    foreach($rows as $ranking){
        $players=array();
        
        $rankings_data[$index]['ranking_id']=$ranking->ranking_id;
        $rankings_data[$index]['ranking_name']=$ranking->ranking_name;
        $rankings_data[$index]['doubles']=$ranking->doubles;
        $params=$_GET;
        $params['rt']=$ranking->ranking_id;
        $rankings_data[$index]['url']=$_SERVER['PHP_SELF']."?".http_build_query($params);
        
        if($ranking->ranking_id==$curr_table_id){//an einai to current, fortwse k tous paiktes
            $rankings_data[$index]['current']=TRUE;
            //LOOKUP: order by position asc(etsi lamvanetai mono i thesi ypopsin k oxi endexomenes synthikes se periptwsi isovathmias)
            $users=pdoq("select us.user_id from users us inner join ranking_tables rt on us.user_id=rt.user_id where rt.ranking_id=? order by rt.position asc",$ranking->ranking_id);

            foreach ($users as $key => $user) {
                $new_user=new RankingTableUser($user->user_id,$ranking->ranking_id);
                if ($new_user->user_id) {
                    $players[] = $new_user;
                }
            }
            
            $rankings_data[$index]['players']=$players;
        }
        else{
            $rankings_data[$index]['current']=FALSE;
            $rankings_data[$index]['players']=NULL;
        }
        $index++;
    }
}

$this->rankings_data=$rankings_data;

/*
 * Epistrefei to current table id, an iparxei, alliws epistrefei to id tou prwtou table ws default
 */
function currTableId(){
    $curr_table_id=false;
    
    if(isset($_GET['rt'])){//custom ranking table
        $curr_table_id=filter_input(INPUT_GET, 'rt', FILTER_VALIDATE_INT);
        if($curr_table_id){
            $row_num=pdoq("select * from rankings where ranking_id=?",$curr_table_id,true);
            if(!$row_num){//wrong ranking_id
                $curr_table_id=false;
            }
        }
     }

     if(!$curr_table_id){//default table
         $rows=pdoq("select ranking_id from rankings order by ranking_id asc limit 1");
         if($rows){
             $curr_table_id=$rows[0]->ranking_id;
         }
         //LOOKUP: edw isws anti tou ranking me mikrotero id, na iparxei kapoio default ranking to opoio tha dialegei o xristis
     }
     
     return $curr_table_id;
}