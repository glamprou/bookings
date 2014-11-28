<?php

class ResourceService implements IResourceService
{
	/**
	 * @var \IResourceRepository
	 */
	private $_resourceRepository;

	/**
	 * @var \IPermissionService
	 */
	private $_permissionService;

	public function __construct(IResourceRepository $resourceRepository, IPermissionService $permissionService)
	{
		$this->_resourceRepository = $resourceRepository;
		$this->_permissionService = $permissionService;
	}

	/**
	 * @param $scheduleId int
	 * @param $includeInaccessibleResources bool
	 * @param UserSession $user
	 * @return array|ResourceDto[]
	 */
	public function GetScheduleResources($scheduleId, $includeInaccessibleResources, UserSession $user)
	{
		$resources = $this->_resourceRepository->GetScheduleResources($scheduleId);

		return $this->Filter($resources, $user, $includeInaccessibleResources);
	}

	/**
	 * @param $includeInaccessibleResources
	 * @param UserSession $user
	 * @return array|ResourceDto[]
	 */
	public function GetAllResources($includeInaccessibleResources, UserSession $user)
	{
		$resources = $this->_resourceRepository->GetResourceList();

		return $this->Filter($resources, $user, $includeInaccessibleResources);
	}

	/**
	 * @param $resources array|BookableResource[]
	 * @param $user UserSession
	 * @param $includeInaccessibleResources bool
	 * @return array|ResourceDto[]
	 */
	private function Filter($resources, $user, $includeInaccessibleResources)
	{
		$resourceDtos = array();
		foreach ($resources as $resource)
		{
			$canAccess = $this->_permissionService->CanAccessResource($resource, $user);

			if (!$includeInaccessibleResources && !$canAccess)
			{
				continue;
			}

			$resourceDtos[] = new ResourceDto($resource->GetResourceId(), $resource->GetName(), $canAccess, $resource->GetScheduleId());
		}
		return $resourceDtos;
	}

	/**
	 * @return array|AccessoryDto[]
	 */
	public function GetAccessories()
	{
		return $this->_resourceRepository->GetAccessoryList();
	}
}

interface IResourceService
{
	/**
	 * Gets resource list for a schedule
	 * @param int $scheduleId
	 * @param bool $includeInaccessibleResources
	 * @param UserSession $user
	 * @return array|ResourceDto[]
	 */
	public function GetScheduleResources($scheduleId, $includeInaccessibleResources, UserSession $user);

	/**
	 * Gets resource list
	 * @param bool $includeInaccessibleResources
	 * @param UserSession $user
	 * @return array|ResourceDto[]
	 */
	public function GetAllResources($includeInaccessibleResources, UserSession $user);

	/**
	 * @abstract
	 * @return array|AccessoryDto[]
	 */
	public function GetAccessories();
}

class ResourceDto
{
	public function __construct($id, $name, $canAccess = true, $scheduleId = null)
	{
		$this->Id = $id;
		$this->Name = $name;
		$this->CanAccess = $canAccess;
		$this->ScheduleId = $scheduleId;
	}
	
	/**
	 * @var int
	 */
	public $Id;
	
	/**
	 * @var string
	 */
	public $Name;
	
	/**
	 * @var bool
	 */
	public $CanAccess;

	/**
	 * @var int
	 */
	public $ScheduleId;

	/**
	 * alias of GetId()
	 * @return int
	 */
	public function GetResourceId()
	{
		return $this->Id;
	}

	/**
	 * @return int
	 */
	public function GetId()
	{
		return $this->Id;
	}

	/**
	 * @return string
	 */
	public function GetName()
	{
		return $this->Name;
	}

	/**
	 * @return int|null
	 */
	public function GetScheduleId()
	{
		return $this->ScheduleId;
	}
}
?>