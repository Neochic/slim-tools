<?php
namespace Neochic\SlimTools\Core;

use \Slim\App as Slim;

class App extends Bootable
{
	protected $middlewares;
	protected $routers;
	protected $slim;

	public function __construct(array $config, Slim $slim, array $routers, array $middlewares) {
		parent::__construct($config);

		if(isset($config['app']['mode']) && $config['app']['mode'] === 'dev') {
			error_reporting(E_ALL);
			ini_set("display_errors", 1);
		} else {
			error_reporting(E_ALL ^ E_NOTICE);
			ini_set("display_errors", 0);
		}

        /**
         * disable php cache management to be able
         * to set own cache headers
         */
        session_cache_limiter('');

		$this->routers = $routers;
		$this->middlewares = $middlewares;
		$this->slim = $slim;
	}

	public function run() {
		foreach($this->middlewares as $middleware) {
			$this->slim->add($this->slim->getContainer()->get($middleware));
		}

		foreach($this->routers as $router) {
			$this->slim->getContainer()->get($router)->route();
		}

		$this->slim->run();
	}
}
