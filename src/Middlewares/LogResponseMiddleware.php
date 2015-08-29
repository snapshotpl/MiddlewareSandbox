<?php

namespace ZendExpressive\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\Serializer;

class LogResponseMiddleware extends AbstractLogMiddleware
{
    protected function getContentToLog(ServerRequestInterface $request, ResponseInterface $response, callable $out = null)
    {
        return Serializer::toString($response);
    }
}
