<?php

require_once(ROOT_DIR . 'lib/Application/Reporting/namespace.php');

class CustomReport implements IReport
{
	/**
	 * @var CustomReportData
	 */
	private $data;
	/**
	 * @var ReportColumns
	 */
	private $cols;
	/**
	 * @var int
	 */
	private $resultCount = 0;

	public function __construct($rows)
	{
		$this->data = new CustomReportData($rows);
		$this->resultCount = count($rows);

		$this->cols = new ReportColumns();
		if (count($rows) > 0)
		{
			foreach ($rows[0] as $columnName => $value)
			{
				$this->cols->Add($columnName);
			}
		}
	}

	/**
	 * @return IReportColumns
	 */
	public function GetColumns()
	{
		return $this->cols;
	}

	/**
	 * @return IReportData
	 */
	public function GetData()
	{
		return $this->data;
	}

	/**
	 * @return int
	 */
	public function ResultCount()
	{
		return $this->resultCount;
	}

}

?>