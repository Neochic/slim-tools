<?php
namespace Neochic\SlimTools\Controller;

abstract class Controller
{
	protected $name;

	public function __construct()
	{
		if (!$this->name) {
			$this->name = substr(strrchr(get_called_class(), "\\"), 1);
		}
	}
}
