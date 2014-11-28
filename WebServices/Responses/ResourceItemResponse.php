<?php

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class ResourceItemResponse extends RestResponse
{
	public $id;
	public $name;

	public function __construct(IRestServer $server, $id, $name)
	{
		$this->id = $id;
		$this->name = $name;
		$this->AddService($server, WebServices::GetResource, array(WebServiceParams::ResourceId => $id));
	}

	public static function Example()
	{
		return new ExampleResourceItemResponse();
	}
}

class ExampleResourceItemResponse extends ResourceItemResponse
{
	public function __construct()
	{
		$this->id = 123;
		$this->name = 'resource name';
	}
}
?>