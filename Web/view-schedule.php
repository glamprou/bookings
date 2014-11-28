<?php

define('ROOT_DIR', '../');

require_once(ROOT_DIR . '/Pages/ViewSchedulePage.php');

$page = new ViewSchedulePage();
if (!Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_VIEW_SCHEDULES, new BooleanConverter()))
{
    $page = new SecurePageDecorator($page);
}

$page->PageLoad();

?>