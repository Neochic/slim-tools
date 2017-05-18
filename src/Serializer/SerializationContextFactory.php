<?php
namespace Neochic\SlimTools\Serializer;

class SerializationContextFactory {
	public function createSerializationContext(array $groups) {
		$context = new SerializationContext();
		$context->setSerializeNull(true);
		$context->setGroups($groups);
		return $context;
	}
}
