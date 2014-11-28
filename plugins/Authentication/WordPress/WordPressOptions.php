<?php

require_once(ROOT_DIR . '/lib/Config/namespace.php');

class WordPressOptions
{
	const CONFIG_ID = 'wordPress';
	public function __construct()
	{
		require_once(dirname(__FILE__) . '/WordPress.config.php');

		Configuration::Instance()->Register(
			dirname(__FILE__) . '/WordPress.config.php',
			self::CONFIG_ID);
	}

	public function RetryAgainstDatabase()
	{
		return $this->GetConfig('database.auth.when.wp.user.not.found', new BooleanConverter());
	}

	public function GetPath()
	{
		$path = $this->GetConfig('wp_includes.directory');

		if (!StringHelper::StartsWith($path, '/'))
		{
			$path = ROOT_DIR . "/$path";
		}
		if (StringHelper::EndsWith($path, '/'))
		{
			return $path;
		}

		return $path . '/';
	}

	private function GetConfig($keyName, $converter = null)
	{
		return Configuration::Instance()->File(self::CONFIG_ID)->GetKey($keyName, $converter);
	}
}

?>