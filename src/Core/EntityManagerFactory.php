<?php
namespace Neochic\SlimTools\Core;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class EntityManagerFactory
{
    public static function createEntityManager(array $database, array $doctrine) {
        $isDevMode = true;

        $config = Setup::createAnnotationMetadataConfiguration($doctrine['model.paths'], $isDevMode);

        return EntityManager::create($database, $config);
    }
}