<?php

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Domain/Access/UserRepository.php');

class RankingTablePage extends SecurePage{
        /*
         * I metavliti $rankings perilamvanei ola ta ranking tables anaforika
         */
        public $rankings=NULL;
        
        /*
         * I metavliti $rankings_data perilamvanei oles tis plirofories pou apaitountai
         * gia tin typwsi tou current ranking table
         */
        public $rankings_data=NULL;
	
	public function __construct()
	{
		$pageTitle="RankingTable";
		
		parent::__construct($pageTitle,1);
                $this->smarty->assign('rankingCss', ROOT_DIR.'Web/css/ranking/ranking_table.css');
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