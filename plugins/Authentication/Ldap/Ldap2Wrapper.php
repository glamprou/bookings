<?php

require_once(ROOT_DIR . 'plugins/Authentication/Ldap/LDAP2.php');

class Ldap2Wrapper
{
	/**
	 * @var LdapOptions
	 */
	private $options;

	/**
	 * @var Net_LDAP2|null
	 */
	private $ldap;

	/**
	 * @var LdapUser|null
	 */
	private $user;

	/**
	 * @param LdapOptions $ldapOptions
	 */
	public function __construct($ldapOptions)
	{
		$this->options = $ldapOptions;
		$this->user = null;
	}

	public function Connect()
	{
		Log::Debug('Trying to connect to LDAP');

		$this->ldap = Net_LDAP2::connect($this->options->Ldap2Config());
		if (PEAR::isError($this->ldap))
		{
			$message = 'Could not connect to LDAP server. Check your settings in Ldap.config.php : ' . $this->ldap->getMessage();
			Log::Error($message);
			throw new Exception($message);
		}

		return true;
	}

	/**
	 * @param $username string
	 * @param $password string
	 * @return bool
	 */
	public function Authenticate($username, $password)
	{
		$this->PopulateUser($username);

		if ($this->user == null)
		{
			return false;
		}

		Log::Debug('Trying to authenticate user %s against ldap with dn %s', $username, $this->user->GetDn());

		$result = $this->ldap->bind($this->user->GetDn(), $password);
		if ($result === true)
		{
			Log::Debug('Authentication was successful');

			return true;
		}

		if (Net_LDAP2::isError($result))
		{
			$message = 'Could not authenticate user against ldap %s: ' . $result->getMessage();
			Log::Error($message, $username);
		}
		return false;
	}

	/**
	 * @param $username string
	 * @return void
	 */
	private function PopulateUser($username)
	{
		$uidAttribute = $this->options->GetUserIdAttribute();
		Log::Debug('LDAP - uid attribute: %s', $uidAttribute);
		$filter = Net_LDAP2_Filter::create($uidAttribute, 'equals', $username);

		$attributes = $this->options->Attributes();
		Log::Debug('LDAP - Loading user attributes: %s', implode(', ', $attributes));

		$options = array('attributes' => $attributes);

		Log::Debug('Searching ldap for user %s', $username);
		$searchResult = $this->ldap->search(null, $filter, $options);

		if (Net_LDAP2::isError($searchResult))
		{
			$message = 'Could not search ldap for user %s: ' . $searchResult->getMessage();
			Log::Error($message, $username);
		}

		$currentResult = $searchResult->current();
		if ($searchResult->count() == 1 && $currentResult !== false)
		{
			Log::Debug('Found user %s', $username);
			/** @var Net_LDAP2_Entry $entry  */
			$this->user = new LdapUser($currentResult, $this->options->AttributeMapping());
		}
		else
		{
			Log::Debug('Could not find user %s', $username);
		}
	}

	/**
	 * @param $username string
	 * @return LdapUser|null
	 */
	public function GetLdapUser($username)
	{
		return $this->user;
	}
}

?>