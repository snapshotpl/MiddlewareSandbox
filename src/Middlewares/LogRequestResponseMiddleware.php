<?php

namespace ZendExpressive\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Stratigility\MiddlewareInterface;

class LogRequestResponseMiddleware implements MiddlewareInterface
{
    protected $logRequest;
    protected $logRespose;

    public function __construct(LogRequestMiddleware $logRequest, LogResponseMiddleware $logResponse)
    {
        $this->logRequest = $logRequest;
        $this->logRespose = $logResponse;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $out = null)
    {
        call_user_func($this->logRequest, $request, $response, $out);
        call_user_func($this->logRespose, $request, $response, $out);

        return $out($request, $response);
    }

}
