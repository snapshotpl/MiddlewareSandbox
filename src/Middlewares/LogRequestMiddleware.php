<?php

namespace ZendExpressive\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Zend\Diactoros\Request\Serializer;
use Zend\Stratigility\MiddlewareInterface;

class LogRequestMiddleware implements MiddlewareInterface
{
    protected $logger;
    protected $level;

    public function __construct(LoggerInterface $logger, $level = LogLevel::INFO)
    {
        $this->logger = $logger;
        $this->level = $level;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $out = null)
    {
        $requestString = Serializer::toString($request);

        $this->logger->log($this->level, $requestString);

        return $out($request, $response);
    }

}
