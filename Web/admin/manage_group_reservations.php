<?php
 
define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'Pages/Admin/ResourceAdminManageReservationsPage.php');

class GroupAdminManageReservationsPage extends ManageReservationsPage
{
    public function __construct()
    {
        parent::__construct();
        $this->presenter = new ManageReservationsPresenter($this,
                    new GroupAdminManageReservationsService(new UserRepository()),
                    new ScheduleRepository(),
                    new ResourceRepository(),
					new AttributeService(new AttributeRepository()));
    }
}

$page = new RoleRestrictedPageDecorator(new GroupAdminManageReservationsPage(), array(RoleLevel::GROUP_ADMIN));
$page->PageLoad();
?>