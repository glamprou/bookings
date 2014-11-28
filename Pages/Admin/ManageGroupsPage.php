<?php
 
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Pages/IPageable.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageGroupsPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

interface IManageGroupsPage extends IActionPage
{
	/**
	 * @abstract
	 * @return int
	 */
	public function GetGroupId();

	/**
	 * @abstract
	 * @param $groups GroupItemView[]|array
	 * @return void
	 */
	public function BindGroups($groups);

	/**
	 * @abstract
	 * @param PageInfo $pageInfo
	 * @return void
	 */
	public function BindPageInfo(PageInfo $pageInfo);

	/**
	 * @abstract
	 * @return int
	 */
	public function GetPageNumber();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetPageSize();

	/**
	 * @abstract
	 * @param $response string
	 * @return void
	 */
	public function SetJsonResponse($response);

	/**
	 * @abstract
	 * @return int
	 */
	public function GetUserId();

	/**
	 * @abstract
	 * @param $resources array|BookableResource[]
	 * @return void
	 */
	public function BindResources($resources);

	/**
	 * @abstract
	 * @param $roles array|RoleDto[]
	 * @return void
	 */
	public function BindRoles($roles);

	/**
	 * @abstract
	 * @return int[]|array
	 */
	public function GetAllowedResourceIds();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetGroupName();

	/**
	 * @abstract
	 * @return int[]|array
	 */
	public function GetRoleIds();

	/**
	 * @abstract
	 * @param $adminGroups GroupItemView[]|array
	 * @return void
	 */
	public function BindAdminGroups($adminGroups);

	/**
	 * @abstract
	 * @return int
	 */
	public function GetAdminGroupId();
}

class ManageGroupsPage extends ActionPage implements IManageGroupsPage
{
	protected $CanChangeRoles = true;
	/**
	 * @var ManageGroupsPresenter
	 */
	protected $presenter;

	/**
	 * @var PageablePage
	 */
	private $pageable;

	public function __construct()
	{
		parent::__construct('ManageGroups', 1);
		$this->presenter = new ManageGroupsPresenter($this, new GroupRepository(), new ResourceRepository());

		$this->pageable = new PageablePage($this);
	}
	
	public function ProcessPageLoad()
	{
		//set free groups
		$free_groups=array();
		$rows=pdoq("select group_id from groups where free_of_charge is not null");
		foreach($rows as $row){
			$free_groups[]=$row->group_id;
		}
		$this->Set('freeGroups', $free_groups);

        //set coach groups
        $coachesGroups = array();
        $rows=pdoq("select group_id from groups where coaches is not null");
        foreach($rows as $row){
            $coachesGroups[]=$row->group_id;
        }
        $this->Set('coachesGroups', $coachesGroups);

        //set free groups
        $guestsGroups=array();
        $rows=pdoq("select group_id from groups where guests is not null");
        foreach($rows as $row){
            $guestsGroups[]=$row->group_id;
        }
        $this->Set('guestsGroups', $guestsGroups);
		
		$this->presenter->PageLoad();
		$this->Set('chooseText', Resources::GetInstance()->GetString('Choose') . '...');
		$this->Set('CanChangeRoles', $this->CanChangeRoles);
		$this->Display('Admin/manage_groups.tpl');
	}

	public function BindPageInfo(PageInfo $pageInfo)
	{
		$this->pageable->BindPageInfo($pageInfo);
	}

	public function GetPageNumber()
	{
		return $this->pageable->GetPageNumber();
	}

	public function GetPageSize()
	{
		return $this->pageable->GetPageSize();
	}
	
	public function BindGroups($groups)
	{
		$this->Set('groups', $groups);
	}
	
	public function ProcessAction()
	{
		$this->presenter->ProcessAction();
	}

	/**
	 * @return int
	 */
	public function GetGroupId()
	{
		return $this->GetQuerystring(QueryStringKeys::GROUP_ID);
	}

	public function SetJsonResponse($response)
	{
		parent::SetJson($response);
	}

	public function GetUserId()
	{
		return $this->GetForm(FormKeys::USER_ID);
	}

	public function BindResources($resources)
	{
		$this->Set('resources', $resources);
	}

	public function GetAllowedResourceIds()
	{
		return $this->GetForm(FormKeys::RESOURCE_ID);
	}

	public function GetGroupName()
	{
		return $this->GetForm(FormKeys::GROUP_NAME);
	}

	public function BindRoles($roles)
	{
		$this->Set('Roles', $roles);
	}

	/**
	 * @return int[]|array
	 */
	public function GetRoleIds()
	{
		return $this->GetForm(FormKeys::ROLE_ID);
	}

	/**
	 * @param $adminGroups GroupItemView[]|array
	 * @return void
	 */
	public function BindAdminGroups($adminGroups)
	{
		$this->Set('AdminGroups', $adminGroups);
	}

	/**
	 * @return int
	 */
	public function GetAdminGroupId()
	{
		return $this->GetForm(FormKeys::GROUP_ADMIN);
	}

	/**
	 * @param $dataRequest string
	 * @return void
	 */
	public function ProcessDataRequest($dataRequest)
	{
		$this->presenter->ProcessDataRequest();
	}
}
?>