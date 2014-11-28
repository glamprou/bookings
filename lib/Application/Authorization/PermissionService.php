<?php

interface IPermissionService
{
	/**
	 * @param IPermissibleResource $resource
	 * @param UserSession $user
	 * @return bool
	 */
	public function CanAccessResource(IPermissibleResource $resource, UserSession $user);
}

class PermissionService implements IPermissionService
{
	/**
	 * @var IResourcePermissionStore
	 */
	private $_store;
	
	private $_allowedResourceIds;
	
	/**
	 * @param IResourcePermissionStore $store
	 */
	public function __construct(IResourcePermissionStore $store)
	{
		$this->_store = $store;
	}

	/**
	 * @param IPermissibleResource $resource
	 * @param UserSession $user
	 * @return bool
	 */
	public function CanAccessResource(IPermissibleResource $resource, UserSession $user)
	{
		if ($this->_allowedResourceIds == null)
		{
			$this->_allowedResourceIds = $this->_store->GetPermittedResources($user->UserId);
		}
		
		return $user->IsAdmin || in_array($resource->GetResourceId(), $this->_allowedResourceIds);
	}
}

?>