<?php


interface IQuotaRepository
{
	/**
	 * @abstract
	 * @return array|Quota[]
	 */
	function LoadAll();

	/**
	 * @abstract
	 * @param Quota $quota
	 * @return void
	 */
	function Add(Quota $quota);

	/**
	 * @abstract
	 * @param $quotaId
	 * @return void
	 */
	function DeleteById($quotaId);
}

interface IQuotaViewRepository
{
	/**
	 * @abstract
	 * @return array|QuotaItemView[]
	 */
	function GetAll();
}

class QuotaRepository implements IQuotaRepository, IQuotaViewRepository
{
	public function LoadAll()
	{
		$quotas = array();

		$command = new GetAllQuotasCommand();
		$reader = ServiceLocator::GetDatabase()->Query($command);

		while ($row = $reader->GetRow())
		{
			$quotaId = $row[ColumnNames::QUOTA_ID];

			$limit = Quota::CreateLimit($row[ColumnNames::QUOTA_LIMIT], $row[ColumnNames::QUOTA_UNIT]);
			$duration = Quota::CreateDuration($row[ColumnNames::QUOTA_DURATION]);

			$resourceId = $row[ColumnNames::RESOURCE_ID];
			$groupId = $row[ColumnNames::GROUP_ID];
			$scheduleId = $row[ColumnNames::SCHEDULE_ID];
			
			$quotas[] = new Quota($quotaId, $duration, $limit, $resourceId, $groupId, $scheduleId);
		}

		return $quotas;
	}

	/**
	 * @return array|QuotaItemView[]
	 */
	function GetAll()
	{
		$quotas = array();

		$command = new GetAllQuotasCommand();
		$reader = ServiceLocator::GetDatabase()->Query($command);

		while ($row = $reader->GetRow())
		{
			$quotaId = $row[ColumnNames::QUOTA_ID];

			$limit = $row[ColumnNames::QUOTA_LIMIT];
			$unit = $row[ColumnNames::QUOTA_UNIT];
			$duration = $row[ColumnNames::QUOTA_DURATION];
			$groupName = $row['group_name'];
			$resourceName = $row['resource_name'];
			$scheduleName = $row['schedule_name'];

			$quotas[] = new QuotaItemView($quotaId, $limit, $unit, $duration, $groupName, $resourceName, $scheduleName);
		}

		return $quotas;
	}

	/**
	 * @param Quota $quota
	 * @return void
	 */
	function Add(Quota $quota)
	{
		$command = new AddQuotaCommand($quota->GetDuration()->Name(), $quota->GetLimit()->Amount(), $quota->GetLimit()->Name(), $quota->ResourceId(), $quota->GroupId(), $quota->ScheduleId());

		ServiceLocator::GetDatabase()->Execute($command);
	}

	/**
	 * @param $quotaId
	 * @return void
	 */
	function DeleteById($quotaId)
	{
		//TODO:  Make this delete a quota instead of the id
		$command = new DeleteQuotaCommand($quotaId);
		ServiceLocator::GetDatabase()->Execute($command);
	}
}

class QuotaItemView
{
	public $Id;
	public $Limit;
	public $Unit;
	public $Duration;
	public $GroupName;
	public $ResourceName;
	public $ScheduleName;

	/**
	 * @param int $quotaId
	 * @param decimal $limit
	 * @param string $unit
	 * @param string $duration
	 * @param string $groupName
	 * @param string $resourceName
	 * @param string $scheduleName
	 */
	public function __construct($quotaId, $limit, $unit, $duration, $groupName, $resourceName, $scheduleName)
	{
		$this->Id = $quotaId;
		$this->Limit = $limit;
		$this->Unit = $unit;
		$this->Duration = $duration;
		$this->GroupName = $groupName;
		$this->ResourceName = $resourceName;
		$this->ScheduleName = $scheduleName;
	}
}
?>