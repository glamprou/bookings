<?php

require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/IReservationNotificationService.php');

class AddReservationNotificationService extends ReservationNotificationService
{
	public function __construct(IUserRepository $userRepo, IResourceRepository $resourceRepo)
	{
		$notifications = array();
		$notifications[] = new OwnerEmailCreatedNotification($userRepo);
		$notifications[] = new AdminEmailCreatedNotification($userRepo, $userRepo);
		$notifications[] = new ParticipantAddedEmailNotification($userRepo);
		$notifications[] = new InviteeAddedEmailNotification($userRepo);

		parent::__construct($notifications);
	}
}
?>