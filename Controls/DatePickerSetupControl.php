<?php

require_once(ROOT_DIR . 'Controls/Control.php');

class DatePickerSetupControl extends Control
{
	public function __construct(SmartyPage $smarty)
	{
		parent::__construct($smarty);
	}
	
	public function PageLoad()
	{
		$this->SetDefault('NumberOfMonths', 1);
		$this->SetDefault('ShowButtonPanel', 'false');
        $elementsToTrigger = '#' . $this->Get("ControlId");
        $altId = $this->Get("AltId");
        if (!empty($altId))
        {
            $elementsToTrigger .= ",#$altId";
        }
		$this->SetDefault('OnSelect', sprintf("function() { $('%s').trigger('change'); }", $elementsToTrigger));
		$this->SetDefault('FirstDay', 0);		
		
		$this->Set('DateFormat', Resources::GetInstance()->GetDateFormat('general_date_js'));
		$this->Set('AltFormat', Resources::GetInstance()->GetDateFormat('js_general_date'));
		$this->Set('DayNamesMin', $this->GetJsDayNames('two'));
		$this->Set('DayNamesShort', $this->GetJsDayNames('abbr'));
		$this->Set('DayNames', $this->GetJsDayNames('full'));
		$this->Set('MonthNames', $this->GetJsMonthNames('full'));
		$this->Set('MonthNamesShort', $this->GetJsMonthNames('abbr'));
		
		$this->Display('Controls/DatePickerSetup.tpl');
	}
	
	private function SetDefault($key, $value)
	{
		$item = $this->Get($key);
		if ($item == null)
		{
			$this->Set($key, $value);
		}
	}
	private function GetJsDayNames($dayKey)
	{
		return $this->GetJsArrayValues(Resources::GetInstance()->GetDays($dayKey));
	}
	
	private function GetJsMonthNames($monthKey)
	{
		return $this->GetJsArrayValues(Resources::GetInstance()->GetMonths($monthKey));
	}
	
	private function GetJsArrayValues($values)
	{
		return "['" . implode("','", $values) . "']";
	}
}
?>