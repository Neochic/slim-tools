<?php
namespace Neochic\SlimTools\View;

use \JMS\Serializer\Serializer;

class Json extends \Slim\View
{
    protected $serializer;

    public function __construct(Serializer $serializer)
    {
        parent::__construct();
        $this->serializer = $serializer;
    }

    public function render($template, $data = null)
    {
        $data = $this->getData('json');
        $context = $this->getData('context') ?: null;
        echo $this->serializer->serialize($data, 'json', $context);
    }
}