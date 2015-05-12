<?php
namespace Neochic\SlimTools\Factory;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Annotations\AnnotationRegistry;

class EntityManagerFactory
{
    public static function createEntityManager(array $database, array $doctrine) {
        $isDevMode = true;

        $config = Setup::createAnnotationMetadataConfiguration($doctrine['model.paths'], $isDevMode, null, null, false);
        $config->setAutoGenerateProxyClasses(constant("Doctrine\\Common\\Proxy\\AbstractProxyFactory::". $doctrine['proxyMode']));

        foreach($doctrine['annotation.paths'] as $namespace => $path) {
            AnnotationRegistry::registerAutoloadNamespace($namespace, $path);
        }

        return EntityManager::create($database, $config);
    }
}