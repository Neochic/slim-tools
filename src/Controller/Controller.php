<?php
namespace Neochic\SlimTools\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Neochic\SlimTools\Core\App;

abstract class Controller
{
    protected $app;
    protected $em;
    protected $name;

    public function __construct(App $app, EntityManagerInterface $em)
    {
        $this->app = $app;
        $this->em = $em;
        if (!$this->name) {
            $this->name = substr(strrchr(get_called_class(), "\\"), 1);
        }
    }
}