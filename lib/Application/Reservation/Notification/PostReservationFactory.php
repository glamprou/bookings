<?php

interface IPostReservationFactory
{
    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostAddService(UserSession $userSession);

    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostUpdateService(UserSession $userSession);

    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostDeleteService(UserSession $userSession);

    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostApproveService(UserSession $userSession);
}

class PostReservationFactory implements IPostReservationFactory
{

    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostAddService(UserSession $userSession)
    {
        return new AddReservationNotificationService(new UserRepository(), new ResourceRepository());
    }

    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostUpdateService(UserSession $userSession)
    {
        return new UpdateReservationNotificationService(new UserRepository(), new ResourceRepository());
    }

    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostDeleteService(UserSession $userSession)
    {
        return new DeleteReservationNotificationService(new UserRepository(), new ResourceRepository());
    }

    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostApproveService(UserSession $userSession)
    {
        return new ApproveReservationNotificationService(new UserRepository(), new ResourceRepository());
    }
}
?>