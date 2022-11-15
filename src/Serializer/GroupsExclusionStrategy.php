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
	public function shouldSkipClass( ClassMetadata $metadata, Context $navigatorContext ): bool {
		return false;
	}

	/**
	 * {@inheritDoc}
	 */
	public function shouldSkipProperty( PropertyMetadata $property, Context $navigatorContext ): bool {
		if ( empty( $property->groups ) ) {
			return false;
		}

		$depth = $this->getRealDepth($navigatorContext);

		if ( $depth > count( $this->groups ) ) {
			array_push( $this->groups, $this->savedSubGroups );
		} else {
			while ( $depth < count( $this->groups ) ) {
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

	protected function getRealDepth(Context $context) {
		$depth = 0;
		foreach($context->getMetadataStack() as $metadata) {
			if(!($metadata instanceof PropertyMetadata)) {
				$depth++;
			}
		}

		return $depth;
	}
}
