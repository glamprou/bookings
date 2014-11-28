<?php

require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageSchedulesPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/ScheduleRepository.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');

interface IUpdateResourcePage
{
	/**
	 * @return int
	 */
	public function GetResourceId();

	/**
	 * @return int
	 */
	public function GetScheduleId();

	/**
	 * @return string
	 */
	public function GetResourceName();

	/**
	 * @return UploadedFile
	 */
	public function GetUploadedImage();

	/**
	 * @return string
	 */
	public function GetLocation();

	/**
	 * @return string
	 */
	public function GetContact();

	/**
	 * @return string
	 */
	public function GetDescription();

	/**
	 * @return string
	 */
	public function GetNotes();

	/**
	 * @return string
	 */
	public function GetMinimumDuration();

	/**
	 * @return string
	 */
	public function GetMaximumDuration();

	/**
	 * @return string
	 */
	public function GetAllowMultiday();

	/**
	 * @return string
	 */
	public function GetRequiresApproval();

	/**
	 * @return string
	 */
	public function GetAutoAssign();

	/**
	 * @return string
	 */
	public function GetStartNoticeMinutes();

	/**
	 * @return string
	 */
	public function GetEndNoticeMinutes();

	/**
	 * @return string
	 */
	public function GetMaxParticipants();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetAdminGroupId();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetSortOrder();
}

interface IManageResourcesPage extends IUpdateResourcePage, IActionPage
{
	/**
	 * @param BookableResource[] $resources
	 */
	public function BindResources($resources);

	/**
	 * @param array $scheduleList array of (id, schedule name)
	 */
	public function BindSchedules($scheduleList);

	/**
	 * @abstract
	 * @param $adminGroups GroupItemView[]|array
	 * @return void
	 */
	public function BindAdminGroups($adminGroups);

	/**
	 * @abstract
	 * @param $attributeList IEntityAttributeList
	 */
	public function BindAttributeList($attributeList);

	/**
	 * @abstract
	 * @return AttributeFormElement[]|array
	 */
	public function GetAttributes();
}

class ManageResourcesPage extends ActionPage implements IManageResourcesPage
{
	/**
	 * @var ManageResourcesPresenter
	 */
	protected $_presenter;

	public function __construct()
	{
		parent::__construct('ManageResources', 1);
		$this->_presenter = new ManageResourcesPresenter(
			$this,
			new ResourceRepository(),
			new ScheduleRepository(),
			new ImageFactory(),
			new GroupRepository(),
			new AttributeService(new AttributeRepository())
		);
	}

	public function ProcessPageLoad()
	{
		$this->_presenter->PageLoad();
		
		//hours before reservation for edit/delete
		$this->smarty->assign('hoursbeforeres_val', sp_get_min_edit_time_seconds(true));
		//end

		$this->Display('Admin/manage_resources.tpl');
	}

	public function BindResources($resources)
	{
		$this->Set('Resources', $resources);
		
		//set weather variables		
		$rows=pdoq("select * from w_clouds order by id asc");
		$clouds=array();
		foreach($rows as $row){
			$clouds[]=$row;
		}
		
		$rows=pdoq("select * from w_winds order by id asc");
		$winds=array();
		foreach($rows as $row){
			$winds[]=$row;
		}
		$this->Set('clouds', $clouds);
		$this->Set('winds', $winds);
		//end
	}

	public function BindSchedules($schedules)
	{
		$this->Set('Schedules', $schedules);
	}

	public function ProcessAction()
	{
		$this->_presenter->ProcessAction();
	}

	public function GetResourceId()
	{
		return $this->GetQuerystring(QueryStringKeys::RESOURCE_ID);
	}

	public function GetScheduleId()
	{
		return $this->GetForm(FormKeys::SCHEDULE_ID);
	}

	public function GetResourceName()
	{
		return $this->GetForm(FormKeys::RESOURCE_NAME);
	}

	public function GetUploadedImage()
	{
		return $this->server->GetFile(FormKeys::RESOURCE_IMAGE);
	}

	public function GetLocation()
	{
		return $this->GetForm(FormKeys::RESOURCE_LOCATION);
	}

	public function GetContact()
	{
		return $this->GetForm(FormKeys::RESOURCE_CONTACT);
	}

	public function GetDescription()
	{
		return $this->GetForm(FormKeys::RESOURCE_DESCRIPTION);
	}

	public function GetNotes()
	{
		return $this->GetForm(FormKeys::RESOURCE_NOTES);
	}

	/**
	 * @return string
	 */
	public function GetMinimumDuration()
	{
		return $this->GetForm(FormKeys::MIN_DURATION);
	}

	/**
	 * @return string
	 */
	public function GetMaximumDuration()
	{
		return $this->GetForm(FormKeys::MAX_DURATION);
	}

	/**
	 * @return string
	 */
	public function GetAllowMultiday()
	{
		return $this->GetForm(FormKeys::ALLOW_MULTIDAY);
	}

	/**
	 * @return string
	 */
	public function GetRequiresApproval()
	{
		return $this->GetForm(FormKeys::REQUIRES_APPROVAL);
	}

	/**
	 * @return string
	 */
	public function GetAutoAssign()
	{
		return $this->GetForm(FormKeys::AUTO_ASSIGN);
	}

	/**
	 * @return string
	 */
	public function GetStartNoticeMinutes()
	{
		return $this->GetForm(FormKeys::MIN_NOTICE);
	}

	/**
	 * @return string
	 */
	public function GetEndNoticeMinutes()
	{
		return $this->GetForm(FormKeys::MAX_NOTICE);
	}

	/**
	 * @return string
	 */
	public function GetMaxParticipants()
	{
		return $this->GetForm(FormKeys::MAX_PARTICIPANTS);
	}

	/**
	 * @return int
	 */
	public function GetAdminGroupId()
	{
		return $this->GetForm(FormKeys::RESOURCE_ADMIN_GROUP_ID);
	}

	/**
	 * @param $adminGroups GroupItemView[]|array
	 * @return void
	 */
	function BindAdminGroups($adminGroups)
	{
		$this->Set('AdminGroups', $adminGroups);
		$groupLookup = array();
		foreach ($adminGroups as $group)
		{
			$groupLookup[$group->Id] = $group;
		}
		$this->Set('GroupLookup', $groupLookup);
	}

	public function ProcessDataRequest($dataRequest)
	{
		// no-op
	}

	/**
	 * @param $attributeList IEntityAttributeList
	 */
	public function BindAttributeList($attributeList)
	{
		// should bind labels and values per entity
		$defList = array();
		foreach ($attributeList->GetDefinitions() as $def)
		{
			$defList[] = new Attribute($def);
		}
		$this->Set('Definitions', $defList);
		$this->Set('AttributeList', $attributeList);
	}

	/**
	 * @return AttributeFormElement[]|array
	 */
	public function GetAttributes()
	{
		return AttributeFormParser::GetAttributes($this->GetForm(FormKeys::ATTRIBUTE_PREFIX));
	}

	/**
	 * @return int
	 */
	public function GetSortOrder()
	{
		return $this->GetForm(FormKeys::RESOURCE_SORT_ORDER);
	}
}

?>