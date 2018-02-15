<?php
namespace Neochic\SlimTools\Factory;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

class EntityManagerFactory
{
    public static function createEntityManager(array $database, array $doctrine, ClassLoader $classLoader) {
        $isDevMode = true;
	$config = Setup::createAnnotationMetadataConfiguration($doctrine['model.paths'], $isDevMode, null, null, false);
        $config->setAutoGenerateProxyClasses(constant("Doctrine\\Common\\Proxy\\AbstractProxyFactory::". $doctrine['proxyMode']));

        AnnotationRegistry::registerLoader(array($classLoader, 'loadClass'));

        if (isset($doctrine['annotation.paths'])) {
            foreach ( $doctrine['annotation.paths'] as $namespace => $path ) {
	        AnnotationRegistry::registerAutoloadNamespace( $namespace, $path );
            }
        }

        if (isset($doctrine['dql.paths'])) {
            foreach($doctrine['dql.paths'] as $name => $path) {
                $config->addCustomStringFunction($name, $path);
            }
        }

        $em = EntityManager::create($database, $config);
        $em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

	    return $em;
    }
}
