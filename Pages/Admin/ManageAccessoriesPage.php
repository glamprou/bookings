<?php

require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageAccessoriesPresenter.php');

interface IManageAccessoriesPage extends IActionPage
{
	/**
	 * @abstract
	 * @return int
	 */
	public function GetAccessoryId();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetAccessoryName();

	/**
	 * @return int
	 */
	public function GetQuantityAvailable();

	/**
	 * @abstract
	 * @param $accessories AccessoryDto[]
	 * @return void
	 */
	public function BindAccessories($accessories);
}

class ManageAccessoriesPage extends ActionPage implements IManageAccessoriesPage
{
	/**
	 * @var ManageAccessoriesPresenter
	 */
	private $presenter;

	public function __construct()
	{
		parent::__construct('ManageAccessories', 1);
		$this->presenter = new ManageAccessoriesPresenter($this, new ResourceRepository(), new AccessoryRepository());
	}

	public function ProcessPageLoad()
	{
		$this->presenter->PageLoad();

		$this->Display('Admin/manage_accessories.tpl');
	}

	public function BindAccessories($accessories)
	{
		$this->Set('accessories', $accessories);
	}

	public function ProcessAction()
	{
		$this->presenter->ProcessAction();
	}

	/**
	 * @return int
	 */
	public function GetAccessoryId()
	{
		return $this->GetQuerystring(QueryStringKeys::ACCESSORY_ID);
	}

	/**
	 * @return string
	 */
	public function GetAccessoryName()
	{
		return $this->GetForm(FormKeys::ACCESSORY_NAME);
	}

	/**
	 * @return int
	 */
	public function GetQuantityAvailable()
	{
		return $this->GetForm(FormKeys::ACCESSORY_QUANTITY_AVAILABLE);
	}

	public function ProcessDataRequest($dataRequest)
	{
		// no-op
	}
}

?>