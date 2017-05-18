<?php

namespace Neochic\SlimTools\Factory;

use Symfony\Component\Validator\ConstraintValidatorFactory as SymfonyConstraintValidatorFactory;
use Symfony\Component\Validator\Constraint;
use \Slim\Container;

class ConstraintValidatorFactory extends SymfonyConstraintValidatorFactory {
	protected $container;

	public function __construct( $propertyAccessor = null, Container $container = null ) {
		parent::__construct( $propertyAccessor );
		$this->container = $container;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getInstance( Constraint $constraint ) {
		if ( $this->container->has( $constraint->validatedBy() ) ) {
			return $this->container->get( $constraint->validatedBy() );
		}

		return parent::getInstance( $constraint );
	}
}
