<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>
<body>
<?php 
	function finishedSet($score1,$score2){
		if (($score1==6 && $score2<5) || ($score2==6 && $score1<5)){
			return true;
		}
		else if( ($score1==7 && $score2==5) ||  ($score1==5 && $score2==7) ||  ($score1==7 && $score2==6) || ($score1==6 && $score2==7) ){
			return true;
		}
		else{
			return false;
		}
	}
	function finishedTB($score1,$score2){
		if (($score1==7 && $score2<6) || ($score2==7 && $score1<6)){
			return true;
		}
		else if( ($score1>7 && $score2==$score1-2) || ($score2>7 && $score1==$score2-2) ){
			return true;
		}
		else{
			return false;
		}
	}
	function finishedSTB($score1,$score2){
		if (($score1==10 && $score2<9) || ($score2==10 && $score1<9)){
			return true;
		}
		else if( ($score1>10 && $score2==$score1-2) || ($score2>10 && $score1==$score2-2) ){
			return true;
		}
		else{
			return false;
		}
	}

	include('config.php');
	$res=mysql_query("select * from r_calls where ((caller_user_id=".$_GET['user']." OR callee_user_id=".$_GET['user'].") and call_completed=1)");
	$numOfMatches=mysql_num_rows($res);
	$wins=0;
	$loses=0;
	$totalGames=0;
	$gamesWon=0;
	$totalSets=0;
	$setsWon=0;
	$setsLost=0;
	$tbwon=0;
	$tblost=0;
	$Stbwon=0;
	$Stblost=0;
	$numofretirements=0;
	while ($row=mysql_fetch_object($res)){
		if($row->match_winner_user_id==$_GET['user'])
			$wins++;
		else
			$loses++;
		/*SET 1*/
		$games= explode('-', $row->match_set1);
		if ($row->caller_user_id==$_GET['user']){//caller o paiktis pou mas endiaferei dld to 1o noumero diko tou
			$totalGames=$totalGames+$games[0]+$games[1];
			$gamesWon+=$games[0];
			if ($games[0]>$games[1]){
				if (finishedSet($games[0],$games[1])){
					$setsWon++;
					$totalSets++;
				}
				else{
					if ($row->retired){
						if ($row->match_winner_user_id==$_GET['user']){
							$setsWon++;
							$totalSets++;
						}
						else{
							$setsLost++;
							$totalSets++;
						}
					}
					else{
						//paixtike malakia
						$setsWon=-1000;
						$setsLost=-1000;
					}
				}
			}
			else{
				if (finishedSet($games[0],$games[1])){
					$setsLost++;
					$totalSets++;
					$lastsetwinner=2;
				}
				else{
					if ($row->retired){
						if ($row->match_winner_user_id==$_GET['user']){
							$setsWon++;
							$totalSets++;
							$lastsetwinner=1;
						}
						else{
							$setsLost++;
							$totalSets++;
							$lastsetwinner=2;
						}
					}
					else{
						//paixtike malakia
						$setsWon=-1000;
						$setsLost=-1000;
					}
				}
			}
		}
		if ($row->caller_user_id!=$_GET['user']){//callee o paiktis pou mas endiaferei dld to 2o noumero diko tou
			$totalGames=$totalGames+$games[0]+$games[1];
			$gamesWon+=$games[1];
			if ($games[0]<$games[1]){
				if (finishedSet($games[0],$games[1])){
					$setsWon++;
					$totalSets++;
					$lastsetwinner=2;
				}
				else{
					if ($row->retired){
						if ($row->match_winner_user_id==$_GET['user']){
							$setsWon++;
							$totalSets++;
							$lastsetwinner=2;
						}
						else{
							$setsLost++;
							$totalSets++;
							$lastsetwinner=1;
						}
					}
					else{
						//paixtike malakia
						$setsWon=-1000;
						$setsLost=-1000;
					}
				}
			}
			else{
				if (finishedSet($games[0],$games[1])){
					$setsLost++;
					$totalSets++;
					$lastsetwinner=1;
				}
				else{
					if ($row->retired){
						if ($row->match_winner_user_id==$_GET['user']){
							$setsWon++;
							$totalSets++;
							$lastsetwinner=2;
						}
						else{
							$setsLost++;
							$totalSets++;
							$lastsetwinner=1;
						}
					}
					else{
						//paixtike malakia
						$setsWon=-1000;
						$setsLost=-1000;
					}
				}
			}
		}
		/*SET 2*/
		$games= explode('-', $row->match_set2);
		if ($row->caller_user_id==$_GET['user']){//caller o paiktis pou mas endiaferei dld to 1o noumero diko tou
			$totalGames=$totalGames+$games[0]+$games[1];
			$gamesWon+=$games[0];
			if ($games[0]>$games[1]){
				if (finishedSet($games[0],$games[1])){
					$setsWon++;
					$totalSets++;
				}
				else{
					if ($row->retired){
						if ($row->match_winner_user_id==$_GET['user']){
							$setsWon++;
							$totalSets++;
						}
						else{
							$setsLost++;
							$totalSets++;
						}
					}
					else{
						//paixtike malakia
						$setsWon=-1000;
						$setsLost=-1000;
					}
				}
			}
			else{
				if (finishedSet($games[0],$games[1])){
					$setsLost++;
					$totalSets++;
				}
				else{
					if ($row->retired){
						if ($row->match_winner_user_id==$_GET['user']){
							$setsWon++;
							$totalSets++;
						}
						else{
							$setsLost++;
							$totalSets++;
						}
					}
					else{
						//paixtike malakia
						$setsWon=-1000;
						$setsLost=-1000;
					}
				}
			}
		}
		if ($row->caller_user_id!=$_GET['user']){//callee o paiktis pou mas endiaferei dld to 2o noumero diko tou
			$totalGames=$totalGames+$games[0]+$games[1];
			$gamesWon+=$games[1];
			if ($games[0]<$games[1]){
				if (finishedSet($games[0],$games[1])){
					$setsWon++;
					$totalSets++;
				}
				else{
					if ($row->retired){
						if ($row->match_winner_user_id==$_GET['user']){
							$setsWon++;
							$totalSets++;
						}
						else{
							$setsLost++;
							$totalSets++;
						}
					}
					else{
						//paixtike malakia
						$setsWon=-1000;
						$setsLost=-1000;
					}
				}
			}
			else{
				if (finishedSet($games[0],$games[1])){
					$setsLost++;
					$totalSets++;
				}
				else{
					if ($row->retired){
						if ($row->match_winner_user_id==$_GET['user']){
							$setsWon++;
							$totalSets++;
						}
						else{
							$setsLost++;
							$totalSets++;
						}
					}
					else{
						//paixtike malakia
						$setsWon=-1000;
						$setsLost=-1000;
					}
				}
			}
		}
		/*Super Tie Break*/
		$games= explode('-', $row->match_stb);
		if ($row->caller_user_id==$_GET['user'] && ($games[0]!=0 ||  $games[1]!=0)){//caller o paiktis pou mas endiaferei dld to 1o noumero diko tou
			$totalSets++;
			$totalGames+=13;
			if ($games[0]>$games[1])	{
				if (finishedSTB($games[0],$games[1])){
					$setsWon++;
					$gamesWon+=7;
					$Stbwon++;
				}
				else{
					if ($row->retired){
						if ($row->match_winner_user_id==$_GET['user']){
							$setsWon++;
							//$gamesWon+=7;
							$totalGames-=13;
						//	$Stbwon++;
						}
						else{
							$setsLost++;
						//	$gamesWon+=6;
							$totalGames-=13;
					//		$Stblost++;
						}
					}
					else{
						//paixtike malakia
						$setsWon=-1000;
						$setsLost=-1000;
					}
				}
			}
			else{
				if (finishedSTB($games[0],$games[1])){
					$setsLost++;
					$gamesWon+=6;
					$Stblost++;
				}
				else{
					if ($row->retired){
						if ($row->match_winner_user_id==$_GET['user']){
							$setsWon++;
							//$gamesWon+=7;
							$totalGames-=13;
						//	$Stbwon++;
						}
						else{
							$setsLost++;
						//	$gamesWon+=6;
							$totalGames-=13;
						//	$Stblost++;
						}
					}
					else{
						//paixtike malakia
						$setsWon=-1000;
						$setsLost=-1000;
					}
				}
			}
		}
		if ($row->caller_user_id!=$_GET['user'] && ($games[0]!=0 ||  $games[1]!=0)){//callee o paiktis pou mas endiaferei dld to 2o noumero diko tou
			$totalSets++;
			$totalGames+=13;
			if ($games[0]<$games[1])	{
				if (finishedSTB($games[0],$games[1])){
					$setsWon++;
					$gamesWon+=7;
					$Stbwon++;
				}
				else{
					if ($row->retired){
						if ($row->match_winner_user_id==$_GET['user']){
							$setsWon++;
							//$gamesWon+=7;
							$totalGames-=13;
					//		$Stbwon++;
						}
						else{
							$setsLost++;
							//$gamesWon+=6;
							$totalGames-=13;
					//		$Stblost++;
						}
					}
					else{
						//paixtike malakia
						$setsWon=-1000;
						$setsLost=-1000;
					}
				}
			}
			else{
				if (finishedSTB($games[0],$games[1])){
					$setsLost++;
					$gamesWon+=6;
					$Stblost++;
				}
				else{
					if ($row->retired){
						if ($row->match_winner_user_id==$_GET['user']){
							$setsWon++;
						//	$gamesWon+=7;
							$totalGames-=13;
						//	$Stbwon++;
						}
						else{
							$setsLost++;
						//	$gamesWon+=6;
							$totalGames-=13;
					//		$Stblost++;
						}
					}
					else{
						//paixtike malakia
						$setsWon=-1000;
						$setsLost=-1000;
					}
				}
			}
		}
		/*Tie Breaks*/
		$games= explode('-', $row->match_set1_tb);
		if ($row->caller_user_id==$_GET['user'] && ($games[0]!=0 ||  $games[1]!=0)){//caller o paiktis pou mas endiaferei dld to 1o noumero diko tou
			if ($games[0]>$games[1])	
				$tbwon++;
			else
				$tblost++;
		}
		if ($row->caller_user_id!=$_GET['user'] && ($games[0]!=0 ||  $games[1]!=0)){//callee o paiktis pou mas endiaferei dld to 2o noumero diko tou
			if ($games[0]<$games[1])	
				$tbwon++;
			else
				$tblost++;
		}
		
		$games= explode('-', $row->match_set2_tb);
		if ($row->caller_user_id==$_GET['user'] && ($games[0]!=0 ||  $games[1]!=0)){//caller o paiktis pou mas endiaferei dld to 1o noumero diko tou
			if ($games[0]>$games[1])	
				$tbwon++;
			else
				$tblost++;
		}
		if ($row->caller_user_id!=$_GET['user'] && ($games[0]!=0 ||  $games[1]!=0)){//callee o paiktis pou mas endiaferei dld to 2o noumero diko tou
			if ($games[0]<$games[1])	
				$tbwon++;
			else
				$tblost++;
		}
		
		/*Number of retirements*/
		if ($row->retired==1){
			if ($row->match_winner_user_id!=$_GET['user']){
				$numofretirements++;
			}
		}
	}

	$gamesLost=$totalGames-$gamesWon;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
    	<th colspan="2"><u>Matches:</u></th>
    </tr>
    <tr>
    	<td>Σύνολο</td><td><?= $numOfMatches ?></td>
    </tr>
    <tr>
    	<td>Νίκες</td><td><?= $wins ?></td>
    </tr>
    <tr>
    	<td>Ήττες</td><td><?= $loses ?></td>
    </tr>
    <tr>
    	<td>Win Rate</td><td><?php if($numOfMatches!=0) echo (int)(($wins/$numOfMatches)*100); else echo 0; ?>&#37;</td>
    </tr>
    <tr>
    	<td colspan="2" height="5"></td>
    </tr>
    <tr>
    	<th colspan="2"><u>Sets:</u></th>
    </tr>
    <tr>
    	<td>Σύνολο</td><td><?= $totalSets ?></td>
    </tr>
    <tr>
    	<td>Κερδισμένα</td><td><?= $setsWon ?></td>
    </tr>
    <tr>
    	<td>Χαμένα</td><td><?= $setsLost ?></td>
    </tr>
    <tr>
    	<td>Win Rate</td><td><?php if($totalSets!=0) echo (int)(($setsWon/$totalSets)*100); else echo 0; ?>&#37;</td>
    <tr>
    	<td colspan="2" height="5"></td>
    </tr>
    <tr>
    	<th colspan="2"><u>Games:</u></th>
    </tr>
    <tr>
    	<td>Σύνολο</td><td><?= $totalGames ?></td>
    </tr>
    <tr>
    	<td>Κερδισμένα</td><td><?= $gamesWon ?></td>
    </tr>
    <tr>
    	<td>Χαμένα</td><td><?= $gamesLost ?></td>
    </tr>
    <tr>
    	<td>Win Rate</td><td><?php if($totalGames!=0) echo (int)(($gamesWon/$totalGames)*100); else echo 0; ?>&#37;</td>
    </tr>
    
    
    
    <tr>
    	<td colspan="2" height="5"></td>
    </tr>
    <tr>
    	<th colspan="2"><u>Tie Breaks:</u></th>
    </tr>
    <tr>
    	<td>Σύνολο</td><td><?= $tbwon+$tblost ?></td>
    </tr>
    <tr>
    	<td>Κερδισμένα</td><td><?= $tbwon ?></td>
    </tr>
    <tr>
    	<td>Χαμένα</td><td><?= $tblost ?></td>
    </tr>
    <tr>
    	<td>Win Rate</td><td><?php if(($tbwon+$tblost)!=0) echo (int)(($tbwon/($tbwon+$tblost))*100); else echo 0; ?>&#37;</td>
    </tr>
    <tr>
    	<td colspan="2" height="5"></td>
    </tr>
    <tr>
    	<th colspan="2"><u>Super Tie Breaks:</u></th>
    </tr>
    <tr>
    	<td>Σύνολο</td><td><?= $Stbwon+$Stblost ?></td>
    </tr>
    <tr>
    	<td>Κερδισμένα</td><td><?= $Stbwon ?></td>
    </tr>
    <tr>
    	<td>Χαμένα</td><td><?= $Stblost ?></td>
    </tr>
    <tr>
    	<td>Win Rate</td><td><?php if(($Stbwon+$Stblost)!=0) echo (int)(($Stbwon/($Stbwon+$Stblost))*100); else echo 0; ?>&#37;</td>
    </tr>
    <tr>
    	<td colspan="2" height="5"></td>
    </tr>
    <tr>
    	<th><u>Number of retirements:</u>&nbsp;</th><td><?= $numofretirements ?></td>
    </tr>
</table>
</body>
</html>