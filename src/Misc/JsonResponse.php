<?php

namespace Neochic\SlimTools\Misc;

class JsonResponse extends JSend
{
    public function success($data = null, $context = null)
    {
        return addContext(parent::success($data), $context);
    }

    public function fail($type, $data = null, $context = null)
    {
        return addContext(parent::fail($type, $data), $context);
    }

    public function error($message, $context = null)
    {
        return addContext(parent::error($message), $context);
    }

    protected function addContext($response, $context = null) {
        return array(
            'json' => $response,
            'context' => $context
        );
    }
}