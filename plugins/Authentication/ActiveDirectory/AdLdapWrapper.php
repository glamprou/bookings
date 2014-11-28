<?php

require_once(ROOT_DIR . 'plugins/Authentication/ActiveDirectory/adLDAP.php');

class AdLdapWrapper implements IActiveDirectory
{
	/**
	 * @var ActiveDirectoryOptions
	 */
	private $options;

	/**
	 * @var adLdap|null
	 */
	private $ldap;

	/**
	 * @param ActiveDirectoryOptions $ldapOptions
	 */
	public function __construct($ldapOptions)
	{
		$this->options = $ldapOptions;
	}

	public function Connect()
	{
		$connected = false;
		$attempts = 0;
		$hosts = $this->options->Controllers();
		$options = $this->options->AdLdapOptions();

		while (!$connected && $attempts < count($hosts))
		{
			try
			{
				$host = $hosts[$attempts];
				Log::Debug('ActiveDirectory - Trying to connect to host %s', $host);
				$options['domain_controllers'] = array($host);
				$attempts++;
				$this->ldap = new adLdap($options);
				$connected = true;

				if ($connected)
				{
					Log::Debug('ActiveDirectory - Connection succeeded to host %s', $host);
				}
				else
				{
					Log::Debug('ActiveDirectory - Connection failed to host %s. Reason %s', $host,
							   $this->ldap->getLastError());
				}
			} catch (adLDAPException $ex)
			{
				Log::Error($ex);
				throw($ex);
			}
		}

		return $connected;
	}

	public function Authenticate($username, $password)
	{
		$authenticated = $this->ldap->user()->authenticate($username, $password);
		if (!$authenticated)
		{
			Log::Debug('ActiveDirectory - Authenticate for user %s failed with reason %s', $username,
					   $this->ldap->getLastError());
		}
		return $authenticated;
	}

	public function GetLdapUser($username)
	{
		$attributes = $this->options->Attributes();
		Log::Debug('ActiveDirectory - Loading user attributes: %s', implode(', ', $attributes));
		$entries = $this->ldap->user()->infoCollection($username, $attributes);

		/** @var adLDAPUserCollection $entries */
		try
		{
			Log::Debug('ActiveDirectory - Got entries: %s', var_export($entries, true));
		}
		catch (Exception $ex)
		{
			// ignore this since we're only logging
		}
		if ($entries && count($entries) > 0)
		{
			return new ActiveDirectoryUser($entries, $this->options->AttributeMapping());
		}
		else
		{
			Log::Debug('ActiveDirectory - Could not load user details for user %s. Reason %s', $username,
					   $this->ldap->getLastError());
		}

		return null;
	}
}

?>