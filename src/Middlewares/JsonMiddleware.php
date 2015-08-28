<?php

namespace ZendExpressive\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;

class JsonMiddleware extends AbstractExtensionMiddleware
{
    const EXTENSION_JSON = 'json';

    protected function formatRespose(ResponseInterface $response)
    {
        $responseBody = (string) $response->getBody();

        return new JsonResponse(['result' => $responseBody], $response->getStatusCode(), $response->getHeaders());
    }

    public function getExtension()
    {
        return self::EXTENSION_JSON;
    }

}