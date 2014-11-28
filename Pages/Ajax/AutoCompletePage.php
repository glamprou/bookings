<?php

require_once(ROOT_DIR . 'Domain/Access/namespace.php' );
require_once(ROOT_DIR . 'Pages/SecurePage.php');
//require_once(ROOT_DIR . 'SystemPreferencesAndGlobalFunctions.php');


class AutoCompletePage extends SecurePage
{
	private $listMethods = array();

	public function __construct()
	{
		parent::__construct();
		
	    $this->listMethods[AutoCompleteType::User] = 'GetUsers';
	    $this->listMethods[AutoCompleteType::MyUsers] = 'GetMyUsers';
	    $this->listMethods[AutoCompleteType::Group] = 'GetGroups';
	}

	public function PageLoad()
	{
		$results = $this->GetResults($this->GetType(), $this->GetSearchTerm());

		Log::Debug(sprintf('AutoComplete: %s results found for search type: %s, term: %s', count($results), $this->GetType(), $this->GetSearchTerm()));

		$this->SetJson($results);
	}

	private function GetResults($type, $term)
	{
		if (array_key_exists($type, $this->listMethods))
		{
			$method = $this->listMethods[$type];
			return $this->$method($term);
		}

		Log::Debug("AutoComplete for type: $type not defined");
		
		return '';
	}

	public function GetType()
	{
		return $this->GetQuerystring(QueryStringKeys::AUTOCOMPLETE_TYPE);
	}

	public function GetSearchTerm()
	{
		return $this->GetQuerystring(QueryStringKeys::AUTOCOMPLETE_TERM);
	}

	/**
	 * @param $term string
	 * @return array|AutocompleteUser[]
	 */
	private function GetUsers($term)
	{
		$filter = new SqlFilterLike(ColumnNames::FIRST_NAME, $term);
		$filter->_Or(new SqlFilterLike(ColumnNames::LAST_NAME, $term));
        //$filter->_Or(new SqlFilterLike(ColumnNames::EMAIL, $term));
        
//        
//      gia kapoio logo de doulevei. ama xreiastei, as to psaksw
//      $term=$this->getGreeklishAlternative($term);//allagi se greeklish i anapoda
//      $filter->_Or = new SqlFilterLike(ColumnNames::FIRST_NAME, $term);
//		$filter->_Or(new SqlFilterLike(ColumnNames::LAST_NAME, $term));
		

		$users = array();

		$r = new UserRepository();

        $userSession = ServiceLocator::GetServer()->GetUserSession();

        if(!$userSession->IsAdmin || isset($_GET['ranking'])){
            $results = $r->GetList(1, 10000, null, null, $filter,AccountStatus::ACTIVE)->Results();
        }
        else{
            $results = $r->GetList(1, 10000, null, null, $filter)->Results();
        }

		/** @var $result UserItemView */
		foreach($results as $result)
		{
            if(isset($_GET['ranking']) && getRankingTable($result->Id)!==FALSE){//filter out already in-rank players and inactive
                continue;
            }
            if(!$userSession->IsAdmin && $result->Id == $userSession->UserId){//if not admin, filter out himself from results
                continue;
            }

			$users[] = new AutocompleteUser($result->Id	, $result->First, $result->Last, $result->Email, $result->Username);
		}

		return $users;
	}

	private function GetGroups($term)
	{
		$filter = new SqlFilterLike(new SqlFilterColumn(TableNames::GROUPS_ALIAS,ColumnNames::GROUP_NAME), $term);
		$r = new GroupRepository();
		return $r->GetList(1, 100, null, null, $filter)->Results();
	}

	/**
	 * @param $term string
	 * @return array|AutocompleteUser[]
	 */
	private function GetMyUsers($term)
	{
		$userSession = ServiceLocator::GetServer()->GetUserSession();
		if ($userSession->IsAdmin)
		{
			return $this->GetUsers($term);
		}

		$userRepo = new UserRepository();
		$user = $userRepo->LoadById($userSession->UserId);

		$groupIds = array();

		foreach ($user->GetAdminGroups() as $group)
		{
            $groupIds[] = $group->GroupId;
		}

		$users = array();
		if (!empty($groupIds))
		{
			$userFilter = new SqlFilterLike(ColumnNames::FIRST_NAME, $term);
			$userFilter->_Or(new SqlFilterLike(ColumnNames::LAST_NAME, $term));
					
			$groupRepo = new GroupRepository();
			$results = $groupRepo->GetUsersInGroup($groupIds, null, null, $userFilter)->Results();

			/** @var $result UserItemView */
			foreach ($results as $result)
			{
				// consolidates results by user id if the user is in multiple groups
				$users[$result->Id] = new AutocompleteUser($result->Id, $result->First, $result->Last, $result->Email, $result->Username);
			}
		}

		return array_values($users);
	}
    
    public function getGreeklishAlternative($term){
        $oldTerm=$term;
        $term = str_replace(array("α","Α","ά","Ά"),'a',$term);
        $term = str_replace(array("β","Β"),'b',$term);
        $term = str_replace(array("γ","Γ"),'g',$term);
        $term = str_replace(array("δ","Δ"),'d',$term);
        $term = str_replace(array("ε","Ε","έ","Έ"),'e',$term);
        $term = str_replace(array("ζ","Ζ"),'z',$term);
        $term = str_replace(array("η","Η","ή","Ή"),'i',$term);
        $term = str_replace(array("θ","Θ"),'th',$term);
        $term = str_replace(array("ι","Ι","ϊ","ί","Ί","Ϊ","ΐ"),'i',$term);
        $term = str_replace(array("κ","Κ"),'k',$term);
        $term = str_replace(array("λ","Λ"),'l',$term);
        $term = str_replace(array("μ","Μ"),'m',$term);
        $term = str_replace(array("ν","Ν"),'n',$term);
        $term = str_replace(array("ξ","Ξ"),'ks',$term);
        $term = str_replace(array("ο","Ο","ό","Ό"),'o',$term);
        $term = str_replace(array("π","Π"),'p',$term);
        $term = str_replace(array("ρ","Ρ"),'r',$term);
        $term = str_replace(array("σ","ς","Σ"),'s',$term);
        $term = str_replace(array("τ","Τ"),'t',$term);
        $term = str_replace(array("υ","Υ","ϋ","ύ","Ύ","Ϋ","ΰ"),'u',$term);
        $term = str_replace(array("φ","Φ"),'f',$term);
        $term = str_replace(array("χ","Χ"),'x',$term);
        $term = str_replace(array("ψ","Ψ"),'ps',$term);
        $term = str_replace(array("ω","Ω","ώ","Ώ"),'w',$term); 
        
        if($oldTerm==$term){
            $term = str_replace(array("th","Th","TH"),'θ',$term);
            $term = str_replace(array("ks","Ks","KS"),'ξ',$term);
            $term = str_replace(array("ps","Ps","PS"),'ψ',$term);
            $term = str_replace(array("a","A"),'α',$term);
            $term = str_replace(array("b","B"),'β',$term);
            $term = str_replace(array("c","C"),'γ',$term);
            $term = str_replace(array("d","D"),'δ',$term);
            $term = str_replace(array("e","E"),'ε',$term);
            $term = str_replace(array("z","Z"),'ζ',$term);
            $term = str_replace(array("h","H"),'η',$term);
            
            $term = str_replace(array("i","I"),'ι',$term);
            $term = str_replace(array("k","K"),'κ',$term);
            $term = str_replace(array("l","L"),'λ',$term);
            $term = str_replace(array("m","Μ"),'μ',$term);
            $term = str_replace(array("n","Ν"),'ν',$term);
            
            $term = str_replace(array("o","O"),'ο',$term);
            $term = str_replace(array("p","P"),'π',$term);
            $term = str_replace(array("r","R"),'ρ',$term);
            $term = str_replace(array("s","S"),'σ',$term);
            $term = str_replace(array("t","T"),'τ',$term);
            $term = str_replace(array("u","U"),'υ',$term);
            $term = str_replace(array("f","F"),'φ',$term);
            $term = str_replace(array("x","X"),'χ',$term);
            
            $term = str_replace(array("w","W"),'ω',$term); 
        }
       
        return $term;
    }
}

class AutocompleteUser
{
	public $Id;
	public $First;
	public $Last;
	public $Name;
	public $Email;
	public $UserName;
	public $group_name;
	public $level;

	public function __construct($userId, $firstName, $lastName, $email, $userName)
	{
		$full = new FullName($firstName, $lastName);
		$this->Id = $userId;
		$this->First = $firstName;
		$this->Last = $lastName;
		$this->Name = $full->__toString();
		$this->Email = $email;
		$this->UserName = $userName;
	
		$rows=pdoq("select name from groups g inner join user_groups us on g.group_id = us.group_id where us.user_id=?",$userId);
		$rows1=pdoq("select attribute_value from custom_attribute_values where attribute_category=2 and entity_id=?",$userId);
		
		$group = count($rows) ? $rows[0]->name : '';
		$level = count($rows1) ? $rows1[0]->attribute_value : '';
		
		if(!empty($group) && !empty($level))
			$this->DisplayName = "{$full} ($group - $level)";
		else if(!empty($group))
			$this->DisplayName = "{$full} ($group)";
		else if(!empty($level))
			$this->DisplayName = "{$full} ($level)";
		else
			$this->DisplayName = "{$full}";
        //den mas endiaferoun ta alla pros to parwn
        $this->DisplayName = "{$full} ($group)";
	}
}

class AutoCompleteType
{
	const User = 'user';
	const Group = 'group';
	const MyUsers = 'myUsers';
}

?>