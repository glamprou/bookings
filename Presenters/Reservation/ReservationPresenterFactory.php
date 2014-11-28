<?php

require_once(ROOT_DIR . 'Presenters/Reservation/ReservationSavePresenter.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationUpdatePresenter.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationDeletePresenter.php');

interface IReservationPresenterFactory
{
	/**
	 * @param IReservationSavePage $savePage
	 * @param UserSession $userSession
	 * @return ReservationSavePresenter
	 */
	public function Create(IReservationSavePage $savePage, UserSession $userSession);

	/**
	 * @param IReservationUpdatePage $updatePage
	 * @param UserSession $userSession
	 * @return ReservationUpdatePresenter
	 */
	public function Update(IReservationUpdatePage $updatePage, UserSession $userSession);

	/**
	 * @param IReservationDeletePage $deletePage
	 * @param UserSession $userSession
	 * @return ReservationDeletePresenter
	 */
	public function Delete(IReservationDeletePage $deletePage, UserSession $userSession);
}

class ReservationPresenterFactory implements IReservationPresenterFactory
{
	public function Create(IReservationSavePage $savePage, UserSession $userSession)
	{
		$persistenceFactory = new ReservationPersistenceFactory();
		$resourceRepository = new ResourceRepository();
		$reservationAction = ReservationAction::Create;
		$handler = ReservationHandler::Create($reservationAction,
											  $persistenceFactory->Create($reservationAction),
											  $userSession);

		return new ReservationSavePresenter($savePage, $persistenceFactory->Create($reservationAction), $handler, $resourceRepository, $userSession);
	}

	public function Update(IReservationUpdatePage $updatePage, UserSession $userSession)
	{
		$persistenceFactory = new ReservationPersistenceFactory();
		$resourceRepository = new ResourceRepository();
		$reservationAction = ReservationAction::Update;
		$handler = ReservationHandler::Create($reservationAction,
											  $persistenceFactory->Create($reservationAction),
											  $userSession);

		return new ReservationUpdatePresenter($updatePage, $persistenceFactory->Create($reservationAction), $handler, $resourceRepository, $userSession);
	}

	public function Delete(IReservationDeletePage $deletePage, UserSession $userSession)
	{
		$persistenceFactory = new ReservationPersistenceFactory();

		$deleteAction = ReservationAction::Delete;

		$handler = ReservationHandler::Create($deleteAction, $persistenceFactory->Create($deleteAction), $userSession);
		return new ReservationDeletePresenter(
			$deletePage,
			$persistenceFactory->Create($deleteAction),
			$handler,
			$userSession
		);
	}
}

?>