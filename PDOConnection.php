<?php
/*
Author: Siopis Ilias (ilsio9@gmail.com)
Usage:

Include afto to arxeio se ola ta arxeia pou xreiazontai access stin database(mesw tou config sto opoio exei ginei included). Apo kei kai pera xreiazetai mono i klisi tis pdoq. 

Klisi pdoq kai parametroi:
-mono to query(1i parametros) gia statika queries
-query kai params(2i parametros) ws array i ws metavliti ama einai mono 1 parametros
-$rowCount=true (3i parametros) epistrefei enan int me ta rows pou epestrepse to query
*/
global $pdo;
global $driver;
global $dbhost;
global $dbname;
global $dbuser;
global $dbpass;

$driver=$conf['settings']['database']['type'];		//usually 'mysql'
$dbhost=$conf['settings']['database']['hotspec'];	//usually localhost or 127.0.0.1
$dbname=$conf['settings']['database']['name'];		//db name
$dbuser=$conf['settings']['database']['user'];		//db user name
$dbpass=$conf['settings']['database']['password'];	//db password



function PDOConnect(){
    global $pdo;
    global $driver;
    global $dbhost;
    global $dbname;
    global $dbuser;
    global $dbpass;
    
    $pdo = new PDO("$driver:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $pdo->exec("set names utf8");
}

function PDODisconnect(){
	global $pdo;
	$pdo = null;
}

function pdoq($query,$params=NULL,$rowCount=false){//named as pdoq (a.k.a. PDO query) for simplicity
	global $pdo;
	PDOConnect();
	if($params===NULL){
		$s=$pdo->query($query);
                if(!$s) return false;
	}
	else{
		$s=$pdo->prepare($query);
                if(!$s) return false;
                
		if(is_array($params)){
			foreach($params as $key => $value){
				$s->bindValue($key+1,$value);
			}
		}
		else{
			$s->bindValue(1,$params);
		}
		$s->execute();
	}
	PDODisconnect();
	if($rowCount===false){
		$result=array();
		while($row=$s->fetchObject()){
			$result[]=$row;
		}
		return $result;
	}
	else{
		return $s->rowCount();
	}
}
