<?php

class GroupItemResponse extends RestResponse
{
	public function __construct(IRestServer $server, $id, $name)
	{
		$this->id = $id;
		$this->name = $name;
		$this->AddService($server, WebServices::GetGroup, array(WebServiceParams::GroupId => $id));
	}

	public static function Example()
	{
		return null;
	}
}

?>