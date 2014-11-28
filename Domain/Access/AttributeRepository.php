<?php

require_once(ROOT_DIR . 'Domain/CustomAttribute.php');

interface IAttributeRepository
{
	/**
	 * @abstract
	 * @param CustomAttribute $attribute
	 * @return int
	 */
	public function Add(CustomAttribute $attribute);

	/**
	 * @abstract
	 * @param $attributeId int
	 * @return CustomAttribute
	 */
	public function LoadById($attributeId);

	/**
	 * @abstract
	 * @param CustomAttribute $attribute
	 */
	public function Update(CustomAttribute $attribute);

	/**
	 * @abstract
	 * @param $attributeId int
	 * @return void
	 */
	public function DeleteById($attributeId);

	/**
	 * @abstract
	 * @param int|CustomAttributeCategory $category
	 * @return array|CustomAttribute[]
	 */
	public function GetByCategory($category);

	/**
	 * @abstract
	 * @param int|CustomAttributeCategory $category
	 * @param array|int[] $entityIds
	 * @return array|AttributeEntityValue[]
	 */
	public function GetEntityValues($category, $entityIds);

}

class AttributeRepository implements IAttributeRepository
{
	public function Add(CustomAttribute $attribute)
	{
		return ServiceLocator::GetDatabase()->ExecuteInsert(
			new AddAttributeCommand($attribute->Label(), $attribute->Type(), $attribute->Category(), $attribute->Regex(), $attribute->Required(), $attribute->PossibleValues(), $attribute->SortOrder()));
	}

	/**
	 * @param int|CustomAttributeCategory $category
	 * @return array|CustomAttribute[]
	 */
	public function GetByCategory($category)
	{
		$reader = ServiceLocator::GetDatabase()->Query(new GetAttributesByCategoryCommand($category));

		$attributes = array();
		while ($row = $reader->GetRow())
		{
			$attributes[] = CustomAttribute::FromRow($row);
		}

		return $attributes;
	}

	/**
	 * @param $attributeId int
	 * @return CustomAttribute
	 */
	public function LoadById($attributeId)
	{
		$reader = ServiceLocator::GetDatabase()->Query(new GetAttributeByIdCommand($attributeId));

		$attribute = null;
		if ($row = $reader->GetRow())
		{
			$attribute = CustomAttribute::FromRow($row);
		}

		return $attribute;
	}

	/**
	 * @param CustomAttribute $attribute
	 */
	public function Update(CustomAttribute $attribute)
	{
		ServiceLocator::GetDatabase()->Execute(
			new UpdateAttributeCommand($attribute->Id(), $attribute->Label(), $attribute->Type(), $attribute->Category(),
				$attribute->Regex(), $attribute->Required(), $attribute->PossibleValues(), $attribute->SortOrder()));
	}

	/**
	 * @param int|CustomAttributeCategory $category
	 * @param array|int[] $entityIds
	 * @return array|AttributeEntityValue[]
	 */
	public function GetEntityValues($category, $entityIds)
	{
		$values = array();

		if (!is_array($entityIds) && !empty($entityIds))
		{
			$entityIds = array($entityIds);
		}

		$reader = ServiceLocator::GetDatabase()->Query(new GetAttributeMultipleValuesCommand($category, $entityIds));

		$attribute = null;
		while ($row = $reader->GetRow())
		{
			$values[] = new AttributeEntityValue(
				$row[ColumnNames::ATTRIBUTE_ID],
				$row[ColumnNames::ATTRIBUTE_ENTITY_ID],
				$row[ColumnNames::ATTRIBUTE_VALUE]);
		}

		return $values;
	}

	/**
	 * @param $attributeId int
	 * @return void
	 */
	public function DeleteById($attributeId)
	{
		ServiceLocator::GetDatabase()->Execute(new DeleteAttributeCommand($attributeId));
		ServiceLocator::GetDatabase()->Execute(new DeleteAttributeValuesCommand($attributeId));
	}
}

?>