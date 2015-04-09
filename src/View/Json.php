<?php
namespace Neochic\SlimTools\View;

class Json extends \Slim\View
{
    public function render($template, $data = null)
    {
        echo json_encode($this->getData('json'));
    }
}