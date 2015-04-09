<?php
namespace Neochic\SlimTools\Controller;

abstract class Controller
{
    protected $app;
    protected $em;
    protected $name;

    public function __construct(\Neochic\SlimTools\Core\App $app, \Doctrine\ORM\EntityManagerInterface $em)
    {
        $this->app = $app;
        $this->em = $em;
        if (!$this->name) {
            $this->name = substr(strrchr(get_called_class(), "\\"), 1);
        }
    }
}