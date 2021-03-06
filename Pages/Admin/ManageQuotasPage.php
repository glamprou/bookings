<?php
 
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageQuotasPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

interface IManageQuotasPage extends IActionPage
{
	/**
	 * @abstract
	 * @param array|BookableResource[] $resources
	 * @return void
	 */
	public function BindResources($resources);

	/**
	 * @abstract
	 * @param array|GroupItemView[] $groups
	 * @return void
	 */
	public function BindGroups($groups);

	/**
	 * @abstract
	 * @param array|Schedule[] $schedules
	 * @return void
	 */
	public function BindSchedules($schedules);

	/**
	 * @abstract
	 * @param array|QuotaItemView[] $quotas
	 * @return void
	 */
	public function BindQuotas($quotas);

	/**
	 * @abstract
	 * @return string
	 */
	public function GetDuration();

	/**
	 * @abstract
	 * @return decimal
	 */
	public function GetLimit();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetResourceId();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetGroupId();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetUnit();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetQuotaId();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetScheduleId();


}

class ManageQuotasPage extends ActionPage implements IManageQuotasPage
{
	/**
	 * @var \ManageQuotasPresenter
	 */
	private $presenter;
	
	public function __construct()
	{
		parent::__construct('ManageQuotas', 1);
		$this->presenter = new ManageQuotasPresenter(
			$this,
			new ResourceRepository(),
			new GroupRepository(),
			new ScheduleRepository(),
			new QuotaRepository());
	}
	
	public function ProcessPageLoad()
	{
		$this->presenter->PageLoad();

		$this->Display('Admin/manage_quotas.tpl');
	}

	public function ProcessAction()
	{
		$this->presenter->ProcessAction();
	}

	public function SetJsonResponse($response)
	{
		parent::SetJson($response);
	}

	/**
	 * @param array|BookableResource[] $resources
	 * @return void
	 */
	public function BindResources($resources)
	{
		$this->Set('Resources', $resources);
	}

	/**
	 * @param array|GroupItemView[] $groups
	 * @return void
	 */
	public function BindGroups($groups)
	{
		$this->Set('Groups', $groups);
	}


	/**
	 * @param array|Schedule[] $schedules
	 * @return void
	 */
	public function BindSchedules($schedules)
	{
		$this->Set('Schedules', $schedules);
	}

	/**
	 * @param array|QuotaItemView[] $quotas
	 * @return void
	 */
	public function BindQuotas($quotas)
	{
		$this->Set('Quotas', $quotas);
	}

	/**
	 * @return string
	 */
	public function GetDuration()
	{
		return $this->GetForm(FormKeys::DURATION);
	}

	/**
	 * @return string
	 */
	public function GetLimit()
	{
		return $this->GetForm(FormKeys::LIMIT);
	}

	/**
	 * @return int
	 */
	public function GetResourceId()
	{
		return $this->GetForm(FormKeys::RESOURCE_ID);
	}

	/**
	 * @return int
	 */
	public function GetGroupId()
	{
		return $this->GetForm(FormKeys::GROUP);
	}

	/**
	 * @return string
	 */
	public function GetUnit()
	{
		return $this->GetForm(FormKeys::UNIT);
	}

	/**
	 * @return int
	 */
	public function GetQuotaId()
	{
		return $this->GetQuerystring(QueryStringKeys::QUOTA_ID);
	}

	/**
	 * @return int
	 */
	public function GetScheduleId()
	{
		return $this->GetForm(FormKeys::SCHEDULE_ID);
	}

	public function ProcessDataRequest($dataRequest)
	{
		// no-op
	}
}
?>