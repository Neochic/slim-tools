<?php
namespace Neochic\SlimTools\Router;

use \JMS\Serializer\Serializer;
use \Neochic\SlimTools\Misc\JSend;
use \Slim\App as Slim;
use \Slim\Http\Request;
use \Neochic\SlimTools\Http\Response;

class RestRouter extends Router
{
	protected $serializer;
	protected $jSend;

	public function __construct(Slim $slim, Serializer $serializer, JSend $jSend)
	{
		parent::__construct($slim);
		$this->serializer = $serializer;
		$this->jSend = $jSend;
	}

	public function route()
	{
		$this->attachRoute('json', '/json');
	}

	protected function render(Request $request, Response $response, string $controller, string $action) : Response {
		$status = "success";
		$jSendParams = array($response->getViewData());
		switch(floor($response->getStatusCode() / 100)) {
			case 3:
				return $response;
			case 4:
				$status = "fail";
				break;
			case 5:
				$status = "error";
				array_unshift($jSendParams, $response->getReasonPhrase());
				break;
		}

		$data = call_user_func_array(array($this->jSend, $status), $jSendParams);

		$serializationContext = $response->getSerializationContext();

		$serialized = call_user_func_array(array($this->serializer, 'serialize'), array($data, 'json', $serializationContext));
		$response->getBody()->write($serialized);
		$response = $response->withHeader('Content-Type', 'application/json;charset=utf-8');
		return $response;
	}
}
