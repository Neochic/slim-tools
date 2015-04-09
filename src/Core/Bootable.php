<?php
namespace Neochic\SlimTools\Core;

abstract class Bootable
{
    protected $container;
    protected $config;

    abstract public function run();

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function getContainer()
    {
        return $this->container;
    }
}