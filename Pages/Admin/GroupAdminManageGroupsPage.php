<?php

require_once(ROOT_DIR . 'Pages/Admin/ManageGroupsPage.php');
require_once(ROOT_DIR . 'lib/Application/Admin/namespace.php');

class GroupAdminManageGroupsPage extends ManageGroupsPage
{
	public function __construct()
	{
		parent::__construct();

		$this->CanChangeRoles = false;
		$this->presenter = new ManageGroupsPresenter($this,
					new GroupAdminGroupRepository(new UserRepository(), ServiceLocator::GetServer()->GetUserSession()),
					new ResourceRepository());
	}

	public function ProcessPageLoad()
	{
		parent::ProcessPageLoad();
	}
}

?>