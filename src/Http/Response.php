<?php

namespace Neochic\SlimTools\Http;

use \Slim\Http\Response as SlimResponse;
use \JMS\Serializer\SerializationContext;
use \Neochic\SlimTools\Serializer\SerializationContextFactory;


class Response extends SlimResponse {
	protected $serializationContext = null;
	protected $viewData = null;
	protected $skipViewRendering = false;

	/**
	 * @return SerializationContext
	 */
	public function getSerializationContext(): SerializationContext {
		if ( ! $this->serializationContext ) {
			$serializationContextFactory = new SerializationContextFactory();

			return $serializationContextFactory->createSerializationContext( array( 'everyone' ) );
		}

		return $this->serializationContext;
	}

	/**
	 * @param SerializationContext $context
	 */
	public function setSerializationContext( SerializationContext $context ) {
		$this->serializationContext = $context;
	}

	/**
	 * @param array $groups
	 */
	public function setSerializationContextGroups( array $groups ) {
		$serializationContextFactory = new SerializationContextFactory();
		$context                     = $serializationContextFactory->createSerializationContext( $groups );
		$this->setSerializationContext( $context );
	}

	/**
	 * @return null
	 */
	public function getViewData() {
		return $this->viewData;
	}

	/**
	 * @param null $data
	 */
	public function setViewData( $data ) {
		$this->viewData = $data;
	}

	/**
	 * @return bool
	 */
	public function isSkipViewRendering(): bool {
		return $this->skipViewRendering;
	}

	/**
	 * @param bool $skipViewRendering
	 */
	public function setSkipViewRendering( bool $skipViewRendering ) {
		$this->skipViewRendering = $skipViewRendering;
	}
}
