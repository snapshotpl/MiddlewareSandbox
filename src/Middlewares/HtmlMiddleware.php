<?php

namespace ZendExpressive\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;

class HtmlMiddleware extends AbstractExtensionMiddleware
{
    const EXTENSION_HTML = 'html';

    protected function formatRespose(ResponseInterface $response)
    {
        $responseBody = (string) $response->getBody();

        $html = sprintf('<html><body><h1>%s</h1></body></html>', $responseBody);

        return new HtmlResponse($html, $response->getStatusCode(), $response->getHeaders());
    }

    public function getExtension()
    {
        return self::EXTENSION_HTML;
    }
}
