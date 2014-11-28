<?php

require_once(ROOT_DIR . 'Pages/SecurePage.php');

class RankingAdministration extends SecurePage{	
	public function __construct()
	{
		parent::__construct('RankingAdministration');
		
	}
	
	public function PageLoad()
	{
		$this->Display('globalheader.tpl');
		
        $userSession=ServiceLocator::GetServer()->GetUserSession();
        
        $db=ServiceLocator::GetDatabase();
        $db->Connection->Connect();  
        
		require_once ROOT_DIR.'Ranking/rankingAdministration.php';
		
        $db->Connection->Disconnect();
		
        $this->Display('globalfooter.tpl');
	}
}


