<?php
namespace Neochic\SlimTools\Router;

class MediaRouter extends Router
{
    public function route()
    {
        $this->attachRoute('media');
    }
}