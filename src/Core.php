<?php
namespace Neochic\SlimTools;

use \Slim\Container;
use \Neochic\SlimTools\Core\ServiceConfiguration;
use \Neochic\SlimTools\Core\ServiceConfigurationInterface;
use \Neochic\SlimTools\Core\Config;
use \Composer\Autoload\ClassLoader;
use \Symfony\Component\Yaml\Parser;

class Core
{
	public function __construct(string $configPath = null, ClassLoader $classLoader, ServiceConfigurationInterface $serviceConfiguration = null,  string $boot = 'app')
	{
		$configLoader = new Config(new Parser());
		$configLoader->load(__DIR__ . '/../config/config.yml');
		$configLoader->load($configPath);
		$config = $configLoader->get();

		$slimSettings = array();
		if(isset($config['slim'])) {
			$slimSettings = $config['slim'];
			unset($config['slim']);
		}

		$container = new Container(array_merge(
			ServiceConfiguration::get(),
			$serviceConfiguration ? $serviceConfiguration::get() : array(),
			array('config' => $config),
			array('settings' => $slimSettings),
			array('classLoader' => $classLoader)
		));

		$container[$boot]->run();
	}
}
