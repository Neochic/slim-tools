<?php

namespace Neochic\SlimTools\Core;
use Symfony\Component\Validator\Validation;

class ValidatorFactory
{
    public static function createValidator($constraintValidatorFactory) {
        return Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->setConstraintValidatorFactory($constraintValidatorFactory)
            ->getValidator();
    }
}