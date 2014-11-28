<?php

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Domain/Access/UserRepository.php');

class RankingTablePage extends SecurePage{
	private $userSession=NULL;
	
	public function __construct()
	{
		$pageTitle="Ti titlo na valw edw?????????????????????????";
		
		parent::__construct($pageTitle,1);
		$this->userSession = $this->server->GetUserSession();
	}
	
	public function PageLoad()
	{
		$this->Display('globalheader.tpl');
		
		$this->GenerateContent('rankingTable');//proetoimasia kyriws periexomenou pros provoli
		$this->DisplayContent('rankingTable');//provoli kyriws periexomenou
		
		$this->Display('globalfooter.tpl');
	}
	
}
?>