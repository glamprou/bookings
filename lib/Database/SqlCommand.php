<?php

require_once(ROOT_DIR . 'lib/Database/ISqlCommand.php');
require_once(ROOT_DIR . 'lib/Database/SqlFilter.php');

class SqlCommand implements ISqlCommand
{
	public $Parameters = null;

	private $_paramNames = array();
	private $_values = array();
	private $_query = null;

	public function __construct($query = null)
	{
		$this->_query = $query;
		$this->Parameters = new Parameters();
	}

	public function SetParameters(Parameters &$parameters)
	{
		$this->_paramNames = array(); // Clean out contents
		$this->_values = array();

		$this->Parameters = & $parameters;

		for ($i = 0; $i < $this->Parameters->Count(); $i++)
		{
			$p = $this->Parameters->Items($i);
			$this->_paramNames[] = $p->Name;
			$this->_values[] = $p->Value;
		}
	}

	public function AddParameter(Parameter &$parameter)
	{
		$this->Parameters->Add($parameter);
	}

	public function GetQuery()
	{
		return $this->_query;
	}

	public function ToString()
	{
		$builder = new StringBuilder();
		$builder->append("Command: {$this->_query}\n");
		$builder->append("Parameters ({$this->Parameters->Count()}): \n");

		for ($i = 0; $i < $this->Parameters->Count(); $i++)
		{
			$parameter = $this->Parameters->Items($i);
			$builder->append("{$parameter->Name} = {$parameter->Value}");
		}

		return $builder->toString();
	}

	public function __toString()
	{
		return $this->ToString();
	}
}

class AdHocCommand extends SqlCommand
{
	public function __construct($rawSql)
	{
		parent::__construct($rawSql);
	}
}

class CountCommand extends SqlCommand
{
	/**
	 * @var SqlCommand
	 */
	private $baseCommand;

	public function __construct(SqlCommand $baseCommand)
	{
		parent::__construct();

		$this->baseCommand = $baseCommand;
		$this->Parameters = $baseCommand->Parameters;
	}

	public function GetQuery()
	{
		//afairesi tou group by gia swsto ypologismo tou count
		$groupbypos=strpos($this->baseCommand->GetQuery(),'GROUP BY');
		if($groupbypos!==FALSE){
			$orderbypos=strpos($this->baseCommand->GetQuery(),'ORDER BY');
			$length=$orderbypos-$groupbypos;
			$tmpstr=substr($this->baseCommand->GetQuery(),$groupbypos,$length);
			
			return preg_replace('/SELECT.+FROM/imsU', 'SELECT COUNT(DISTINCT ri.reservation_instance_id) as total FROM', str_replace($tmpstr,'',$this->baseCommand->GetQuery()), 1);
		}
		
		return preg_replace('/SELECT.+FROM/imsU', 'SELECT COUNT(*) as total FROM', $this->baseCommand->GetQuery(), 1);
	}
}

class FilterCommand extends SqlCommand
{
	/**
	 * @var SqlCommand
	 */
	private $baseCommand;

	/**
	 * @var \ISqlFilter
	 */
	private $filter;

	public function __construct(SqlCommand $baseCommand, ISqlFilter $filter)
	{
		$this->baseCommand = $baseCommand;
		$this->filter = $filter;

		$this->Parameters = $baseCommand->Parameters;
		$criterion = $filter->Criteria();
		/** @var $criteria Criteria */
		foreach ($criterion as $criteria)
		{
			$this->AddParameter(new Parameter($criteria->Variable, $criteria->Value));
		}
	}

	public function GetQuery()
	{
		$baseQuery = $this->baseCommand->GetQuery();
		$hasWhere = (stripos($baseQuery, 'WHERE') !== false);
		$hasOrderBy = (stripos($baseQuery, 'ORDER BY') !== false);
		$hasGroupBy = (stripos($baseQuery, 'GROUP BY') !== false);
		$newWhere = $this->filter->Where();

		if ($hasWhere)
		{
			// get between where and order by, replace with match plus new stuff
			$baseQuery = preg_replace('/WHERE/ims', 'WHERE (', $baseQuery, 1);

			$groupBySplit = preg_split("/GROUP BY/ims", $baseQuery);
			$orderBySplit = preg_split("/ORDER BY/ims", $baseQuery);

			if (count($groupBySplit) > 1)
			{
				$queryFragment = trim($groupBySplit[0]);
				$groupBy = trim($groupBySplit[1]);
				$query = "$queryFragment ) AND ($newWhere) GROUP BY $groupBy";
			}
			elseif (count($orderBySplit) > 1)
			{
				$queryFragment = trim($orderBySplit[0]);
				$orderBy = trim($orderBySplit[1]);
				$query = "$queryFragment ) AND ($newWhere) ORDER BY $orderBy";
			}
			else
			{
				$query = "$baseQuery) AND ($newWhere)";
			}
		}
		else {
			if ($hasGroupBy)
			{
				$query = str_ireplace('group by', " WHERE $newWhere GROUP BY", $baseQuery);
			}
			elseif ($hasOrderBy)
			{
				$query = str_ireplace('order by', " WHERE $newWhere ORDER BY", $baseQuery);
			}
			else
			{
				// no where, no order by, just append new where clause
				$query = "$baseQuery WHERE $newWhere";
			}
		}

		return $query;
	}
}

?>