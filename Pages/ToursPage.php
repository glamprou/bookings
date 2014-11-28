<?php

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/DashboardPresenter.php');

class ToursPage extends SecurePage{	
	public function __construct()
	{
		parent::__construct('Tours');
		
	}
	
	public function PageLoad()
	{
		$this->Display('globalheader.tpl');
		
        $userSession=ServiceLocator::GetServer()->GetUserSession();
        
        $db=ServiceLocator::GetDatabase();
        $db->Connection->Connect();  
        
		require_once ROOT_DIR.'Ranking/tours.php';
		
        $db->Connection->Disconnect();
		
        $this->Display('globalfooter.tpl');
	}
}


