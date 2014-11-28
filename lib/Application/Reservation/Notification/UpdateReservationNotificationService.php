<?php

require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/IReservationNotificationService.php');

class UpdateReservationNotificationService extends ReservationNotificationService
{
	public function __construct(IUserRepository $userRepo, IResourceRepository $resourceRepo)
	{
		$notifications = array();
		$notifications[] = new OwnerEmailUpdatedNotification($userRepo, $resourceRepo);
		$notifications[] = new AdminEmailUpdatedNotification($userRepo, $userRepo);
		$notifications[] = new ParticipantAddedEmailNotification($userRepo, $resourceRepo);
		$notifications[] = new InviteeAddedEmailNotification($userRepo, $resourceRepo);

		parent::__construct($notifications);
	}
}
?>