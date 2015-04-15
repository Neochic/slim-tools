<?php
namespace Neochic\SlimTools\Factory;

use JMS\Serializer\SerializerBuilder;
use Doctrine\Common\Annotations\AnnotationRegistry;
use JMS\Serializer\Naming\PropertyNamingStrategyInterface;

class SerializerFactory
{
    public static function createSerializer(array $options, SerializerBuilder $serializerBuilder, PropertyNamingStrategyInterface $namingStrategy)
    {
        AnnotationRegistry::registerAutoloadNamespace('JMS\Serializer\Annotation', $options['annotation_path']);
        $serializerBuilder->setPropertyNamingStrategy($namingStrategy);
        return $serializerBuilder->build();
    }
}