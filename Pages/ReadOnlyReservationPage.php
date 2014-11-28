<?php

require_once(ROOT_DIR . 'Pages/Ajax/AutoCompletePage.php');
require_once(ROOT_DIR . 'Pages/NewReservationPage.php');
require_once(ROOT_DIR . 'Pages/ExistingReservationPage.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/ViewSchedulePermissionServiceFactory.php');

class ReadOnlyReservationPage extends ExistingReservationPage
{
	public function __construct()
	{
		$this->permissionServiceFactory = new ViewSchedulePermissionServiceFactory();
		parent::__construct();
		$this->IsEditable = false;
		$this->IsApprovable = false;
	}

	public function PageLoad()
	{
		parent::PageLoad();
	}

	function SetIsEditable($canBeEdited)
	{
		// no-op
	}

	public function SetIsApprovable($canBeApproved)
	{
		// no-op
	}
}


?>