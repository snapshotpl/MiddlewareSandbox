<?php

namespace ZendExpressive\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Stratigility\MiddlewareInterface;

class JsonMiddleware implements MiddlewareInterface
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        if (strpos($request->getUri()->getPath(), '.json')) {
            $responseBody = $response->getBody()->getContents();
            $jsonResponse = new JsonResponse($responseBody, $response->getStatusCode(), $response->getHeaders());

            return $next($request, $jsonResponse);
        }
    }
}