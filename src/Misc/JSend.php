<?php
/*
 * Helper to create responses in JSend format
 * http://labs.omniti.com/labs/jsend
 */
namespace Neochic\SlimTools\Misc;

class JSend
{
    public function success($data = null)
    {
        return $this->createResponse("success", null, $data);
    }

    public function fail($data = null)
    {
        return $this->createResponse("fail", null, $data);
    }

    public function error($message, $data = null)
    {
        return $this->createResponse("error", $message, $data);
    }

    protected function createResponse(string $type, string $message = null, $data = null) {
        $response = array("status" => $type);
        if($type === "error") {
            $response["message"] = $message;
	        if($data !== null) {
		        $response["data"] = $data;
	        }
        } else {
            $response["data"] = $data;
        }
        return $response;
    }
}
