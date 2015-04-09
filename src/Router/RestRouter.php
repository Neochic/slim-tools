<?php
namespace Neochic\SlimTools\Router;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

class RestRouter
{
    protected $app;
    protected $view;

    public function __construct(\Neochic\SlimTools\Core\App $app, \Neochic\SlimTools\View\Json $view)
    {
        $this->app = $app;
        $this->view = $view;
    }

    public function route()
    {
        $slim = $this->app->getSlim();

        $slim->map('/json/:params+', function ($params) use ($slim) {
            if(count($params) >= 1) {
                $controller = array_shift($params);
                $method = strtolower($slim->request->getMethod());
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
                    $slim->pass();
                    return;
                }

                $slim->view($this->view);
                $result = call_user_func_array(array($service, $action), $params);
                $slim->render(null, array('json' => $result));
            }
        })->via('GET', 'POST', 'DELETE', 'PUT');
    }
}