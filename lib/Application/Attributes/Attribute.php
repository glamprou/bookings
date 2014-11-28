<?php

class Attribute
{
	/**
	 * @var CustomAttribute
	 */
	private $attributeDefinition;

	/**
	 * @var mixed
	 */
	private $value;

	public function __construct(CustomAttribute $attributeDefinition, $value = null)
	{
		$this->attributeDefinition = $attributeDefinition;
		$this->value = $value;
	}

	/**
	 * @return string
	 */
	public function Label()
	{
		return $this->attributeDefinition->Label();
	}

	/**
	 * @return int
	 */
	public function Id()
	{
		return $this->attributeDefinition->Id();
	}

	/**
	 * @return mixed
	 */
	public function Value()
	{
		return $this->value;
	}

	/**
	 * @return CustomAttributeTypes|int
	 */
	public function Type()
	{
		return $this->attributeDefinition->Type();
	}

	/**
	 * @return array|string[]
	 */
	public function PossibleValueList()
	{
		return $this->attributeDefinition->PossibleValueList();
	}

	/**
	 * @return boolean
	 */
	public function Required()
	{
		return $this->attributeDefinition->Required();
	}
}

?>