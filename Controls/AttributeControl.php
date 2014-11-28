<?php

require_once(ROOT_DIR . 'Controls/Control.php');

class AttributeControl extends Control
{
	public function __construct(SmartyPage $smarty)
	{
		parent::__construct($smarty);
	}
	
	public function PageLoad()
	{
		$templates[CustomAttributeTypes::CHECKBOX] = 'Checkbox.tpl';
		$templates[CustomAttributeTypes::MULTI_LINE_TEXTBOX] = 'MultiLineTextbox.tpl';
		$templates[CustomAttributeTypes::SELECT_LIST] = 'SelectList.tpl';
		$templates[CustomAttributeTypes::SINGLE_LINE_TEXTBOX] = 'SingleLineTextbox.tpl';
		/** @var $attribute Attribute */
		$attribute = $this->Get('attribute');

		$this->Set('attributeName', sprintf('%s[%s]', FormKeys::ATTRIBUTE_PREFIX, $attribute->Id()));
		$this->Display('Controls/Attributes/' . $templates[$attribute->Type()]);
	}
}
?>