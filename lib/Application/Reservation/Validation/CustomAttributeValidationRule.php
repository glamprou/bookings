<?php

class CustomAttributeValidationRule implements IReservationValidationRule
{
	public function __construct(IAttributeRepository $attributeRepository)
	{
		$this->attributeRepository = $attributeRepository;
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
		$resources = Resources::GetInstance();
		$errorMessage = new StringBuilder();
		$isValid = true;

		$attributes = $this->attributeRepository->GetByCategory(CustomAttributeCategory::RESERVATION);
		foreach ($attributes as $attribute)
		{
			$value = $reservationSeries->GetAttributeValue($attribute->Id());
			$label = $attribute->Label();

			if (!$attribute->SatisfiesRequired($value))
			{
				$isValid = false;
				$errorMessage->AppendLine($resources->GetString('CustomAttributeRequired', $label));
			}

			if (!$attribute->SatisfiesConstraint($value))
			{
				$isValid = false;
				$errorMessage->AppendLine($resources->GetString('CustomAttributeInvalid', $label));
			}
		}

		if (!$isValid)
		{
			$errorMessage->PrependLine($resources->GetString('CustomAttributeErrors'));
		}

		return new ReservationRuleResult($isValid, $errorMessage->ToString());
	}
}

?>