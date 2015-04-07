<?php
namespace Neochic\SlimTools\Controller;

class Controller
{
    protected $app;
    protected $name = false;

    function __construct(\Neochic\SlimTools\Core\App $app)
    {
        $this->app = $app;
        if (!$this->name) {
            $this->name = substr(strrchr(get_called_class(), "\\"), 1);
        }
    }
}