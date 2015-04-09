<?php
namespace Neochic\SlimTools;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Core
{
    public function __construct($config, $boot = 'app')
    {
        $container = new ContainerBuilder();
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/config'));
        $loader->load(__DIR__ . '/../config/core.yml');
        $loader->load($config);
        $app = $container->get($boot);
        $app->setContainer($container);
        $app->run();
    }
}