<?php

class PreReservationExampleValidation implements IReservationValidationService
{
	/**
	 * @var IReservationValidationService
	 */
	private $serviceToDecorate;

	public function __construct(IReservationValidationService $serviceToDecorate)
	{
		$this->serviceToDecorate = $serviceToDecorate;
	}

	/**
	 * @param ReservationSeries|ExistingReservationSeries $series
	 * @return IReservationValidationResult
	 */
	public function Validate($series)
	{
		$result = $this->serviceToDecorate->Validate($series);

		// don't bother validating this rule if others have failed
		if (!$result->CanBeSaved())
		{
			return $result;
		}

		return $this->EvaluateCustomRule($series);
	}

	/**
	 * @param ReservationSeries $series
	 * @return bool
	 */
	private function EvaluateCustomRule($series)
	{
		Log::Debug('Evaluating custom pre reservation rule');
		// make your custom checks here
		$configFile = Configuration::Instance()->File('PreReservationExample');
		$maxValue = $configFile->GetKey('custom.attribute.max.value');
		$customAttributeId = $configFile->GetKey('custom.attribute.id');

		$attributeValue = $series->GetAttributeValue($customAttributeId);

		$isValid = $attributeValue <= $maxValue;

		if ($isValid)
		{
			return new ReservationValidationResult();
		}

		return new ReservationValidationResult(false, "Value of custom attribute cannot be greater than $maxValue");
	}
}

?>