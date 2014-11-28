<?php

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class CustomAttributeDefinitionResponse extends RestResponse
{
	public $id;
	public $categoryId;
	public $label;
	public $possibleValues = array();
	public $regex;
	public $required = false;

	public function __construct(IRestServer $server, CustomAttribute $attribute)
	{
		$this->id = $attribute->Id();
		$this->categoryId = $attribute->Category();
		$this->label = $attribute->Label();
		$this->possibleValues = $attribute->PossibleValueList();
		$this->regex = $attribute->Regex();
		$this->required = $attribute->Required();

		$this->AddService($server, WebServices::AllCustomAttributes,
						  array(WebServiceParams::AttributeCategoryId => $this->categoryId));
		$this->AddService($server, WebServices::GetCustomAttribute, array(WebServiceParams::AttributeId => $this->id));
	}

	public static function Example()
	{
		return new ExampleCustomAttributeDefinitionResponse();
	}
}

class ExampleCustomAttributeDefinitionResponse extends CustomAttributeDefinitionResponse
{
	public function __construct()
	{
		$this->id = 1;
		$this->categoryId = CustomAttributeCategory::RESOURCE;
		$this->label = 'display label';
		$this->possibleValues = array('possible', 'values');
		$this->regex = 'validation regex';
		$this->required = true;
	}
}

?>