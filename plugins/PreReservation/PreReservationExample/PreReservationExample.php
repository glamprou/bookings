<?php

require_once(dirname(__FILE__) . '/PreReservationExampleValidation.php');

class PreReservationExample implements IPreReservationFactory
{
	/**
     * @var PreReservationFactory
     */
    private $factoryToDecorate;

    public function __construct(PreReservationFactory $factoryToDecorate)
    {
        $this->factoryToDecorate = $factoryToDecorate;

		require_once(dirname(__FILE__) . '/PreReservationExample.config.php');

		Configuration::Instance()->Register(
					dirname(__FILE__) . '/PreReservationExample.config.php',
					'PreReservationExample');
    }

    public function CreatePreAddService(UserSession $userSession)
    {
        $base = $this->factoryToDecorate->CreatePreAddService($userSession);
        return new PreReservationExampleValidation($base);
    }

    public function CreatePreUpdateService(UserSession $userSession)
    {
        $base =  $this->factoryToDecorate->CreatePreUpdateService($userSession);
        return new PreReservationExampleValidation($base);
    }

    public function CreatePreDeleteService(UserSession $userSession)
    {
        return $this->factoryToDecorate->CreatePreDeleteService($userSession);
    }

}

?>