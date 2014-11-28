<?php

class RequiresApprovalRule implements IReservationValidationRule
{
	/**
	 * @var IAuthorizationService
	 */
	private $authorizationService;

	public function __construct(IAuthorizationService $authorizationService)
	{
		$this->authorizationService = $authorizationService;
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	function Validate($reservationSeries)
	{
		$status = ReservationStatus::Created;

		/** @var BookableResource $resource */
		foreach ($reservationSeries->AllResources() as $resource)
		{
			if ($resource->GetRequiresApproval())
			{
				if (!$this->authorizationService->CanApproveForResource($reservationSeries->BookedBy(), $resource))
				{
					$status = ReservationStatus::Pending;
					break;
				}
			}
		}

		$reservationSeries->SetStatusId($status);

		return new ReservationRuleResult();
	}
}

?>