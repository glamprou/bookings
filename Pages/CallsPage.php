<?php

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/DashboardPresenter.php');

class CallsPage extends SecurePage{	
	public function __construct()
	{
		parent::__construct('Calls');
		
	}
	
	public function PageLoad()
	{
		$this->Display('globalheader.tpl');
		
        $userSession=ServiceLocator::GetServer()->GetUserSession();
        
        $db=ServiceLocator::GetDatabase();
        $db->Connection->Connect();  
        
		require_once ROOT_DIR.'Ranking/calls.php';
		
        $db->Connection->Disconnect();
		
        $this->Display('globalfooter.tpl');
	}
}


