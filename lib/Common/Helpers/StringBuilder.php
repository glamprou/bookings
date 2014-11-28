<?php

class StringBuilder 
{
	private $_string = array();
	
	public function Append($string) 
	{
		$this->_string[] = $string;
	}

	public function AppendLine($string = '')
	{
		$this->_string[] = $string . "\n";
	}

	public function PrependLine($string = '')
	{
		array_unshift($this->_string, $string . "\n");
	}

	public function ToString() 
	{
		return join('', $this->_string);
	}
}
?>