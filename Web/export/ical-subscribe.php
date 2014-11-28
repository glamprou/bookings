<?php

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Export/CalendarSubscriptionPage.php');

$page = new CalendarSubscriptionPage();
$page->PageLoad();

?>