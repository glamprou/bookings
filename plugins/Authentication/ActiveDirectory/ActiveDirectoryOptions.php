<?php

require_once(ROOT_DIR . '/lib/Config/namespace.php');

class ActiveDirectoryOptions
{
	private $_options = array();

	public function __construct()
	{
		require_once(dirname(__FILE__) . '/ActiveDirectory.config.php');

		Configuration::Instance()->Register(
			dirname(__FILE__) . '/ActiveDirectory.config.php',
			ActiveDirectoryConfig::CONFIG_ID);
	}

	public function AdLdapOptions()
	{
		$hosts = $this->GetHosts();
		$this->SetOption('domain_controllers', $hosts);
		$this->SetOption('ad_port', $this->GetConfig(ActiveDirectoryConfig::PORT), new IntConverter());
		$this->SetOption('admin_username', $this->GetConfig(ActiveDirectoryConfig::USERNAME));
		$this->SetOption('admin_password', $this->GetConfig(ActiveDirectoryConfig::PASSWORD));
		$this->SetOption('base_dn', $this->GetConfig(ActiveDirectoryConfig::BASEDN));
		$this->SetOption('use_ssl', $this->GetConfig(ActiveDirectoryConfig::USE_SSL, new BooleanConverter()));
		$this->SetOption('account_suffix', $this->GetConfig(ActiveDirectoryConfig::ACCOUNT_SUFFIX));
		$this->SetOption('ldap_version', $this->GetConfig(ActiveDirectoryConfig::VERSION), new IntConverter());

		return $this->_options;
	}

	public function RetryAgainstDatabase()
	{
		return $this->GetConfig(ActiveDirectoryConfig::RETRY_AGAINST_DATABASE, new BooleanConverter());
	}

	public function Controllers()
	{
		return $this->GetHosts();
	}

	private function SetOption($key, $value)
	{
		if (empty($value))
		{
			$value = null;
		}

		$this->_options[$key] = $value;
	}

	private function GetConfig($keyName, $converter = null)
	{
		return Configuration::Instance()->File(ActiveDirectoryConfig::CONFIG_ID)->GetKey($keyName, $converter);
	}

	private function GetHosts()
	{
		$hosts = explode(',', $this->GetConfig(ActiveDirectoryConfig::DOMAIN_CONTROLLERS));

		for ($i = 0; $i < count($hosts); $i++)
		{
			$hosts[$i] = trim($hosts[$i]);
		}

		return $hosts;
	}

	public function Attributes()
	{
		$attributes = $this->AttributeMapping();
		return array_values($attributes);
	}

	public function AttributeMapping()
	{
		$attributes = array('sn' => 'sn',
							'givenname' => 'givenname',
							'mail' => 'mail',
							'telephonenumber' => 'telephonenumber',
							'physicaldeliveryofficename' => 'physicaldeliveryofficename',
							'title' => 'title');
		$configValue = $this->GetConfig(ActiveDirectoryConfig::ATTRIBUTE_MAPPING);

		if (!empty($configValue))
		{
			$attributePairs = explode(',', $configValue);
			foreach ($attributePairs as $attributePair)
			{
				$pair = explode('=', trim($attributePair));
				$attributes[trim($pair[0])] = trim($pair[1]);
			}
		}

		return $attributes;
	}
}

?>