<?php

namespace Neochic\SlimTools\Serializer;

use \JMS\Serializer\Exclusion\ExclusionStrategyInterface;
use \JMS\Serializer\SerializationContext as JMSSerializationContext;

class SerializationContext extends JMSSerializationContext {

	/*
	 * replace groups exclusion strategy with our own that can handle
	 * separate groups for relations
	 */

	public function addExclusionStrategy( ExclusionStrategyInterface $strategy ): self {
		if ( get_class( $strategy ) === 'JMS\Serializer\Exclusion\GroupsExclusionStrategy' ) {
			$strategy = new GroupsExclusionStrategy( $this->getAttribute( 'groups' ) );
		}

		return parent::addExclusionStrategy( $strategy );
	}
}
