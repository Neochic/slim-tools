<?php
namespace Neochic\SlimTools\Factory;

use JMS\Serializer\SerializerBuilder;

class SerializerFactory
{
    public static function createEntityManager(SerializerBuilder $serializerBuilder)
    {
        return $serializerBuilder->build();
    }
}