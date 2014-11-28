<?php

class ReportColumns implements IReportColumns
{
	private $knownColumns = array();

	/**
	 * @param $columnName string
	 */
	public function Add($columnName)
	{
		$this->knownColumns[] = $columnName;
	}

	public function Exists($columnName)
	{
		return in_array($columnName, $this->knownColumns);
	}

	/**
	 * @return array|string
	 */
	public function GetAll()
	{
		return $this->knownColumns;
	}
}

?>