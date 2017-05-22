<?php
namespace Neochic\SlimTools\Handlers;

use Slim\Handlers\NotFound as SlimNotFound;
use Neochic\SlimTools\Misc\JSend;

class NotFound extends SlimNotFound
{
	protected $jsend;

	public function __construct(JSend $jsend) {
		$this->jsend = $jsend;
	}

	/**
     * Return a response for application/json content not found
     *
     * @return ResponseInterface
     */
    protected function renderJsonNotFoundOutput()
    {
	    $error = $this->jsend->fail('Not found.' );

	    return json_encode( $error, JSON_PRETTY_PRINT );
    }
}
