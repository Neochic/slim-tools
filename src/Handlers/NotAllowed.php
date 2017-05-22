<?php
namespace Neochic\SlimTools\Handlers;

use Slim\Handlers\NotAllowed as SlimNotAllowed;
use Neochic\SlimTools\Misc\JSend;

class NotAllowed extends SlimNotAllowed
{
	protected $jsend;

	public function __construct(JSend $jsend) {
		$this->jsend = $jsend;
	}

	/**
     * Render JSON not allowed message
     *
     * @param  array                  $methods
     * @return string
     */
    protected function renderJsonNotAllowedMessage($methods)
    {
        $allow = implode(', ', $methods);
	    $error = $this->jsend->fail('Method not allowed. Must be one of: ' . $allow);

	    return json_encode( $error, JSON_PRETTY_PRINT );
    }
}
