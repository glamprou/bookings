<?php

require_once(ROOT_DIR . 'lib/Application/Reporting/ChartColumnDefinition.php');

class ReportCell
{
	/**
	 * @var string
	 */
	private $value;

	/**
	 * @var null|string
	 */
	private $chartValue;

	/**
	 * @var ChartType|string|null
	 */
	private $chartColumnType;

	/**
	 * @param string $value
	 * @param string|null $chartValue
	 * @param ChartColumnType|string|null $chartColumnType
	 * @param ChartGroup $chartGroup
	 */
	public function __construct($value, $chartValue = null, $chartColumnType = null, $chartGroup = null)
	{
		$this->value = $value;
		$this->chartValue = $chartValue;
		$this->chartColumnType = $chartColumnType;
		$this->chartGroup = $chartGroup;
	}

	public function Value()
	{
		return $this->value;
	}

	public function ChartValue()
	{
		return $this->chartValue;
	}

	public function GetChartColumnType()
	{
		return $this->chartColumnType;
	}

	public function GetChartGroup()
	{
		return $this->chartGroup;
	}

	public function __toString()
	{
		return $this->Value();
	}
}

abstract class ReportColumn
{
	/**
	 * @var string
	 */
	private $titleKey;

	/**
	 * @var ChartColumnDefinition
	 */
	private $chartColumnDefinition;

	/**
	 * @param $titleKey string
	 * @param $chartColumnDefinition ChartColumnDefinition
	 */
	public function __construct($titleKey, ChartColumnDefinition $chartColumnDefinition = null)
	{
		$this->titleKey = $titleKey;
		$this->chartColumnDefinition = $chartColumnDefinition;
	}

	/**
	 * @return string
	 */
	public function TitleKey()
	{
		return $this->titleKey;
	}

	/**
	 * @param $data mixed
	 * @return string
	 */
	public function GetData($data)
	{
		return $data;
	}

	/**
	 * @return ChartColumnType|string|null
	 */
	public function GetChartColumnType()
	{
		return $this->chartColumnDefinition->ChartColumnType();
	}

	/**
	 * @param $row array
	 * @param $columnKey string
	 * @return string
	 */
	public function GetChartData($row, $columnKey)
	{
		return $this->chartColumnDefinition->GetChartData($row, $columnKey);
	}

	/**
	 * @return ChartGroup|null|string
	 */
	public function GetChartGroup()
	{
		return $this->chartColumnDefinition->GetChartGroup();
	}
}

class ReportStringColumn extends ReportColumn
{
	public function __construct($titleKey, ChartColumnDefinition $chartColumnDefinition)
	{
		parent::__construct($titleKey, $chartColumnDefinition);
	}
}

class ReportDateColumn extends ReportColumn
{
	private $timezone;
	private $format;

	public function __construct($titleKey, $timezone, $format, ChartColumnDefinition $chartColumnDefinition)
	{
		parent::__construct($titleKey, $chartColumnDefinition);
		$this->timezone = $timezone;
		$this->format = $format;
	}

	public function GetData($data)
	{
		return Date::FromDatabase($data)->ToTimezone($this->timezone)->Format($this->format);
	}

	public function GetChartData($row, $key)
	{
		$format = Resources::GetInstance()->GetDateFormat(ResourceKeys::DATE_GENERAL);
		return Date::FromDatabase($row[$key])->ToTimezone($this->timezone)->GetDate()->Format($format);
	}
}

class ReportTimeColumn extends ReportColumn
{
	public function __construct($titleKey, ChartColumnDefinition $chartColumnDefinition)
	{
		parent::__construct($titleKey, $chartColumnDefinition);
	}

	public function GetData($data)
	{
		return new TimeInterval($data);
	}
}

?>