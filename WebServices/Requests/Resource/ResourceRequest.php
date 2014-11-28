<?php

require_once(ROOT_DIR . 'lib/WebService/JsonRequest.php');
require_once(ROOT_DIR . 'WebServices/Requests/AttributeValueRequest.php');

class ResourceRequest extends JsonRequest
{
	/**
	 * @var string
	 */
	public $name;
	/**
	 * @var string
	 */
	public $location;
	/**
	 * @var string
	 */
	public $contact;
	/**
	 * @var string
	 */
	public $notes;
	/**
	 * @var string
	 */
	public $minLength;
	/**
	 * @var string
	 */
	public $maxLength;
	/**
	 * @var bool
	 */
	public $requiresApproval;
	/**
	 * @var bool
	 */
	public $allowMultiday;
	/**
	 * @var int
	 */
	public $maxParticipants;
	/**
	 * @var string
	 */
	public $minNotice;
	/**
	 * @var string
	 */
	public $maxNotice;
	/**
	 * @var string
	 */
	public $description;
	/**
	 * @var int
	 */
	public $scheduleId;
	/**
	 * @var bool
	 */
	public $autoAssignPermissions;
	/**
	 * @var array|AttributeValueRequest[]
	 */
	public $customAttributes = array();
	/**
	 * @var int
	 */
	public $sortOrder;
	/**
	 * @var bool
	 */
	public $isOnline;

	/**
	 * @return ExampleResourceRequest
	 */
	public static function Example()
	{
		return new ExampleResourceRequest();
	}

	/**
	 * @return array|AttributeValueRequest[]
	 */
	public function GetCustomAttributes()
	{
		if (!empty($this->customAttributes))
		{
			return $this->customAttributes;
		}
		return array();
	}
}

class ExampleResourceRequest extends ResourceRequest
{
	public function __construct()
	{
		$this->name = 'resource name';
		$this->location = 'location';
		$this->contact = 'contact information';
		$this->notes = 'notes';
		$this->minLength = '1d0h0m';
		$this->maxLength = '3600';
		$this->requiresApproval = true;
		$this->allowMultiday = true;
		$this->maxParticipants = 100;
		$this->minNotice = '86400';
		$this->maxNotice = '0d12h30m';
		$this->description = 'description';
		$this->scheduleId = 10;
		$this->autoAssignPermissions = true;
		$this->customAttributes = array(AttributeValueRequest::Example());
		$this->sortOrder = 1;
		$this->isOnline = true;
	}
}

?>