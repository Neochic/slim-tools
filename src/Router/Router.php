<?php

namespace Neochic\SlimTools\Router;

use Slim\App as Slim;
use \Slim\Http\Request;
use \Neochic\SlimTools\Http\Response;
use \Slim\Exception\NotFoundException;

class Router {
	protected $slim;
	protected $passed;
	protected $servicePrefix;

	public function __construct( Slim $slim ) {
		$this->slim = $slim;
	}

	protected function getControllerService( $prefix, $serviceName ) {
		$serviceId = 'controller.' . $prefix . '.' . $serviceName;
		if ( $this->slim->getContainer()->has( $serviceId ) ) {
			return $this->slim->getContainer()->get( $serviceId );
		}

		return null;
	}

	protected function getActionName( Request $request, $name ) {
		$method       = strtolower( $request->getMethod() );
		$actionPrefix = $method === 'get' ? null : $method;
		$action       = $name . 'Action';
		if ( $actionPrefix ) {
			$action = $actionPrefix . ucfirst( $action );
		}

		return $action;
	}

	protected function prepareParams(array $params, \ReflectionMethod $reflection, Request $request, Response $response) : array {
		$actionParams = array();
		reset($params);
		foreach($reflection->getParameters() as $reflectionParam) {
			$key = $reflectionParam->getPosition();
			if($key < 2) {
				$class = $reflectionParam->getClass();
				if($class) {
					$implementedInterfaces = class_implements($class->getName());
					if (isset($implementedInterfaces['Psr\\Http\\Message\\RequestInterface'])) {
						$actionParams[$key] = $request;
						continue;
					}

					if (isset($implementedInterfaces['Psr\\Http\\Message\\ResponseInterface'])) {
						$actionParams[$key] = $response;
						continue;
					}
				}
			}
            $actionParams[$key] = array_shift($params);
		}
		return $actionParams;
	}

	protected function callAction( Request $request, Response $response, $serviceName, $action, $params = array() ): Response {
		$service    = $this->getControllerService( $this->servicePrefix, $serviceName );
		$actionName = $this->getActionName( $request, $action );

		if ( ! is_callable( array( $service, $actionName ) ) ) {
			throw new NotFoundException( $request, $response );
		}

		$reflection = new \ReflectionMethod($service, $actionName);
		$actionParams = $this->prepareParams($params, $reflection, $request, $response);

		return call_user_func_array( array( $service, $actionName ),  $actionParams);
	}

	protected function handleRequest( Request $request, Response $response, $params ): Response {
		if ( count( $params ) >= 1 ) {
			$controller = array_shift( $params );
			$action     = array_shift( $params ) ?: 'index';

			$response = $this->callAction( $request, $response, $controller, $action, $params );

			if ( $response->isSkipViewRendering() ) {
				return $response;
			}

			return $this->render( $request, $response, $controller, $action );
		}

		/*
		 * TODO: it would be nice to pass to the next route,
		 * to allow custom routes within the prefix.
		 * have not yet found a way to get this done
		 * with slim 3.
		 */
		throw new NotFoundException($request, $response);
	}

	protected function render( Request $request, Response $response, string $controller, string $action ): Response {
		return $response;
	}

	protected function attachRoute( $servicePrefix, $urlPrefix = '' ) {
		$this->servicePrefix = $servicePrefix;
		$self                = $this;
		$this->slim->map( [
			'GET',
			'POST',
			'DELETE',
			'PUT'
		], $urlPrefix . '[/{params:.*}]', function ( $request, $response ) use ( $self ) {
			$params = explode( '/', $request->getAttribute( 'params' ) );

			return $self->handleRequest( $request, $response, $params );
		} );
	}
}
