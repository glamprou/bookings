<?php

require_once(ROOT_DIR . 'lib/Application/Reporting/namespace.php');
require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReportEmailMessage.php');
require_once(ROOT_DIR . 'Domain/Access/ReportingRepository.php');

interface IReportingService
{
	/**
	 * @abstract
	 * @param Report_Usage $usage
	 * @param Report_ResultSelection $selection
	 * @param Report_GroupBy $groupBy
	 * @param Report_Range $range
	 * @param Report_Filter $filter
	 * @return IReport
	 */
	public function GenerateCustomReport(Report_Usage $usage, Report_ResultSelection $selection, Report_GroupBy $groupBy, Report_Range $range, Report_Filter $filter);

	/**
	 * @abstract
	 * @param string $reportName
	 * @param int $userId
	 * @param Report_Usage $usage
	 * @param Report_ResultSelection $selection
	 * @param Report_GroupBy $groupBy
	 * @param Report_Range $range
	 * @param Report_Filter $filter
	 */
	public function Save($reportName, $userId, Report_Usage $usage, Report_ResultSelection $selection, Report_GroupBy $groupBy, Report_Range $range, Report_Filter $filter);

	/**
	 * @abstract
	 * @param int $userId
	 * @return array|SavedReport[]
	 */
	public function GetSavedReports($userId);

	/**
	 * @abstract
	 * @param int $reportId
	 * @param int $userId
	 * @return IGeneratedSavedReport
	 */
	public function GenerateSavedReport($reportId, $userId);

	/**
	 * @param IGeneratedSavedReport $report
	 * @param IReportDefinition $definition
	 * @param string $toAddress
	 * @param UserSession $reportUser
	 */
	public function SendReport($report, $definition, $toAddress, $reportUser);

	/**
	 * @abstract
	 * @param int $reportId
	 * @param int $userId
	 */
	public function DeleteSavedReport($reportId, $userId);

	/**
	 * @abstract
	 * @param ICannedReport $cannedReport
	 * @return IReport
	 */
	public function GenerateCommonReport(ICannedReport $cannedReport);
}


class ReportingService implements IReportingService
{
	/**
	 * @var IReportingRepository
	 */
	private $repository;

	public function __construct(IReportingRepository $repository)
	{
		$this->repository = $repository;
	}

	public function GenerateCustomReport(Report_Usage $usage, Report_ResultSelection $selection, Report_GroupBy $groupBy, Report_Range $range, Report_Filter $filter)
	{
		$builder = new ReportCommandBuilder();

		$selection->Add($builder);
		if ($selection->Equals(Report_ResultSelection::FULL_LIST))
		{
			$usage->Add($builder);
		}
		$groupBy->Add($builder);
		$range->Add($builder);
		$filter->Add($builder);

		$data = $this->repository->GetCustomReport($builder);
		return new CustomReport($data);
	}

	public function Save($reportName, $userId, Report_Usage $usage, Report_ResultSelection $selection, Report_GroupBy $groupBy, Report_Range $range, Report_Filter $filter)
	{
		$report = new SavedReport($reportName, $userId, $usage, $selection, $groupBy, $range, $filter);
		$this->repository->SaveCustomReport($report);
	}

	public function GetSavedReports($userId)
	{
		return $this->repository->LoadSavedReportsForUser($userId);
	}

	public function GenerateSavedReport($reportId, $userId)
	{
		$savedReport = $this->repository->LoadSavedReportForUser($reportId, $userId);

		if ($savedReport == null)
		{
			return null;
		}

		$report = $this->GenerateCustomReport($savedReport->Usage(), $savedReport->Selection(), $savedReport->GroupBy(), $savedReport->Range(), $savedReport->Filter());

		return new GeneratedSavedReport($savedReport, $report);
	}

	public function SendReport($report, $definition, $toAddress, $reportUser)
	{
		$message = new ReportEmailMessage($report, $definition, $toAddress, $reportUser);
		ServiceLocator::GetEmailService()->Send($message);
	}

	public function DeleteSavedReport($reportId, $userId)
	{
		$this->repository->DeleteSavedReport($reportId, $userId);
	}

	public function GenerateCommonReport(ICannedReport $cannedReport)
	{
		$data = $this->repository->GetCustomReport($cannedReport->GetBuilder());
		return new CustomReport($data);
	}
}



?>