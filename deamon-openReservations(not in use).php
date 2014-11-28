<?php 
define('ROOT_DIR','');
require (ROOT_DIR."config/config.php");

$now=date('Y-m-d H:i:s');

$res=pdoq('select reference_number from open_reservations where deadline <= ?',array($now));
if(count($res)){
	$ref_numbers=array();
	foreach($res as $row){
		$ref_numbers[]=$row->reference_number;
	}
	$str='';
	$first=1;
	foreach ($ref_numbers as $num){
		if($first==1){
			$first=0;
			$str.="'".$num."'";	
		}
		else{
			$str.=",'".$num."'";
		}
	}
	$res1=pdoq("select series_id from reservation_instances where reference_number in ($str)");
	if(count($res1)){
		$series_ids=array();
		foreach($res1 as $row){
			$series_ids[]=$row->series_id;
		}
		$series_ids=join(",",$series_ids);
		
		pdoq("update reservation_series set status_id=2 where series_id in ($series_ids)");
	}

	pdoq('delete from open_reservations where deadline <= ?',$now);
}
?>