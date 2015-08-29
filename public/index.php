<?php

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Application;

chdir(dirname(__DIR__));

require 'vendor/autoload.php';

/* @var $container ContainerInterface */
$container = require 'config/container.php';

/* @var $app Application */
$app = $container->get('app');

$app->pipe('NoneHtmlResponseAsHtmlMiddleware');
$app->pipe('HttpCacheMiddleware');
$app->pipe('JsonMiddleware');
$app->pipe('HtmlMiddleware');

$app->pipe('LogRequestResponseMiddleware');

$app->get('/about.{extension}', function(ServerRequestInterface $request, ResponseInterface $response, callable $next = null) {
    $filledResponse = $response->write(sprintf('About me in %s format', $request->getAttribute('extension')));

    return $next ? $next($request, $filledResponse) : null;
});

$app->run();
