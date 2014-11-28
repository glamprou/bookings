<?php

define('ROOT_DIR', '../../');
require_once(ROOT_DIR . 'Pages/Reports/GenerateReportPage.php');

$page = new RoleRestrictedPageDecorator(new GenerateReportPage(), array(RoleLevel::APPLICATION_ADMIN, RoleLevel::GROUP_ADMIN, RoleLevel::RESOURCE_ADMIN, RoleLevel::SCHEDULE_ADMIN));
$page->PageLoad();

?>