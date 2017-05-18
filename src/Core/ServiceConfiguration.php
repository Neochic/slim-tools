<?php
namespace Neochic\SlimTools\Core;

use \Slim\App as Slim;
use \Slim\Http\Headers;
use \Slim\Container;
use \JMS\Serializer\SerializerBuilder;
use \JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use \JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use \Neochic\SlimTools\Router\RestRouter;
use \Neochic\SlimTools\Router\MediaRouter;
use \Neochic\SlimTools\Factory\EntityManagerFactory;
use \Neochic\SlimTools\Factory\ValidatorFactory;
use \Neochic\SlimTools\Factory\ConstraintValidatorFactory;
use \Neochic\SlimTools\Factory\SerializerFactory;
use \Neochic\SlimTools\Misc\Session;
use \Neochic\SlimTools\Misc\JSend;
use \Neochic\SlimTools\Http\Response;
use \Neochic\SlimTools\Serializer\GroupsExclusionStrategy;
use \Neochic\SlimTools\Serializer\SerializationContextFactory;

class ServiceConfiguration implements ServiceConfigurationInterface
{
	public static function get() : array {
		return [
			'app' => function($c) {
				return new App($c['config'], $c['slim'], $c['config']['app']['routers'], $c['config']['app']['middlewares']);
			},
			'console' => function($c) {
				return new Console($c['config']['migrations'], $c['entityManager']);
			},
			'slim' => function($c) {
				if(isset($c['config']['app']['mode'])) {
					$c['settings']['displayErrorDetails'] = $c['config']['app']['mode'] === 'dev';
				}

				return new Slim($c);
			},
			'config' => [
				'app' => [
					'routers' => [],
					'middlewares' => []
				]
			],
			'router.rest' => function($c) {
				return new RestRouter($c['slim'], $c['serializer'], $c['jsend']);
			},
			'router.media' => function($c) {
				return new MediaRouter($c['slim']);
			},
			'entityManager' => function($c) {
				return EntityManagerFactory::createEntityManager($c['config']['database'], $c['config']['doctrine'], $c['classLoader']);
			},
			'validator' => function($c) {
				return ValidatorFactory::createValidator($c['validator.constraintFactory']);
			},
			'validator.constraintFactory' => function($c) {
				return new ConstraintValidatorFactory(null, $c);
			},
			'serializer' => function($c) {
				return SerializerFactory::createSerializer($c['serializer.builder'], $c['serializer.SerializedNameAnnotationStrategy']);
			},
			'serializer.builder' => function() {
				return SerializerBuilder::create();
			},
			'serializer.SerializedNameAnnotationStrategy' => function($c) {
				return new SerializedNameAnnotationStrategy($c['serializer.IdenticalPropertyNamingStrategy']);
			},
			'serializer.IdenticalPropertyNamingStrategy' => function() {
				return new IdenticalPropertyNamingStrategy();
			},
			'serializer.contextFactory' => function() {
				return new SerializationContextFactory();
			},
			'session' => function() {
				return new Session();
			},
			'jsend' => function() {
				return new JSend();
			},
			'response' => function (Container $c) {
				$headers = new Headers(['Content-Type' => 'text/html; charset=UTF-8']);
				$response = new Response(200, $headers);

				return $response->withProtocolVersion($c->get('settings')['httpVersion']);
			}
		];
	}
}
