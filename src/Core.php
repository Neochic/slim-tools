<?php
namespace Neochic\SlimTools;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Core
{
    protected $app;

    function __construct($config)
    {
        $container = new ContainerBuilder();
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/config'));
        $loader->load(__DIR__ . '/../config/core.yml');
        $loader->load($config);
        $app = $container->get('app');
        $app->setContainer($container);
        $app->run();
    }
}