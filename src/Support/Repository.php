<?php

namespace BillSDK\Support;


class Repository
{
	/**
	 * All of the configuration items.
	 *
	 * @var array
	 */
	protected $items = [];
	
	/**
	 * Create a new configuration repository.
	 *
	 * @param  array  $items
	 * @return void
	 */
	public function __construct(array $items = [])
	{
		$this->items = $items;
	}
	
	/**
	 * Determine if the given configuration value exists.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function has($key)
	{
		return array_key_exists($key, $this->items);
	}
	
	/**
	 * Get the specified configuration value.
	 *
	 * @param  array|string  $key
	 * @param  mixed   $default
	 * @return mixed
	 */
	public function get($key, $default = null)
	{
		if (is_array($key)) {
			return $this->getMany($key);
		}
		
		if($this->has($key)){
			return $this->items[$key];
		}
		
		return $default;
	}
	
	/**
	 * Get many configuration values.
	 *
	 * @param  array  $keys
	 * @return array
	 */
	public function getMany($keys)
	{
		$config = [];
		foreach ($keys as $key => $default) {
			if (is_numeric($key)) {
				$key = $default;
				$default = null;
			}
			$config[$key] = $this->get($key, $default);
		}
		return $config;
	}
	
	/**
	 * Set a given configuration value.
	 *
	 * @param  array|string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function set($key, $value = null)
	{
		$keys = is_array($key) ? $key : [$key => $value];
		foreach ($keys as $key => $value) {
			$this->items[$key] = $value;
		}
	}
	
	/**
	 * Prepend a value onto an array configuration value.
	 *
	 * @param  string  $key
	 * @param  mixed  $value
	 * @return void
	 */
	public function prepend($key, $value)
	{
		$array = $this->get($key);
		array_unshift($array, $value);
		$this->set($key, $array);
	}
	
	/**
	 * Push a value onto an array configuration value.
	 *
	 * @param  string  $key
	 * @param  mixed  $value
	 * @return void
	 */
	public function push($key, $value)
	{
		$array = $this->get($key);
		$array[] = $value;
		$this->set($key, $array);
	}
	
	/**
	 * Get all of the configuration items for the SDK.
	 *
	 * @return array
	 */
	public function all()
	{
		return $this->items;
	}
}