<?php

namespace BillSDK\Support;

use BillSDK\Support\Repository;

class Config
{
	/**
	 * Instance of repository.
	 *
	 * @var \BillSDK\Support\Repository
	 */
	protected $repository;
	
	/**
	 * Create a config class instance.
	 *
	 */
	public function __construct()
	{
		$this->repository = new Repository($this->getConfigs());
	}
	
	/**
	 * Get config file and the array config  parameters.
	 *
	 * @return array
	 */
	private function getConfigs()
	{
		$configs = [];
		$filenames = array_slice(scandir(__DIR__ . '/../config', null), 2);
		foreach ($filenames as $filename) {
			$fileConfig = include __DIR__ . '/../config/' . $filename;
			$configs[str_replace('.php', '', $filename)] = $fileConfig;
		}
		
		return $configs;
	}
	
	/**
	 * Get config value from repository.
	 *
	 * @param $key
	 * @param null $default
	 * @return mixed|null
	 */
	public function getConfigValue($key, $default = null)
	{
		$keys = explode('.', $key);
		$value = $default;
		foreach ($keys as $index => $key) {

			if ($index === 0) {
				$value = $this->repository->get($key, $default);
				continue;
			}

			if (!is_array($value)) {
				break;
			}
			
			if(!array_key_exists($key, $value)){
				$value = null;
				break;
			}
			
			$value = $value[$key];
		}

		return $value  === null ? $default : $value;
	}

}