<?php

define('ROOT_DIR', '../');

require_once(ROOT_DIR . '/Pages/ViewRankingPage.php');

$page = new ViewRankingPage();
if (!Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_VIEW_SCHEDULES, new BooleanConverter()))
{
    $page = new SecurePageDecorator($page);
}

$page->PageLoad();

?>