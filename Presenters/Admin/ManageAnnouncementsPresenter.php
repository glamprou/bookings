<?php

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');

class ManageAnnouncementsActions
{
	const Add = 'addAnnouncement';
	const Change = 'changeAnnouncement';
	const Delete = 'deleteAnnouncement';
}

class ManageAnnouncementsPresenter extends ActionPresenter
{
	/**
	 * @var IManageAnnouncementsPage
	 */
	private $page;

	/**
	 * @var IAnnouncementRepository
	 */
	private $announcementRepository;

	/**
	 * @param IManageAnnouncementsPage $page
	 * @param IAnnouncementRepository $announcementRepository
	 */
	public function __construct(IManageAnnouncementsPage $page, IAnnouncementRepository $announcementRepository)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->announcementRepository = $announcementRepository;

		$this->AddAction(ManageAnnouncementsActions::Add, 'AddAnnouncement');
		$this->AddAction(ManageAnnouncementsActions::Change, 'ChangeAnnouncement');
		$this->AddAction(ManageAnnouncementsActions::Delete, 'DeleteAnnouncement');
	}

	public function PageLoad()
	{
		$this->page->BindAnnouncements($this->announcementRepository->GetAll());
	}

	public function AddAnnouncement()
	{
        $user = ServiceLocator::GetServer()->GetUserSession();
		$text = $this->page->GetText();
		$start = Date::Parse($this->page->GetStart(), $user->Timezone);
		$end = Date::Parse($this->page->GetEnd(), $user->Timezone);
		$priority = $this->page->GetPriority();

		Log::Debug('Adding new Announcement');

		$this->announcementRepository->Add(Announcement::Create($text, $start, $end, $priority));
	}

	public function ChangeAnnouncement()
	{
        $user = ServiceLocator::GetServer()->GetUserSession();

        $id = $this->page->GetAnnouncementId();
        $text = $this->page->GetText();
        $start = Date::Parse($this->page->GetStart(), $user->Timezone);
        $end = Date::Parse($this->page->GetEnd(), $user->Timezone);
        $priority = $this->page->GetPriority();
				//$Important = $this->page->GetImportant();
		Log::Debug('Changing Announcement with id %s', $id);
//header("Location: www.google".$_POST[FormKeys::ANNOUNCEMENT_IMPORTANT].".com ");
		$announcement = $this->announcementRepository->LoadById($id);
        $announcement->SetText($text);
        $announcement->SetDates($start, $end);
        $announcement->SetPriority($priority);
				//eisagwgi tou important
				$important=0;
				if(isset($_POST[FormKeys::ANNOUNCEMENT_IMPORTANT])){
					$important=1;
				}
				$announcement->SetImportant($important);

		$this->announcementRepository->Update($announcement);
	}
	
	public function DeleteAnnouncement()
	{
		$id = $this->page->GetAnnouncementId();
		
		Log::Debug('Deleting Announcement with id %s', $id);

		$this->announcementRepository->Delete($id);
	}
}
?>