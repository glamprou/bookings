<?php
interface IReportColumns
{
	/**
	 * @param $columnName string
	 * @return bool
	 */
	public function Exists($columnName);

	/**
	 * @abstract
	 * @return array|string
	 */
	public function GetAll();
}
?>