<?php

namespace ZendExpressive\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Stratigility\MiddlewareInterface;

abstract class AbstractExtensionMiddleware implements MiddlewareInterface
{
    final public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $parts = pathinfo($request->getUri()->getPath());
        if (!empty($parts['extension']) && $parts['extension'] === $this->getExtension()) {
            return $next($request, $this->formatRespose($response));
        }
        return $next($request, $response);
    }

    abstract protected function formatRespose(ResponseInterface $response);

    abstract public function getExtension();
}
