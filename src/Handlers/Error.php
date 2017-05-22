<?php
namespace Neochic\SlimTools\Handlers;

use Slim\Handlers\Error as SlimError;
use Neochic\SlimTools\Misc\JSend;

class Error extends SlimError {
	protected $jsend;

	public function __construct( $displayErrorDetails = false, JSend $jsend ) {
		parent::__construct( $displayErrorDetails );
		$this->jsend = $jsend;
	}

	/**
	 * Render JSON error
	 *
	 * @param \Exception $exception
	 *
	 * @return string
	 */
	protected function renderJsonErrorMessage( \Exception $exception ) {
		$data = null;
		if ( $this->displayErrorDetails ) {
			$data = [];

			do {
				$data[] = [
					'type'    => get_class( $exception ),
					'code'    => $exception->getCode(),
					'message' => $exception->getMessage(),
					'file'    => $exception->getFile(),
					'line'    => $exception->getLine(),
					'trace'   => explode( "\n", $exception->getTraceAsString() ),
				];
			} while ( $exception = $exception->getPrevious() );
		}

		$error = $this->jsend->error( 'An Unexpected Error Occurred.', $data );

		return json_encode( $error, JSON_PRETTY_PRINT );
	}
}
