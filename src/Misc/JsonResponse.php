<?php
/*
 * Helper to create json responses in JSend format
 * http://labs.omniti.com/labs/jsend
 */
namespace Neochic\SlimTools\Misc;

class JsonResponse
{
    public function success($data = null)
    {
        return $this->createResponse("success", $data);
    }

    public function fail($type, $data = null)
    {
        return $this->createResponse("fail", array("type" => $type, "data" => $data));
    }

    public function error($message)
    {
        return $this->createResponse("error", $message);
    }

    protected function createResponse($type, $data) {
        $response = array("status" => $type);
        if($type === "error") {
            $reponse["message"] = $data;
        } else {
            $reponse["data"] = $data;
        }
        return $response;
    }
}