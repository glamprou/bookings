<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>
<body>
<?php 
	include('config.php');
	include('functions.php');
	//echo $_GET['user'];
	$res=mysql_query("select tour_id,position_id from r_tours_participants where (user_id=".$_GET['user'].") order by tour_id desc limit 1");
	$res=mysql_fetch_object($res);
	if (!$res){
		echo "Δεν έχει συμμετάσχει ακόμα";
		exit();
	}
	else{
		$r=mysql_query("select tour_name,tour_date_fin from r_tours where tour_id=$res->tour_id");
		$r=mysql_fetch_object($r);
		$res=mysql_query("select pos_description from r_tours_positions where position_id=$res->position_id");
		$res=mysql_fetch_object($res);
		?>
        <table border="0" cellspacing="0" cellpadding="0">
          <tr class="row0">
            <th>Ημερομηνία&nbsp;</th>
            <td><?= changeDate($r->tour_date_fin) ?></td>
          </tr>
          <tr class="row1">
          	<th>Τουρνουά</th>
            <td><?= $r->tour_name ?></td>
          </tr>
          <tr class="row0">
            <th>Θέση</th>
            <td><?= $res->pos_description ?></td>
          </tr>
        </table>
        <?php
	}
?>
</body>
</html>
