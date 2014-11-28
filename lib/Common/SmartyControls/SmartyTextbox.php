<?php


class SmartyTextbox
{
	private $name;
    private $id;
	private $attributes;
	private $smartyVariable;
	private $smarty;
	
	public function __construct($formKey, $id, $smartyVariable, $attributes, &$smarty)
	{
		$this->name = $this->GetName($formKey);
        $this->id = empty($id) ? $this->GetName($formKey) : $id;
		$this->attributes = $attributes;
		$this->smartyVariable = $smartyVariable;
		$this->smarty = $smarty;
	}
	
	public function Html()
	{
		$value = $this->GetValue();
		$style = empty($this->style) ? '' : " style=\"{$this->style}\"";
		
		return "<input type=\"{$this->GetInputType()}\" name=\"{$this->name}\" id=\"{$this->id}\" value=\"$value\" $this->attributes />";
	}
	
	protected function GetInputType()
	{
		return 'text';
	}
	
	private function GetName($formKey)
	{
		return FormKeys::Evaluate($formKey);
	}
	
	private function GetValue()
	{
		$value = $this->GetPostedValue();

		if (empty($value))
		{
			$value = $this->GetTemplateValue();
		}
		
		if (!empty($value))
		{
			return trim($value);
		}
		
		return '';
	}
	
	private function GetPostedValue()
	{
		return ServiceLocator::GetServer()->GetForm($this->name);
	}
	
	private function GetTemplateValue()
	{
		$value = '';
		
		if (!empty($this->smartyVariable))
		{
			$var = $this->smarty->getTemplateVars($this->smartyVariable);
			if (!empty($var))
			{
				$value = $var;
			}
		}		
		
		return $value;
	}
}

class SmartyPasswordbox extends SmartyTextbox
{
	protected function GetInputType()
	{
		return 'password';
	}
}
?>