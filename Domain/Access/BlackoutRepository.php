<?php

require_once(ROOT_DIR . 'Domain/Blackout.php');

interface IBlackoutRepository
{
	/**
	 * @abstract
	 * @param Blackout $blackout
	 * @return int
	 */
	public function Add(Blackout $blackout);

    /**
     * @abstract
     * @param int $blackoutId
     */
    public function Delete($blackoutId);
}

class BlackoutRepository implements IBlackoutRepository
{
	/**
	 * @param Blackout $blackout
	 * @return int
	 */
	public function Add(Blackout $blackout)
	{
		$db = ServiceLocator::GetDatabase();
		$seriesId = $db->ExecuteInsert(new AddBlackoutCommand($blackout->OwnerId(), $blackout->ResourceId(), $blackout->Title()));
		return $db->ExecuteInsert(new AddBlackoutInstanceCommand($seriesId, $blackout->StartDate(), $blackout->EndDate()));
	}

    /**
     * @param int $blackoutId
     */
    public function Delete($blackoutId)
    {
        ServiceLocator::GetDatabase()->Execute(new DeleteBlackoutCommand($blackoutId));
    }
}
