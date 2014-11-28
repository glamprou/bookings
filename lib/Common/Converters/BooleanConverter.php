<?php

class BooleanConverter implements IConvert
{
	public function Convert($value)
	{
		return $value === true || strtolower($value) == 'true';
	}
}
?>