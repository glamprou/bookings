<?php

define('ROOT_DIR', '../../');
require_once(ROOT_DIR . 'Pages/Reports/SavedReportsPage.php');

$page = new RoleRestrictedPageDecorator(new SavedReportsPage(), array(RoleLevel::APPLICATION_ADMIN, RoleLevel::GROUP_ADMIN, RoleLevel::RESOURCE_ADMIN, RoleLevel::SCHEDULE_ADMIN));
$page->PageLoad();

?>