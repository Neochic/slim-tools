<?php
namespace Neochic\SlimTools\Factory;

use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\Naming\PropertyNamingStrategyInterface;

class SerializerFactory
{
    public static function createSerializer(SerializerBuilder $serializerBuilder, PropertyNamingStrategyInterface $namingStrategy)
    {
        $serializerBuilder->setPropertyNamingStrategy($namingStrategy);
        return $serializerBuilder->build();
    }
}