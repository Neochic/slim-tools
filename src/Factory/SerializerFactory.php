<?php
namespace Neochic\SlimTools\Factory;

use JMS\Serializer\SerializerBuilder;
use \Doctrine\Common\Annotations\AnnotationRegistry;

class SerializerFactory
{
    public static function createSerializer(array $options, SerializerBuilder $serializerBuilder)
    {
        AnnotationRegistry::registerAutoloadNamespace('JMS\Serializer\Annotation', $options['annotation_path']);
        return $serializerBuilder->build();
    }
}