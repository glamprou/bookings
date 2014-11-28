<?php

require_once(ROOT_DIR . 'Domain/BookableResource.php');
require_once(ROOT_DIR . 'Domain/Access/IResourceRepository.php');

class ResourceRepository implements IResourceRepository
{
	/**
	 * @var DomainCache
	 */
	private $_cache;
	
	public function __construct() 
	{
		$this->_cache = new DomainCache();
	}

	/**
	 * @param int $scheduleId
	 * @return array|BookableResource[]
	 */
	public function GetScheduleResources($scheduleId)
	{
		$command = new GetScheduleResourcesCommand($scheduleId);
		
		$resources = array();
		
		$reader = ServiceLocator::GetDatabase()->Query($command);
		
		while ($row = $reader->GetRow())
		{
			$resources[] = BookableResource::Create($row);
		}
		
		$reader->Free();
		
		return $resources;
	}
	
	public function GetResourceList()
	{
		$resources = array();
		$reader = ServiceLocator::GetDatabase()->Query(new GetAllResourcesCommand());

		while ($row = $reader->GetRow())
		{
			$resources[] = BookableResource::Create($row);
		}
		
		$reader->Free();

		return $resources;
	}
	
    /**
     * @param int $resourceId
     * @return BookableResource
     */
	public function LoadById($resourceId)
	{
		if (!$this->_cache->Exists($resourceId))
		{
			$resource = $this->LoadResource(new GetResourceByIdCommand($resourceId));
			
			$this->_cache->Add($resourceId, $resource);
		}
		
		return $this->_cache->Get($resourceId);
	}

	public function LoadByContactInfo($contact_info) {
		return $this->LoadResource(new GetResourceByContactInfoCommand($contact_info));
	}

    /**
     * @param string $publicId
     * @return BookableResource
     */
    public function LoadByPublicId($publicId)
    {
		return $this->LoadResource(new GetResourceByPublicIdCommand($publicId));
    }

	/**
	 * @param $command SqlCommand
	 * @return BookableResource
	 */
	private function LoadResource($command)
	{
		$reader = ServiceLocator::GetDatabase()->Query($command);

		$resource = BookableResource::Null();
		if ($row = $reader->GetRow())
		{
			$resource = BookableResource::Create($row);

			$getAttributes = new GetAttributeValuesCommand($resource->GetId(), CustomAttributeCategory::RESOURCE);
			$attributeReader = ServiceLocator::GetDatabase()->Query($getAttributes);

			while ($attributeRow = $attributeReader->GetRow())
			{
				$resource->WithAttribute(new AttributeValue($attributeRow[ColumnNames::ATTRIBUTE_ID], $attributeRow[ColumnNames::ATTRIBUTE_VALUE]));
			}

			$attributeReader->Free();
		}

		$reader->Free();

		return $resource;
	}

	public function Add(BookableResource $resource)
	{
		$db = ServiceLocator::GetDatabase();
		$addResourceCommand = new AddResourceCommand(
            $resource->GetName(),
            $resource->GetScheduleId(),
            $resource->GetAutoAssign(),
            $resource->GetAdminGroupId());
		
		$resourceId = $db->ExecuteInsert($addResourceCommand);
        if ($resource->GetAutoAssign())
        {
            $db->Execute(new AutoAssignResourcePermissionsCommand($resourceId));
        }

		$resource->SetResourceId($resourceId);
        return $resourceId;
	}
	
	public function Update(BookableResource $resource)
	{
		$db = ServiceLocator::GetDatabase();
		
		$updateResourceCommand = new UpdateResourceCommand(
								$resource->GetResourceId(), 
								$resource->GetName(), 
								$resource->GetLocation(), 
								$resource->GetContact(), 
								$resource->GetNotes(), 
								$resource->GetMinLength(), 
								$resource->GetMaxLength(), 
								$resource->GetAutoAssign(), 
								$resource->GetRequiresApproval(), 
								$resource->GetAllowMultiday(),
								$resource->GetMaxParticipants(),
								$resource->GetMinNotice(),
								$resource->GetMaxNotice(),
								$resource->GetDescription(),
								$resource->GetImage(),
								$resource->IsOnline(),
								$resource->GetScheduleId(),
								$resource->GetAdminGroupId(),
                                $resource->GetIsCalendarSubscriptionAllowed(),
                                $resource->GetPublicId(),
								$resource->GetSortOrder()
		);
								
		$db->Execute($updateResourceCommand);


		foreach ($resource->GetRemovedAttributes() as $removed)
		{
			$db->Execute(new RemoveAttributeValueCommand($removed->AttributeId, $resource->GetId()));
		}

		foreach ($resource->GetAddedAttributes() as $added)
		{
			$db->Execute(new AddAttributeValueCommand($added->AttributeId, $added->Value, $resource->GetId(), CustomAttributeCategory::RESOURCE));
		}
	}
	
	public function Delete(BookableResource $resource)
	{
		Log::Debug("Deleting resource %s (%s)", $resource->GetResourceId(), $resource->GetName());
		
		$resourceId = $resource->GetResourceId();
		
		$db = ServiceLocator::GetDatabase();
		$db->Execute(new DeleteResourceReservationsCommand($resourceId));
		$db->Execute(new DeleteResourceCommand($resourceId));
	}

	public function GetAccessoryList()
	{
		$command = new GetAllAccessoriesCommand();
		$accessories = array();

		$reader = ServiceLocator::GetDatabase()->Query($command);

		while ($row = $reader->GetRow())
		{
			$accessories[] = AccessoryDto::Create($row);
		}

		$reader->Free();

		return $accessories;
	}
}

class AccessoryDto
{
	/**
	 * @var int
	 */
	public $Id;

	/**
	 * @var string
	 */
	public $Name;

	/**
	 * @var int
	 */
	public $QuantityAvailable;

	public function __construct($id, $name, $quantityAvailable)
	{
		$this->Id = $id;
		$this->Name = $name;
		$this->QuantityAvailable = $quantityAvailable;
	}

	public static function Create($row)
	{
		return new AccessoryDto($row[ColumnNames::ACCESSORY_ID], $row[ColumnNames::ACCESSORY_NAME], $row[ColumnNames::ACCESSORY_QUANTITY]);
	}
}

?>
