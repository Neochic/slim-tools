<?php
namespace Neochic\SlimTools\View;

class Media extends \Slim\View
{
    protected $serializer;

    public function render($template, $data = null)
    {
        $data = $this->getData('file');
        if($data) {
            echo $data;
        }
    }
}