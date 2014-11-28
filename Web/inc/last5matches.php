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
	$res=mysql_query("select * from r_calls where ((caller_user_id=".$_GET['user']." OR callee_user_id=".$_GET['user'].") and call_completed=1) order by match_date desc limit 5");
?>
<div><b><u>Last 5 Matches:</u></b></div><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php	
		$i=1;
		while ($row=mysql_fetch_object($res)){ ?>
              <tr>
                <td valign="top" width="60"><?= changeDate($row->match_date); ?></td>
                <th valign="top">&nbsp;<?php if($row->match_winner_user_id==$_GET['user']) echo "Νίκη"; else echo "Ήττα"; ?></th>
                <td valign="top"><?php if($row->retired==1) echo "(Ret)";?></td>
                <td>
                <?php
					if($row->caller_user_id==$_GET['user']){
						echo "&nbsp;vs&nbsp;".fetch_player_name($row->callee_user_id);
					}
					else{
						echo "&nbsp;vs&nbsp;".fetch_player_name($row->caller_user_id);
					}
				?>
                </td>
              </tr>
<?php	$i=0;
		}
		if($i){
			echo "Δεν έχει παίξει ακόμα";
		}	
?>
</table>
</body>
</html>