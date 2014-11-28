<?php

require_once(ROOT_DIR . 'Pages/SchedulePage.php');

class ViewRankingPage extends Page
{
	public function __construct()
	{
		parent::__construct('ViewRanking');
	}

    public function PageLoad(){
        $this->Display('globalheader.tpl');

        $userSession=ServiceLocator::GetServer()->GetUserSession();

        require_once ROOT_DIR.'Ranking/viewRanking.php';

        $this->Display('globalfooter.tpl');
    }
}
