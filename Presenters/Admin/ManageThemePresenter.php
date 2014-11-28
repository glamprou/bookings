<?php

require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');

class ManageThemePresenter extends ActionPresenter
{
	/**
	 * @var ManageThemePage
	 */
	private $page;

	public function __construct(ManageThemePage $page)
	{
		parent::__construct($page);
		$this->page = $page;
		$this->AddAction('update', 'UpdateTheme');
	}

	public function UpdateTheme()
	{
		$logoFile = $this->page->GetLogoFile();
		$cssFile = $this->page->GetCssFile();

		if ($logoFile != null)
		{
			Log::Debug('Replacing logo with ' . $logoFile->OriginalName());
			$target =  ROOT_DIR . 'Web/img/custom-logo.' . $logoFile->Extension();
			$copied = copy($logoFile->TemporaryName(), $target);
			if (!$copied)
			{
				Log::Error('Could not replace logo with %s. Ensure %s is writable.',
						   $logoFile->OriginalName(), $target);
			}
		}
		if ($cssFile != null)
		{
			Log::Debug('Replacing css file with ' . $cssFile->OriginalName());
			$target = ROOT_DIR . 'Web/css/custom-style.css';
			$copied = copy($cssFile->TemporaryName(), $target);
			if (!$copied)
			{
				Log::Error('Could not replace css with %s. Ensure %s is writable.',
						   $cssFile->OriginalName(), $target);
			}
		}
	}

	protected function LoadValidators($action)
	{
		$this->page->RegisterValidator('logoFile', new FileUploadValidator($this->page->GetLogoFile()));
		$this->page->RegisterValidator('logoFileExt',
									   new FileTypeValidator($this->page->GetLogoFile(), array('jpg', 'png', 'gif')));
		$this->page->RegisterValidator('cssFile', new FileUploadValidator($this->page->GetCssFile()));
		$this->page->RegisterValidator('cssFileExt', new FileTypeValidator($this->page->GetCssFile(), 'css'));
	}
}

?>