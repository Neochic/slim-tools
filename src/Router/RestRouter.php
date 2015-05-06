<?php
namespace Neochic\SlimTools\Router;

class RestRouter extends Router
{
    public function route()
    {
        $this->attachRoute('json', '/json');
    }

    protected function render($data, $controller, $action) {
        $this->slim->contentType('application/json');
        parent::render($data, $controller, $action);
    }
}