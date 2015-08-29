<?php

namespace ZendExpressive\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Zend\Stratigility\MiddlewareInterface;

abstract class AbstractLogMiddleware implements MiddlewareInterface
{
    protected $logger;
    protected $level;

    public function __construct(LoggerInterface $logger, $level = LogLevel::INFO)
    {
        $this->logger = $logger;
        $this->level = $level;
    }

    final public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $out = null)
    {
        $contentToLog = $this->getContentToLog($request, $response, $out);

        $this->logger->log($this->level, $contentToLog);

        return $out($request, $response);
    }

    abstract protected function getContentToLog(ServerRequestInterface $request, ResponseInterface $response, callable $out = null);
}
