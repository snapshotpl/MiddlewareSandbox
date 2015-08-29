<?php

namespace ZendExpressive\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\Serializer;
use Zend\Stratigility\MiddlewareInterface;

class NoneHtmlResponseAsHtmlMiddleware implements MiddlewareInterface
{
    const HTML_CONTENT_TYPE = 'text/html';

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $out = null)
    {
        $response = $out($request, $response);

        $contentType = $response->getHeaderLine('Content-Type');
        $accept = $request->getHeaderLine('Accept');

        if (!$this->acceptHtml($accept)) {
            return $out($request, $response);
        }

        if (self::HTML_CONTENT_TYPE === $contentType) {
            return $out($request, $response);
        }

        $noneHtmlBody = Serializer::toString($response);
        $escapedBody = htmlspecialchars($noneHtmlBody);
        $html = '<html><head><title>Middleware response debugger</title></head><body><h1>Debug response!</h1><hr><pre>%s</pre><hr></body></html>';

        $htmlBody = sprintf($html, $escapedBody);

        $htmlResponse = new HtmlResponse($htmlBody);

        return $htmlResponse;
    }

    protected function acceptHtml($accept)
    {
        return strpos($accept, self::HTML_CONTENT_TYPE) !== false || strpos($accept, '*/*') !== false;
    }
}
