<?php
namespace Neochic\SlimTools\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Slim\Slim;

abstract class Controller
{
    protected $app;
    protected $em;
    protected $name;

    public function __construct(Slim $slim, EntityManagerInterface $em)
    {
        $this->slim = $slim;
        $this->em = $em;
        if (!$this->name) {
            $this->name = substr(strrchr(get_called_class(), "\\"), 1);
        }
    }
}