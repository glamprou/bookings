<?php

require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationEvents.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationCreatedEmail.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationUpdatedEmail.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationDeletedEmail.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationApprovedEmail.php');

abstract class OwnerEmailNotification implements IReservationNotification
{
	/**
	 * @var IUserRepository
	 */
	private $_userRepo;
	
	/**
	 * @param IUserRepository $userRepo
	 */
	public function __construct(IUserRepository $userRepo)
	{
		$this->_userRepo = $userRepo;
	}

	/**
	 * @param ReservationSeries $reservation
	 * @return void
	 */
	public function Notify($reservation)
	{
		$owner = $this->_userRepo->LoadById($reservation->UserId());
		if ($this->ShouldSend($owner))
		{
			$message = $this->GetMessage($owner, $reservation);
			ServiceLocator::GetEmailService()->Send($message);
		}
		else
		{
			Log::Debug('Owner does not want these types of email notifications. Email=%s, ReferenceNumber=%s', $owner->EmailAddress(), $reservation->CurrentInstance()->ReferenceNumber());
		}
	}
	
	/**
	 * @abstract
	 * @param $owner User
	 * @return bool
	 */
	protected abstract function ShouldSend(User $owner);
	
	/**
	 * @abstract
	 * @param $owner User
	 * @param $reservation ReservationSeries
	 * @return EmailMessage
	 */
	protected abstract function GetMessage(User $owner, ReservationSeries $reservation);
}

class OwnerEmailCreatedNotification extends OwnerEmailNotification
{
	protected function ShouldSend(User $owner)
	{
		return $owner->WantsEventEmail(new ReservationCreatedEvent());
	}
	
	protected function GetMessage(User $owner, ReservationSeries $reservation)
	{
		return new ReservationCreatedEmail($owner, $reservation);
	}	
}

class OwnerEmailUpdatedNotification extends OwnerEmailNotification
{
	protected function ShouldSend(User $owner)
	{
		return $owner->WantsEventEmail(new ReservationUpdatedEvent());
	}
	
	protected function GetMessage(User $owner, ReservationSeries $reservation)
	{
		return new ReservationUpdatedEmail($owner, $reservation);
	}	
}

class OwnerEmailApprovedNotification extends OwnerEmailNotification
{
	/**
	 * @param $owner User
	 * @return bool
	 */
	protected function ShouldSend(User $owner)
	{
		return $owner->WantsEventEmail(new ReservationApprovedEvent());
	}

	protected function GetMessage(User $owner, ReservationSeries $reservation)
	{
		return new ReservationApprovedEmail($owner, $reservation);
	}
}

class OwnerEmailDeletedNotification extends OwnerEmailNotification
{
    /**
     * @param $owner User
     * @return bool
     */
    protected function ShouldSend(User $owner)
    {
        return $owner->WantsEventEmail(new ReservationDeletedEvent());
    }

    protected function GetMessage(User $owner, ReservationSeries $reservation)
    {
        return new ReservationDeletedEmail($owner, $reservation);
    }
}
?>