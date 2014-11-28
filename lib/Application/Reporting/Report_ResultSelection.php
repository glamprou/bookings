<?php

class Report_ResultSelection
{
	const COUNT = 'COUNT';
	const TIME = 'TIME';
	const FULL_LIST = 'LIST';
    const TRAINING = 'TRAINING';

	/**
	 * @var Report_ResultSelection|string
	 */
	private $selection;

	/**
	 * @param $selection string|Report_ResultSelection
	 */
	public function __construct($selection)
	{
		$this->selection = $selection;
	}

	public function Add(ReportCommandBuilder $builder)
	{
		if ($this->selection == self::FULL_LIST)
		{
			$builder->SelectFullList();
		}
		if ($this->selection == self::COUNT)
		{
			$builder->SelectCount();
		}
		if ($this->selection == self::TIME)
		{
			$builder->SelectTime();
		}
	}

	/**
	 * @param $selection string
	 * @return bool
	 */
	public function Equals($selection)
	{
		return $this->selection == $selection;
	}

	public function __toString()
	{
		return $this->selection;
	}
}

?>