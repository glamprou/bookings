<?php

abstract class EmailMessage implements IEmailMessage
{
	/**
	 * @var SmartyPage
	 */
	private $email;
	/**
	 * @var string|null
	 */
	private $attachmentContents;
	/**
	 * @var string|null
	 */
	private $attachmentFileName;

	protected function __construct($languageCode = null)
	{
		$resources = new Resources();
		if (!empty($languageCode))
		{
			$resources->SetLanguage($languageCode);
		}
		$this->email = new SmartyPage($resources);
		$this->Set('ScriptUrl', Configuration::Instance()->GetScriptUrl());
		$this->Set('Charset', $resources->Charset);
	}

	protected function Set($var, $value)
	{
		$this->email->assign($var, $value);
	}

	protected function FetchTemplate($templateName)
	{
		return $this->email->FetchLocalized($templateName);
	}

	protected function Translate($key, $args = array())
	{
		if (!is_array($args))
		{
			$args = array($args);
		}
		return $this->email->SmartyTranslate(array('key' => $key, 'args' => implode(',', $args)), $this->email);
	}

	public function ReplyTo()
	{
		return $this->From();
	}

	public function From()
	{
		return new EmailAddress(Configuration::Instance()->GetKey(ConfigKeys::ADMIN_EMAIL));
	}

	public function CC()
	{
		return array();
	}

	public function BCC()
	{
		return array();
	}

	public function Charset()
	{
		return $this->email->getTemplateVars('Charset');
	}

	public function AddStringAttachment($contents, $fileName)
	{
		$this->attachmentContents = $contents;
		$this->attachmentFileName = $fileName;
	}

	public function HasStringAttachment()
	{
		return !empty($this->attachmentContents);
	}

	public function AttachmentContents()
	{
		return $this->attachmentContents;
	}

	public function AttachmentFileName()
	{
		return $this->attachmentFileName;
	}

}

?>