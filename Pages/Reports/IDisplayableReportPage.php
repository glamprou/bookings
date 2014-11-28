<?php

interface IDisplayableReportPage
{
	public function BindReport(IReport $report, IReportDefinition $definition);

	public function DisplayError();

	public function ShowResults();

	public function PrintReport();

	public function ShowCsv();
}

?>