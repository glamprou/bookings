<?php

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Pages/Reports/IDisplayableReportPage.php');
require_once(ROOT_DIR . 'Presenters/Reports/CommonReportsPresenter.php');

interface ICommonReportsPage extends IDisplayableReportPage, IActionPage
{

}

class CommonReportsPage extends ActionPage implements ICommonReportsPage
{
	/**
	 * @var CommonReportsPresenter
	 */
	private $presenter;

	public function __construct()
	{
		parent::__construct('CommonReports', 1);

		$this->presenter = new CommonReportsPresenter($this, ServiceLocator::GetServer()->GetUserSession(), new ReportingService(new ReportingRepository()));
	}

	/**
	 * @return void
	 */
	public function ProcessAction()
	{
		$this->presenter->ProcessAction();
	}

	/**
	 * @param $dataRequest string
	 * @return void
	 */
	public function ProcessDataRequest($dataRequest)
	{
		// no-op
	}

	/**
	 * @return void
	 */
	public function ProcessPageLoad()
	{
		$this->Display('Reports/common-reports.tpl');
	}

	public function BindReport(IReport $report, IReportDefinition $definition)
	{
		$this->Set('HideSave', true);
		$this->Set('Definition', $definition);
		$this->Set('Report', $report);
	}

	public function ShowCsv()
	{
		$this->DisplayCsv('Reports/custom-csv.tpl', 'report.csv');
	}

	public function DisplayError()
	{
		$this->Display('Reports/error.tpl');
	}

	public function ShowResults()
	{
		$this->Display('Reports/results-custom.tpl');
	}

	public function PrintReport()
	{
		$this->Display('Reports/print-custom-report.tpl');
	}

	/**
	 * @return int
	 */
	public function GetReportId()
	{
		return $this->GetQuerystring(QueryStringKeys::REPORT_ID);
	}

	/**
	 * @param string $emailAddress
	 */
	public function SetEmailAddress($emailAddress)
	{
		$this->Set('UserEmail', $emailAddress);
	}

	/**
	 * @return string
	 */
	public function GetEmailAddress()
	{
		return $this->GetForm(FormKeys::EMAIL);
	}
}

?>