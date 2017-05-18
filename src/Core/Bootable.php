<?php
namespace Neochic\SlimTools\Core;

abstract class Bootable
{
	protected $config;

    abstract public function run();

	public function __construct(array $config)
	{
		$this->config = $config;
	}
}
