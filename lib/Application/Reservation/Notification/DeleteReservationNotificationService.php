<?php

require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/IReservationNotificationService.php');

class DeleteReservationNotificationService extends ReservationNotificationService
{
	public function __construct(IUserRepository $userRepo, IResourceRepository $resourceRepo)
	{
		$notifications = array();

        $notifications[] = new OwnerEmailDeletedNotification($userRepo);
        $notifications[] = new ParticipantDeletedEmailNotification($userRepo);
        $notifications[] = new AdminEmailDeletedNotification($userRepo, $userRepo);

		parent::__construct($notifications);
	}
}
?>