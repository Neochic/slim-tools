<?php
namespace Neochic\SlimTools;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Composer\Autoload\ClassLoader;

class Core
{
    public function __construct($config, ClassLoader $classLoader, $boot = 'app')
    {
        $container = new ContainerBuilder();
        $container->set('classLoader', $classLoader);
        $loader = new YamlFileLoader($container, new FileLocator());
        $loader->load(__DIR__ . '/../config/core.yml');
        $loader->load($config);
        $container->compile();
        $app = $container->get($boot);
        $app->setContainer($container);
        $app->run();
    }
}