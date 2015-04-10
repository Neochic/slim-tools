<?php
namespace Neochic\SlimTools\Router;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Neochic\SlimTools\Core\App;
use Neochic\SlimTools\View\Json;
use Slim\Slim;

class RestRouter
{
    protected $app;
    protected $slim;
    protected $view;

    public function __construct(App $app, Slim $slim, Json $view)
    {
        $this->app = $app;
        $this->slim = $slim;
        $this->view = $view;
    }

    public function route()
    {
        $this->slim->map('/json/:params+', function ($params) {
            if(count($params) >= 1) {
                $controller = array_shift($params);
                $method = strtolower($this->slim->request->getMethod());
                $actionPrefix = $method === 'get' ? null : $method;
                $action = (array_shift($params) ?: 'Index').'Action';
                $serviceId = 'controller.'.$controller;
                $service = null;

                if($actionPrefix) {
                    $action = $actionPrefix . ucfirst($action);
                }

                try {
                    $service = $this->app->getContainer()->get($serviceId);
                } catch (InvalidArgumentException $error) {
                    //don't have to do anything to handle the error route
                    //will pass anyway in the next step if $service is null
                }
                if(!is_callable(array($service, $action))) {
                    $this->slim->pass();
                    return;
                }

                $this->slim->view($this->view);
                $result = call_user_func_array(array($service, $action), $params);
                $this->slim->render(null, $result);
            }
        })->via('GET', 'POST', 'DELETE', 'PUT');
    }
}