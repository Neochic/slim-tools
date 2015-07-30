<?php
namespace Neochic\SlimTools\Service;
use Doctrine\Common\Persistence\ManagerRegistry as DoctrineManagerRegistry;
use Doctrine\ORM\EntityManager;

class ManagerRegistry implements DoctrineManagerRegistry
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * Gets the default connection name.
     *
     * @return string The default connection name.
     */
    public function getDefaultConnectionName()
    {
        // TODO: Implement getDefaultConnectionName() method.
    }

    /**
     * Gets the named connection.
     *
     * @param string $name The connection name (null for the default one).
     *
     * @return object
     */
    public function getConnection($name = null)
    {
        // TODO: Implement getConnection() method.
    }

    /**
     * Gets an array of all registered connections.
     *
     * @return array An array of Connection instances.
     */
    public function getConnections()
    {
        // TODO: Implement getConnections() method.
    }

    /**
     * Gets all connection names.
     *
     * @return array An array of connection names.
     */
    public function getConnectionNames()
    {
        // TODO: Implement getConnectionNames() method.
    }

    /**
     * Gets the default object manager name.
     *
     * @return string The default object manager name.
     */
    public function getDefaultManagerName()
    {
        // TODO: Implement getDefaultManagerName() method.
    }

    /**
     * Gets a named object manager.
     *
     * @param string $name The object manager name (null for the default one).
     *
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    public function getManager($name = null)
    {
        return $this->entityManager;
    }

    /**
     * Gets an array of all registered object managers.
     *
     * @return \Doctrine\Common\Persistence\ObjectManager[] An array of ObjectManager instances
     */
    public function getManagers()
    {
        // TODO: Implement getManagers() method.
    }

    /**
     * Resets a named object manager.
     *
     * This method is useful when an object manager has been closed
     * because of a rollbacked transaction AND when you think that
     * it makes sense to get a new one to replace the closed one.
     *
     * Be warned that you will get a brand new object manager as
     * the existing one is not useable anymore. This means that any
     * other object with a dependency on this object manager will
     * hold an obsolete reference. You can inject the registry instead
     * to avoid this problem.
     *
     * @param string|null $name The object manager name (null for the default one).
     *
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    public function resetManager($name = null)
    {
        // TODO: Implement resetManager() method.
    }

    /**
     * Resolves a registered namespace alias to the full namespace.
     *
     * This method looks for the alias in all registered object managers.
     *
     * @param string $alias The alias.
     *
     * @return string The full namespace.
     */
    public function getAliasNamespace($alias)
    {
        // TODO: Implement getAliasNamespace() method.
    }

    /**
     * Gets all connection names.
     *
     * @return array An array of connection names.
     */
    public function getManagerNames()
    {
        // TODO: Implement getManagerNames() method.
    }

    /**
     * Gets the ObjectRepository for an persistent object.
     *
     * @param string $persistentObject The name of the persistent object.
     * @param string $persistentManagerName The object manager name (null for the default one).
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository($persistentObject, $persistentManagerName = null)
    {
        // TODO: Implement getRepository() method.
    }

    /**
     * Gets the object manager associated with a given class.
     *
     * @param string $class A persistent object class name.
     *
     * @return \Doctrine\Common\Persistence\ObjectManager|null
     */
    public function getManagerForClass($class)
    {
        return $this->entityManager;
    }
}