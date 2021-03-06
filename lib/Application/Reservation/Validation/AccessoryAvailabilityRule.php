<?php

require_once(ROOT_DIR . 'Domain/Access/AccessoryRepository.php');
require_once(ROOT_DIR . 'Domain/Access/ReservationRepository.php');

class AccessoryAvailabilityRule implements IReservationValidationRule
{
	/**
	 * @var IReservationViewRepository
	 */
	protected $reservationRepository;

	/**
	 * @var IAccessoryRepository
	 */
	protected $accessoryRepository;

	/**
	 * @var string
	 */
	protected $timezone;
	
	public function __construct(IReservationViewRepository $reservationRepository, IAccessoryRepository $accessoryRepository, $timezone)
	{
		$this->reservationRepository = $reservationRepository;
		$this->accessoryRepository = $accessoryRepository;
		$this->timezone = $timezone;
	}
	
	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
		$conflicts = array();
		$reservationAccessories = $reservationSeries->Accessories();

		if (count($reservationAccessories) == 0)
		{
			// no accessories to be reserved, no need to proceed
			return new ReservationRuleResult();
		}

		/** @var AccessoryToCheck[] $accessories  */
		$accessories = array();
		foreach ($reservationAccessories as $accessory)
		{
			$a = $this->accessoryRepository->LoadById($accessory->AccessoryId);
			if (!$a->HasUnlimitedQuantity())
			{
				$accessories[$a->GetId()] = new AccessoryToCheck($a, $accessory);
			}
		}

		if (count($accessories) == 0)
		{
			// no accessories with limited quantity to be reserved, no need to proceed
			return new ReservationRuleResult();
		}

		$reservations = $reservationSeries->Instances();
		/** @var Reservation $reservation */
		foreach ($reservations as $reservation)
		{
			Log::Debug("Checking for accessory conflicts, reference number %s", $reservation->ReferenceNumber());
			
			$accessoryReservations = $this->reservationRepository->GetAccessoriesWithin($reservation->Duration());

			$aggregation = new AccessoryAggregation($accessories, $reservation->Duration());

			foreach ($accessoryReservations as $accessoryReservation)
			{
				if ($reservation->ReferenceNumber() != $accessoryReservation->GetReferenceNumber())
				{
					$aggregation->Add($accessoryReservation);
				}
			}

			foreach ($accessories as $accessory)
			{
				$alreadyReserved = $aggregation->GetQuantity($accessory->GetId());
				$requested = $accessory->QuantityReserved();

				if ($requested + $alreadyReserved > $accessory->QuantityAvailable())
				{
					Log::Debug("Accessory over limit. Reference Number %s, Date %s, Quantity already reserved %s, Quantity requested: %s",
							   $reservation->ReferenceNumber(),
							   $reservation->Duration(),
								$alreadyReserved,
								$requested);

					array_push($conflicts, array('name' => $accessory->GetName(), 'date' => $reservation->StartDate()));
				}
			}
		}
		
		$thereAreConflicts = count($conflicts) > 0;		
		
		if ($thereAreConflicts)
		{
			return new ReservationRuleResult(false, $this->GetErrorString($conflicts));
		}
		
		return new ReservationRuleResult();
	}

	/**
	 * @param array $conflicts
	 * @return string
	 */
	protected function GetErrorString($conflicts)
	{
		$errorString = new StringBuilder();

		$errorString->Append(Resources::GetInstance()->GetString('ConflictingAccessoryDates'));
		$errorString->AppendLine();
		$format = Resources::GetInstance()->GetDateFormat(ResourceKeys::DATE_GENERAL);
		
		foreach($conflicts as $conflict)
		{
			$errorString->Append(sprintf('(%s) %s', $conflict['date']->ToTimezone($this->timezone)->Format($format), $conflict['name']));
			$errorString->AppendLine();
		}
		
		return $errorString->ToString();
	}
}

class AccessoryAggregation
{
	private $quantities = array();

	/**
	 * @var \DateRange
	 */
	private $duration;

	/**
	 * @param array|AccessoryToCheck[] $accessories
	 * @param DateRange $duration
	 */
	public function __construct($accessories, $duration)
	{
		foreach ($accessories as $a)
		{
			$this->quantities[$a->GetId()] = 0;
		}

		$this->duration = $duration;

	}
	/**
	 * @param AccessoryReservation $accessoryReservation
	 * @return void
	 */
	public function Add(AccessoryReservation $accessoryReservation)
	{
		if ($accessoryReservation->GetStartDate()->Equals($this->duration->GetEnd()) || $accessoryReservation->GetEndDate()->Equals($this->duration->GetBegin()))
		{
			return;
		}

		$accessoryId = $accessoryReservation->GetAccessoryId();
		if (array_key_exists($accessoryId, $this->quantities))
		{
			$this->quantities[$accessoryId] += $accessoryReservation->QuantityReserved();
		}
	}

	/**
	 * @param int $accessoryId
	 * @return int
	 */
	public function GetQuantity($accessoryId)
	{
		return $this->quantities[$accessoryId];
	}

}
class AccessoryToCheck
{
	/**
	 * @var \Accessory
	 */
	private $accessory;

	/**
	 * @var \ReservationAccessory
	 */
	private $reservationAccessory;

	/**
	 * @var int
	 */
	private $quantityReserved;
	
	public function __construct(Accessory $accessory, ReservationAccessory $reservationAccessory)
	{
		$this->accessory = $accessory;
		$this->reservationAccessory = $reservationAccessory;
		$this->quantityReserved = $this->reservationAccessory->QuantityReserved;
	}

	/**
	 * @return int
	 */
	public function GetId()
	{
		return $this->accessory->GetId();
	}

	/**
	 * @return string
	 */
	public function GetName()
	{
		return $this->accessory->GetName();
	}

	/**
	 * @return int
	 */
	public function QuantityReserved()
	{
		return $this->quantityReserved;
	}

	/**
	 * @return int
	 */
	public function QuantityAvailable()
	{
		return $this->accessory->GetQuantityAvailable();
	}
}
?>