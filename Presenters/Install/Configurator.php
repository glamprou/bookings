<?php
 

require_once(ROOT_DIR . 'lib/external/pear/Config.php');

class Configurator
{
	/**
	 * @param string $configPhp
	 * @param string $distPhp
	 */
	public function Merge($configPhp, $distPhp)
	{
		$mergedSettings = $this->GetMerged($configPhp, $distPhp);

		$config = new Config();
		$config->parseConfig($mergedSettings, 'PHPArray');
		$config->writeConfig($configPhp, 'PHPArray', $mergedSettings);

		$this->AddErrorReporting($configPhp);
	}

	/**
	 * @param string $configPhp
	 * @param string $distPhp
	 * @return string
	 */
	private function GetMerged($configPhp, $distPhp)
	{
		$currentSettings = $this->GetSettings($configPhp);
		$newSettings = $this->GetSettings($distPhp);

		$settings = $this->BuildConfig($currentSettings, $newSettings);
		return array('settings' => $settings);
	}

	public function GetMergedString($configPhp, $distPhp)
	{
		$settings = $this->GetMerged($configPhp, $distPhp);
		$config = new Config();
		$parsed = $config->parseConfig($settings, 'PHPArray');

		return $parsed->toString('PHPArray');
	}

	private function GetSettings($file)
	{
		$config = new Config();
		/** @var $current Config_Container */
		$current = $config->parseConfig($file, 'PHPArray');

		if (PEAR::isError($current))
		{
			throw new Exception($current->getMessage());
		}

		$currentValues = $current->getItem("section", Configuration::SETTINGS)->toArray();

		return $currentValues[Configuration::SETTINGS];
	}

	private function BuildConfig($currentSettings, $newSettings)
	{
		foreach ($currentSettings as $key => $value)
		{
			if (array_key_exists($key, $newSettings))
			{
				if (is_array($value))
				{
					$newSettings[$key] = array_merge($newSettings[$key], $value);
				}
				else
				{
					$newSettings[$key] = $value;
				}
			}
		}

		return $newSettings;
	}

	private function AddErrorReporting($file)
	{
		$contents = file_get_contents($file);
		$new = str_replace("<?php", "<?php\r\nerror_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);\r\n", $contents);

		file_put_contents($file, $new);
	}
}

?>