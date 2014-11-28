<?php

define('ROOT_DIR', '../');
require_once(ROOT_DIR . 'Pages/ToursPage.php');

$page = new ToursPage();
$page->PageLoad();

?>