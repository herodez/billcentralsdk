<?php

use BillSDK\Support\Config;

/**
 *  BillSDK\Support\Config class facade.
 *
 * @param $key
 * @return mixed|null
 */
function config($key)
{
	$config = new Config();
	return $config->getConfigValue($key);
}


