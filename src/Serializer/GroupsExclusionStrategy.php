<?php

namespace Neochic\SlimTools\Serializer;

use \JMS\Serializer\Metadata\ClassMetadata;
use \JMS\Serializer\Metadata\PropertyMetadata;
use \JMS\Serializer\Context;
use \JMS\Serializer\Exclusion\ExclusionStrategyInterface;

class GroupsExclusionStrategy implements ExclusionStrategyInterface {
	protected $groups = array();
	protected $savedSubGroups = array( '' );

	public function __construct( array $groups ) {
		array_push( $this->groups, $groups );
	}

	/**
	 * {@inheritDoc}
	 */
	public function shouldSkipClass( ClassMetadata $metadata, Context $navigatorContext ) {
		return false;
	}

	/**
	 * {@inheritDoc}
	 */
	public function shouldSkipProperty( PropertyMetadata $property, Context $navigatorContext ) {
		if ( empty( $property->groups ) ) {
			return false;
		}

		if ( $navigatorContext->getDepth() > count( $this->groups ) ) {
			array_push( $this->groups, $this->savedSubGroups );
		} else {
			while ( $navigatorContext->getDepth() < count( $this->groups ) ) {
				array_pop( $this->groups );
			}
		}
		$groups               = end( $this->groups );
		$match                = false;
		$this->savedSubGroups = array();
		foreach ( $property->groups as $key => $value ) {
			if ( is_numeric( $key ) ) {
				$group    = $value;
				$subGroup = null;
			} else {
				$group    = $key;
				$subGroup = $value;
			}
			if ( in_array( $group, $groups ) ) {
				$match = true;
				if ( $subGroup ) {
					array_push( $this->savedSubGroups, $subGroup );
				}
			}
		}
		$this->savedSubGroups = array_unique( $this->savedSubGroups );

		return ! $match;
	}
}
