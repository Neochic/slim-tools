<?php
namespace Neochic\SlimTools\Handlers;

use Slim\Handlers\PhpError as SlimPhpError;
use Neochic\SlimTools\Misc\JSend;

class PhpError extends SlimPhpError
{
	protected $jsend;

	public function __construct( $displayErrorDetails = false, JSend $jsend ) {
		parent::__construct( $displayErrorDetails );
		$this->jsend = $jsend;
	}

	/**
     * Render JSON error
     *
     * @param \Throwable $error
     *
     * @return string
     */
    protected function renderJsonErrorMessage(\Throwable $error)
    {
	    $data = null;

        if ($this->displayErrorDetails) {
            $data = [];

            do {
                $data[] = [
                    'type' => get_class($error),
                    'code' => $error->getCode(),
                    'message' => $error->getMessage(),
                    'file' => $error->getFile(),
                    'line' => $error->getLine(),
                    'trace' => explode("\n", $error->getTraceAsString()),
                ];
            } while ($error = $error->getPrevious());
        }

	    $error = $this->jsend->error( 'An Unexpected Error Occurred.', $data );
        return json_encode($error, JSON_PRETTY_PRINT);
    }
}
