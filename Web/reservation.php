<?php
 
define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/Ajax/AutoCompletePage.php');
require_once(ROOT_DIR . 'Pages/NewReservationPage.php');
require_once(ROOT_DIR . 'Pages/ExistingReservationPage.php');

$server = ServiceLocator::GetServer();

if (!is_null($server->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER)))
{
	$page = new SecurePageDecorator(new ExistingReservationPage());
}
else
{
	$page = new SecurePageDecorator(new NewReservationPage());
}

$page->PageLoad();
?>