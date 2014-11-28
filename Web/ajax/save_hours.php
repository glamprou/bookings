<?php
define('ROOT_DIR','../../');
require_once(ROOT_DIR.'config/config.php');

$secs=floor($_POST['hours'])*60*60;
echo $secs;
pdoq("update system_preferences set min_edit_time_seconds=? where id=?",array($secs,1));
?>