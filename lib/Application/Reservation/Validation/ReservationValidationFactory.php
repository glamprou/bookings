<?php

class ReservationValidationFactory implements IReservationValidationFactory
{
    /**
     * @var array|string[]
     */
    private $creationStrategies = array();

    public function __construct()
    {
        //$this->creationStrategies[ReservationAction::Approve] = 'CreateUpdateService';
        $this->creationStrategies[ReservationAction::Create] = 'CreateAddService';
        $this->creationStrategies[ReservationAction::Delete] = 'CreateDeleteService';
        $this->creationStrategies[ReservationAction::Update] = 'CreateUpdateService';
    }

    public function Create($reservationAction, $userSession)
    {
        if (array_key_exists($reservationAction, $this->creationStrategies))
        {
            $createMethod = $this->creationStrategies[$reservationAction];
            return $this->$createMethod($userSession);
        }

        return new NullReservationValidationService();
    }

    private function CreateAddService(UserSession $userSession)
    {
        $factory = PluginManager::Instance()->LoadPreReservation();
        return $factory->CreatePreAddService($userSession);
    }

    private function CreateUpdateService(UserSession $userSession)
    {
        $factory = PluginManager::Instance()->LoadPreReservation();
        return $factory->CreatePreUpdateService($userSession);
    }

    private function CreateDeleteService(UserSession $userSession)
    {
        $factory = PluginManager::Instance()->LoadPreReservation();
        return $factory->CreatePreDeleteService($userSession);
    }
}

class NullReservationValidationService implements IReservationValidationService
{
    /**
     * @param ReservationSeries $reservation
     * @return IReservationValidationResult
     */
    function Validate($reservation)
    {
        return new ReservationValidationResult();
    }
}

?>