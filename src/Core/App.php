<?php
namespace Neochic\SlimTools\Core;

use \Slim\Slim;

class App extends Bootable
{
    protected $slim;

    public function __construct(array $config, Slim $slim)
    {
        parent::__construct($config);

        $this->slim = $slim;

        $slim->config(array(
            'log.enabled' => $config['log.enabled'],
            'log.level' => constant('\Slim\Log::' . strtoupper($config['log.level'])),
            'debug' => false
        ));

        switch ($config['mode']) {
            case "dev":
                error_reporting(E_ALL);
                ini_set("display_errors", 1);
                $this->slim->config('debug', true);
                break;
            default:
                error_reporting(E_ALL ^ E_NOTICE);
                ini_set("display_errors", 0);
        }
    }

    public function run()
    {
        $this->container->get('router.rest')->route();
        $this->container->get('router.media')->route();
        $this->slim->run();
    }
}