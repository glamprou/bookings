<?php

require_once(ROOT_DIR . 'lib/external/pear/Config.php');

interface IConfiguration extends IConfigurationFile
{
	/**
	 * @param string $configFile
	 * @param string $configId
	 * @param bool $overwrite
	 */
	public function Register($configFile, $configId, $overwrite = false);

	/**
    * @param string $configId
    * @return Configuration
    */
	public function File($configId);
}

interface IConfigurationFile
{
	/**
	 * @abstract
	 * @param string $section
	 * @param string $name
	 * @param null|IConvert $converter
	 * @return mixed|string
	 */
	public function GetSectionKey($section, $name, $converter = null);

	/**
	 * @abstract
	 * @param string $name
	 * @param null|IConvert $converter
	 * @return mixed|string
	 */
	public function GetKey($name, $converter = null);

    /**
     * @abstract
     * @return string the full url to the root of this phpScheduleIt instance WITHOUT the trailing /
     */
	public function GetScriptUrl();
}

class Configuration implements IConfiguration
{
    /**
     * @var array|Configuration[]
     */
	protected $_configs = array();

    /**
     * @var Configuration
     */
	private static $_instance = null;
	
	const SETTINGS = 'settings';
	const DEFAULT_CONFIG_ID = 'phpscheduleit';
	const DEFAULT_CONFIG_FILE_PATH = 'config/config.php';

    const VERSION = '2.4.2';

	protected function __construct()
	{
	}
	
	/**
	 * @return IConfigurationFile
	 */
	public static function Instance()
	{
		if (self::$_instance == null)
		{
			self::$_instance = new Configuration();
			self::$_instance->Register(
					dirname(__FILE__) . '/../../' . self::DEFAULT_CONFIG_FILE_PATH, 
					self::DEFAULT_CONFIG_ID);
		}
		
		return self::$_instance;
	}
	
	public static function SetInstance($value)
	{
		self::$_instance = $value;
	}
	
	public function Register($configFile, $configId, $overwrite = false)
	{
		if (!file_exists($configFile))
        {
			echo "Missing config file: $configFile. If there is a .dist config file in this location, please copy it as $configFile";
            throw new Exception("Missing config file: $configFile");
        }

		$config = new Config();
		$container = $config->parseConfig($configFile, 'PHPArray');
		
		if (PEAR::isError($container))
		{
			throw new Exception($container->getMessage());
		}
		
		$this->AddConfig($configId, $container, $overwrite);
	}

	public function File($configId)
	{
		return $this->_configs[$configId];
	}
	
	public function GetSectionKey($section, $keyName, $converter = null)
	{	
		return $this->File(self::DEFAULT_CONFIG_ID)->GetSectionKey($section, $keyName, $converter);
	}
	
	public function GetKey($keyName, $converter = null)
	{
		return $this->File(self::DEFAULT_CONFIG_ID)->GetKey($keyName, $converter);
	}
	
	public function GetScriptUrl()
	{
		return $this->File(self::DEFAULT_CONFIG_ID)->GetScriptUrl();
	}
	
	protected function AddConfig($configId, $container, $overwrite)
	{		
		if (!$overwrite)
		{		
			if (array_key_exists($configId, $this->_configs))
			{
				throw new Exception('Configuration already exists');
			}
		}
		
		$this->_configs[$configId] = new ConfigurationFile($container->getItem("section", self::SETTINGS)->toArray());
	}
}

class ConfigurationFile implements IConfigurationFile
{
	private $_values = array();
	
	public function __construct($values)
	{
		$this->_values = $values[Configuration::SETTINGS];
	}
	
	public function GetKey($keyName, $converter = null)
	{		
		if (array_key_exists($keyName, $this->_values))
		{
			return $this->Convert($this->_values[$keyName], $converter);
		}
		return null;
	}
	
	public function GetSectionKey($section, $keyName, $converter = null)
	{
		if (array_key_exists($section, $this->_values) && array_key_exists($keyName, $this->_values[$section]))
		{
			return $this->Convert($this->_values[$section][$keyName], $converter);
		}
		return null;
	}
	
	public function GetScriptUrl()
	{
		$url = $this->GetKey(ConfigKeys::SCRIPT_URL);
		
		return rtrim($url, '/');
	}
	
	protected function Convert($value, $converter)
	{
		if (!is_null($converter))
		{
			return $converter->Convert($value);
		}
		
		return $value;
	}
}

?>