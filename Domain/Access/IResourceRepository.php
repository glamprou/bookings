<?php

interface IResourceRepository
{
	/**
	 * Gets all Resources for the given scheduleId
	 *
	 * @param int $scheduleId
	 * @return array|BookableResource[]
	 */
	public function GetScheduleResources($scheduleId);

	/**
	 * @param int $resourceId
	 * @return BookableResource
	 */
	public function LoadById($resourceId);

    /**
     * @param string $publicId
     * @return BookableResource
     */
    public function LoadByPublicId($publicId);

	/**
	 * @param BookableResource $resource
     * @return int ID of created resource
	 */
	public function Add(BookableResource $resource);

	/**
	 * @param BookableResource $resource
	 */
	public function Update(BookableResource $resource);

	/**
	 * @param BookableResource $resource
	 */
	public function Delete(BookableResource $resource);

	/**
	 * @return array|BookableResource[] array of all resources
	 */
	public function GetResourceList();

	/**
	 * @abstract
	 * @return array|AccessoryDto[] all accessories
	 */
	public function GetAccessoryList();
}
?>