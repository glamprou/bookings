<?php

require_once(ROOT_DIR . 'Domain/Access/ResourceRepository.php');

class ResourceAdminResourceRepository extends ResourceRepository
{
    /**
     * @var IUserRepository
     */
    private $repo;

    /**
     * @var UserSession
     */
    private $user;

    public function __construct(IUserRepository $repo, UserSession $userSession)
    {
        $this->repo = $repo;
        $this->user = $userSession;
		parent::__construct();
    }

    /**
     * @return array|BookableResource[] array of all resources
     */
    public function GetResourceList()
    {
		$resources = parent::GetResourceList();

		return $this->GetFilteredResources($resources);

    }

    /**
     * @param BookableResource $resource
     */
    public function Update(BookableResource $resource)
    {
		if (!$this->user->IsAdmin)
		{
			$user = $this->repo->LoadById($this->user->UserId);
			if (!$user->IsResourceAdminFor($resource))
			{
				// if we got to this point, the user does not have the ability to update the resource
				throw new Exception(sprintf('Resource Update Failed. User %s does not have admin access to resource %s.', $this->user->UserId, $resource->GetId()));
			}
		}

        parent::Update($resource);
    }

	/**
	 * @param int $scheduleId
	 * @return array|BookableResource[]
	 */
	public function GetScheduleResources($scheduleId)
	{
		$resources =  parent::GetScheduleResources($scheduleId);
		return $this->GetFilteredResources($resources);
	}

	/**
	 * @param $resources
	 * @return array|BookableResource[]
	 */
	private function GetFilteredResources($resources)
	{
		if ($this->user->IsAdmin)
		{
			return $resources;
		}

		$user = $this->repo->LoadById($this->user->UserId);

		$filteredResources = array();
		/** @var $resource BookableResource */
		foreach ($resources as $resource)
		{
			if ($user->IsResourceAdminFor($resource))
			{
				$filteredResources[] = $resource;
			}
		}

		return $filteredResources;
	}


}

?>