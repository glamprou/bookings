<?php

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationCreatedEmailAdmin.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationUpdatedEmailAdmin.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationDeletedEmailAdmin.php');

abstract class AdminEmailNotification implements IReservationNotification
{
    /**
     * @var IUserRepository
     */
    private $userRepo;

    /**
     * @var IUserViewRepository
     */
    private $userViewRepo;

    /**
     * @param IUserRepository $userRepo
     * @param IUserViewRepository $userViewRepo
     */
    public function __construct(IUserRepository $userRepo, IUserViewRepository $userViewRepo)
    {
        $this->userRepo = $userRepo;
        $this->userViewRepo = $userViewRepo;
    }

    /**
     * @param ReservationSeries $reservationSeries
     * @return
     */
    public function Notify($reservationSeries)
    {
        $resourceAdmins = array();
        $applicationAdmins = array();
        $groupAdmins = array();

        if ($this->SendForResourceAdmins())
        {
            $resourceAdmins = $this->userViewRepo->GetResourceAdmins($reservationSeries->ResourceId());
        }
        if ($this->SendForApplicationAdmins())
        {
            $applicationAdmins = $this->userViewRepo->GetApplicationAdmins();
        }
        if ($this->SendForGroupAdmins())
        {
            $groupAdmins = $this->userViewRepo->GetGroupAdmins($reservationSeries->UserId());
        }

        $admins = array_merge($resourceAdmins, $applicationAdmins, $groupAdmins);

        if (count($admins) == 0)
        {
            // skip if there is nobody to send to
            return;
        }

        $owner = $this->userRepo->LoadById($reservationSeries->UserId());
        $resource = $reservationSeries->Resource();

        $adminIds = array();
        /** @var $admin UserDto */
        foreach ($admins as $admin)
        {
            $id = $admin->Id();
            if (array_key_exists($id, $adminIds) || $id == $owner->Id())
            {
                // only send to each person once
                continue;
            }
            $adminIds[$id] = true;

            $message = $this->GetMessage($admin, $owner, $reservationSeries, $resource);
            ServiceLocator::GetEmailService()->Send($message);
        }
    }

    /**
     * @return IEmailMessage
     */
    protected abstract function GetMessage($admin, $owner, $reservationSeries, $resource);

    /**
     * @return bool
     */
    protected abstract function SendForResourceAdmins();

    /**
     * @return bool
     */
    protected abstract function SendForApplicationAdmins();

    /**
     * @return bool
     */
    protected abstract function SendForGroupAdmins();
}

class AdminEmailCreatedNotification extends AdminEmailNotification
{
    protected function GetMessage($admin, $owner, $reservationSeries, $resource)
    {
        return new ReservationCreatedEmailAdmin($admin, $owner, $reservationSeries, $resource);
    }

    protected function SendForResourceAdmins()
    {
        return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
                                                        ConfigKeys::NOTIFY_CREATE_RESOURCE_ADMINS,
                                                        new BooleanConverter());
    }

    protected function SendForApplicationAdmins()
    {
        return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
                                                        ConfigKeys::NOTIFY_CREATE_APPLICATION_ADMINS,
                                                        new BooleanConverter());
    }

    protected function SendForGroupAdmins()
    {
        return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
                                                        ConfigKeys::NOTIFY_CREATE_GROUP_ADMINS,
                                                        new BooleanConverter());
    }
}

class AdminEmailUpdatedNotification extends AdminEmailNotification
{
    protected function GetMessage($admin, $owner, $reservationSeries, $resource)
    {
        return new ReservationUpdatedEmailAdmin($admin, $owner, $reservationSeries, $resource);
    }

    protected function SendForResourceAdmins()
    {
        return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
                                                        ConfigKeys::NOTIFY_UPDATE_RESOURCE_ADMINS,
                                                        new BooleanConverter());
    }


    protected function SendForApplicationAdmins()
    {
        return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
                                                        ConfigKeys::NOTIFY_UPDATE_APPLICATION_ADMINS,
                                                        new BooleanConverter());
    }

    protected function SendForGroupAdmins()
    {
        return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
                                                        ConfigKeys::NOTIFY_UPDATE_GROUP_ADMINS,
                                                        new BooleanConverter());
    }
}

class AdminEmailDeletedNotification extends AdminEmailNotification
{
    protected function GetMessage($admin, $owner, $reservationSeries, $resource)
    {
        return new ReservationDeletedEmailAdmin($admin, $owner, $reservationSeries, $resource);
    }

    protected function SendForResourceAdmins()
    {
        return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
                                                        ConfigKeys::NOTIFY_DELETE_RESOURCE_ADMINS,
                                                        new BooleanConverter());
    }


    protected function SendForApplicationAdmins()
    {
        return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
                                                        ConfigKeys::NOTIFY_DELETE_APPLICATION_ADMINS,
                                                        new BooleanConverter());
    }

    protected function SendForGroupAdmins()
    {
        return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_NOTIFY,
                                                        ConfigKeys::NOTIFY_DELETE_GROUP_ADMINS,
                                                        new BooleanConverter());
    }
}
?>