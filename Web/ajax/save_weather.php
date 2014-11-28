<?php
define('ROOT_DIR','../../');
require_once(ROOT_DIR.'config/config.php');

pdoq("update w_clouds set now=0");
pdoq("update w_clouds set now=1 where id=?",$_POST['clouds_id']);

pdoq("update w_winds set now=0");
pdoq("update w_winds set now=1 where id=?",$_POST['winds_id']);

echo $_POST['clouds_id']."-".$_POST['winds_id'];
?>