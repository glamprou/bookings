<?php
require_once('config/config.php');

$url = !empty($_SERVER['QUERY_STRING']) ? "Web?".$_SERVER['QUERY_STRING'] : "Web";
header("refresh:0;$url");
exit;
?>