<?php

namespace Neochic\SlimTools\Router;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Neochic\SlimTools\Core\App;
use Slim\Slim;
use \Slim\View;

class Router
{
    protected $app;
    protected $slim;
    protected $view;
    protected $passed;
    protected $servicePrefix;
    protected $template = null;

    public function __construct(App $app, Slim $slim, View $view)
    {
        $this->app = $app;
        $this->slim = $slim;
        $this->view = $view;
    }

    protected function getControllerService($prefix, $serviceName) {
        $serviceId = 'controller.'.$prefix.'.'.$serviceName;
        $service = null;
        try {
            $service = $this->app->getContainer()->get($serviceId);
        } catch (InvalidArgumentException $error) {
            //don't have to do anything to handle the error route
            //will pass anyway in the next step if $service is null
        }
        return $service;
    }

    protected function getActionName($name) {
        $method = strtolower($this->slim->request->getMethod());
        $actionPrefix = $method === 'get' ? null : $method;
        $action = ($name ?: 'Index').'Action';
        if($actionPrefix) {
            $action = $actionPrefix . ucfirst($action);
        }
        return $action;
    }

    protected function callAction($prefix, $serviceName, $action, $params = array()) {
        $this->passed = false;
        $service = $this->getControllerService($prefix, $serviceName);
        $actionName = $this->getActionName($action);

        if(!is_callable(array($service, $actionName))) {
            $this->slim->pass();
            $this->passed = true;
            return;
        }

        return call_user_func_array(array($service, $actionName), $params);
    }

    protected function handleRequest($params) {
        if(count($params) >= 1) {
            $controller = array_shift($params);
            $action = array_shift($params);
            $data = $this->callAction($this->servicePrefix, $controller, $action, $params);
            if(!$this->passed) {
                $this->render($data);
            }
        } else {
            $this->slim->pass();
        }
    }

    protected function render($data) {
        $this->slim->view($this->view);
        $this->slim->render($this->template, $data);
    }

    protected function attachRoute($servicePrefix, $urlPrefix = '') {
        $this->servicePrefix = $servicePrefix;
        $route = $this->slim->map($urlPrefix.'/:params+', function($params) {
            $this->handleRequest($params);
        });
        call_user_func_array(array($route, 'via'), array('GET', 'POST', 'DELETE', 'PUT'));
    }
}