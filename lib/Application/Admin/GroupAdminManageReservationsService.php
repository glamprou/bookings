<?php

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class GroupAdminManageReservationsService implements IManageReservationsService
{
    /**
     * @var IUserRepository
     */
    private $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param $pageNumber int
     * @param $pageSize int
     * @param $filter ReservationFilter
     * @param $userSession UserSession
     * @return PageableData
     */
    public function LoadFiltered($pageNumber, $pageSize, $filter, $userSession)
    {
        $user = $this->userRepository->LoadById($userSession->UserId);

        $adminGroups = $user->GetAdminGroups();
        $groupIds = array();
        foreach ($adminGroups as $group)
        {
            $groupIds[] = $group->GroupId;
        }

        $command = new GetFullGroupReservationListCommand($groupIds);

        if ($filter != null)
        {
            $command = new FilterCommand($command, $filter->GetFilter());
        }

        $builder = array('ReservationItemView', 'Populate');
        return PageableDataStore::GetList($command, $builder, $pageNumber, $pageSize);
    }
}

?>