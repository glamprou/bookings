<?php

require_once(ROOT_DIR . 'Pages/Page.php');

interface IActionPage extends IPage
{
	public function TakingAction();

	public function GetAction();

	public function RequestingData();

	public function GetDataRequest();
}

abstract class ActionPage extends Page implements IActionPage
{
	public function __construct($titleKey, $pageDepth = 0)
	{
		parent::__construct($titleKey, $pageDepth);
	}

	public function PageLoad()
	{
		if ($this->TakingAction())
		{
			$this->ProcessAction();
		}
		else
		{
			if ($this->RequestingData())
			{
				$this->ProcessDataRequest($this->GetDataRequest());
			}
			else
			{
				$this->ProcessPageLoad();
			}
		}
	}
	/**
	 * @return bool
	 */
	public function TakingAction()
	{
		$action = $this->GetAction();
		return !empty($action);
	}

	/**
	 * @return bool
	 */
	public function RequestingData()
	{
		$dataRequest = $this->GetDataRequest();
		return !empty($dataRequest);
	}

	/**
	 * @return null|string
	 */
	public function GetAction()
	{
		return $this->GetQuerystring(QueryStringKeys::ACTION);
	}

	/**
	 * @return null|string
	 */
	public function GetDataRequest()
	{
		return $this->GetQuerystring(QueryStringKeys::DATA_REQUEST);
	}

	/**
	 * @return bool
	 */
	public function IsValid()
	{
		if (parent::IsValid())
		{
			Log::Debug('Action passed all validations');
			return true;
		}

		$errors = new ActionErrors();

		foreach ($this->smarty->failedValidators as $id => $validator)
		{
			Log::Debug('Failed validator %s', $id);
			$errors->Add($id, $validator->Messages());
		}

		$this->SetJson($errors);
		return false;
	}

	/**
	 * @abstract
	 * @return void
	 */
	public abstract function ProcessAction();

	/**
	 * @abstract
	 * @param $dataRequest string
	 * @return void
	 */
	public abstract function ProcessDataRequest($dataRequest);

	/**
	 * @abstract
	 * @return void
	 */
	public abstract function ProcessPageLoad();
}

class ActionErrors
{
    public $ErrorIds = array();
	public $Messages = array();

    public function Add($id, $messages = array())
    {
        $this->ErrorIds[] = $id;
		$this->Messages[$id] = $messages;
    }
}
?>