<?php

namespace Neochic\SlimTools\Core;
use Symfony\Component\Validator\Validation;

class ValidatorFactory
{
    public static function createValidator() {
        return Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
    }
}