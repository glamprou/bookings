<?php

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationAttachmentPresenter.php');

interface IReservationAttachmentPage
{
	/**
	 * @abstract
	 * @return string
	 */
	public function GetFileId();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetReferenceNumber();

	/**
	 * @abstract
	 * @return void
	 */
	public function ShowError();

	/**
	 * @abstract
	 * @param ReservationAttachment $attachment
	 * @return void
	 */
	public function BindAttachment(ReservationAttachment $attachment);
}

class ReservationAttachmentPage extends SecurePage implements IReservationAttachmentPage
{
	/**
	 * @var ReservationAttachmentPresenter
	 */
	private $presenter;

	public function __construct()
	{
		parent::__construct('Error', 1);
	}

	public function PageLoad()
	{
		$this->presenter = new ReservationAttachmentPresenter($this, new ReservationRepository(), PluginManager::Instance()->LoadPermission());
		$this->presenter->PageLoad(ServiceLocator::GetServer()->GetUserSession());
	}

	/**
	 * @return string
	 */
	public function GetFileId()
	{
		return $this->GetQuerystring(QueryStringKeys::ATTACHMENT_FILE_ID);
	}

	/**
	 * @return string
	 */
	public function GetReferenceNumber()
	{
		return $this->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER);
	}

	/**
	 * @return void
	 */
	public function ShowError()
	{
		$this->Display('Reservation/attachment-error.tpl');
	}

	/**
	 * @param ReservationAttachment $attachment
	 * @return void
	 */
	public function BindAttachment(ReservationAttachment $attachment)
	{
		header('Content-Type: ' . $attachment->FileType());
		header('Content-Disposition: attachment; filename="' . $attachment->FileName() . '"');
		ob_clean();
		flush();
		echo $attachment->FileContents();
	}
}

?>