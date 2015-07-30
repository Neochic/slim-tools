<?php

namespace Neochic\SlimTools\Factory;
use Symfony\Component\Validator\ConstraintValidatorFactory as SymfonyConstraintValidatorFactory;
use Symfony\Component\Validator\Constraint;
use Neochic\SlimTools\Core\App;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

class ContraintValidatorFactory extends SymfonyConstraintValidatorFactory
{
    protected $app;

    public function __construct($propertyAccessor = null, App $app = null)
    {
        parent::__construct($propertyAccessor);
        $this->app = $app;
    }

    /**
     * {@inheritdoc}
     */
    public function getInstance(Constraint $constraint)
    {
        try {
            return $this->app->getContainer()->get($constraint->validatedBy());
        } catch (InvalidArgumentException $error) {
            //don't need to do anything, parent class handles those cases
        }
        return parent::getInstance($constraint);
    }
}