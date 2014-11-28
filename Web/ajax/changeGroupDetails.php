<?php
define('ROOT_DIR','../../');

require_once(ROOT_DIR.'config/config.php');

$groupStateType = $_POST['groupStateType'];
$groupId = $_POST['id'];
$value = $_POST['value'] == '1' ? '1' : NULL;

if($groupStateType == 'free_of_charge'){
    pdoq('update groups set free_of_charge = ? where group_id = ?', array($value, $groupId));
}
else if($groupStateType == 'coaches'){
    pdoq('update groups set coaches = ? where group_id = ?', array($value, $groupId));
}
else if($groupStateType == 'guests'){
    pdoq('update groups set guests = ? where group_id = ?', array($value, $groupId));
}