<?php

require_once(ROOT_DIR . 'lib/WebService/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');
require_once(ROOT_DIR . 'WebServices/Responses/ResourceResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/ResourcesResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/CustomAttributeResponse.php');

class ResourcesWebService
{
	/**
	 * @var IRestServer
	 */
	private $server;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @var IAttributeService
	 */
	private $attributeService;

	public function __construct(IRestServer $server, IResourceRepository $resourceRepository,
								IAttributeService $attributeService)
	{
		$this->server = $server;
		$this->resourceRepository = $resourceRepository;
		$this->attributeService = $attributeService;
	}

	/**
	 * @name GetAllResources
	 * @description Loads all resources
	 * @response ResourcesResponse
	 * @return void
	 */
	public function GetAll()
	{
		$resources = $this->resourceRepository->GetResourceList();
		$resourceIds = array();
		foreach ($resources as $resource)
		{
			$resourceIds[] = $resource->GetId();
		}
		$attributes = $this->attributeService->GetAttributes(CustomAttributeCategory::RESOURCE, $resourceIds);
		$this->server->WriteResponse(new ResourcesResponse($this->server, $resources, $attributes));
	}

	/**
	 * @name GetResource
	 * @description Loads a specific resource by id
	 * @param int $resourceId
	 * @response ResourceResponse
	 * @return void
	 */
	public function GetResource($resourceId)
	{
		$resource = $this->resourceRepository->LoadById($resourceId);

		$resourceId = $resource->GetResourceId();
		if (empty($resourceId))
		{
			$this->server->WriteResponse(RestResponse::NotFound(), RestResponse::NOT_FOUND_CODE);
		}
		else
		{
			$attributes = $this->attributeService->GetAttributes(CustomAttributeCategory::RESOURCE, array($resourceId));
			$this->server->WriteResponse(new ResourceResponse($this->server, $resource, $attributes));
		}

	}
}

?>