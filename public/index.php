<?php

use Interop\Container\Pimple\PimpleInterop;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Expressive\Application;
use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Router\FastRoute;
use ZendExpressive\Middlewares\HtmlMiddleware;
use ZendExpressive\Middlewares\JsonMiddleware;

chdir(dirname(__DIR__));

require 'vendor/autoload.php';

$container = new PimpleInterop();

$container['app'] = new ApplicationFactory();
$container['Zend\Expressive\Router\RouterInterface'] = function () {
    return new FastRoute();
};
$container['JsonMiddleware'] = function() {
    return new JsonMiddleware();
};
$container['HtmlMiddleware'] = function() {
    return new HtmlMiddleware();
};

/* @var $app Application */
$app = $container['app'];

$app->pipe('JsonMiddleware');
$app->pipe('HtmlMiddleware');

$app->get('/about.{extension}', function(ServerRequestInterface $request, ResponseInterface $response, callable $next = null) {
    $filledResponse = $response->write(sprintf('About me in %s format', $request->getAttribute('extension')));

    $result = $next ? $next($request, $filledResponse) : null;

    if ($result === $filledResponse) {
        return new Response('php://memory', 400);
    }

    return $result;
});



$app->run();