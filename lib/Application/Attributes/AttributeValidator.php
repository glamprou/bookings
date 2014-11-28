<?php

require_once(ROOT_DIR . 'lib/Common/Validators/namespace.php');

class AttributeValidator extends ValidatorBase
{
	/**
	 * @var IAttributeService
	 */
	private $service;

	/**
	 * @var CustomAttributeCategory|int
	 */
	private $category;

	/**
	 * @var array|AttributeValue[]
	 */
	private $attributes;

	/**
	 * @var array|string[]
	 */
	private $messages;

	/**
	 * @param IAttributeService $service
	 * @param $category int|CustomAttributeCategory
	 * @param $attributes array|AttributeValue[]
	 */
	public function __construct(IAttributeService $service, $category, $attributes)
	{
		$this->service = $service;
		$this->category = $category;
		$this->attributes = $attributes;
	}

	/**
	 * @return void
	 */
	public function Validate()
	{
		if (empty($this->attributes))
		{
			$this->isValid = true;
			return;
		}

		$result = $this->service->Validate($this->category, $this->attributes);
		$this->isValid = $result->IsValid();
		$this->messages = $result->Errors();
	}

	public function Messages()
	{
		return $this->messages;
	}

}
?>