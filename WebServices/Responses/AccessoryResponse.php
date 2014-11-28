<?php

class AccessoryResponse extends RestResponse
{
	public function __construct(IRestServer $server, Accessory $accessory)
	{
		$this->id = $accessory->GetId();
		$this->name = $accessory->GetName();
		$this->quantityAvailable = $accessory->GetQuantityAvailable();
	}

	public static function Example()
	{
		return new ExampleAccessoryResponse(null, new Accessory(1, 'accessoryName', 10));
	}
}

class ExampleAccessoryResponse extends AccessoryResponse
{
	public function __construct()
	{
		$this->id = 1;
		$this->name = 'accessoryName';
		$this->quantityAvailable = 10;
	}
}

?>