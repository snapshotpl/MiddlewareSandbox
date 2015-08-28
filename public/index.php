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
$router = new FastRoute();

$container['Zend\Expressive\Router\RouterInterface'] = $router;
$container['JsonMiddleware'] = function() {
    return new JsonMiddleware();
};
$container['HtmlMiddleware'] = function() {
    return new HtmlMiddleware();
};

$appFactory = new ApplicationFactory();
/* @var $app Application */
$app = $appFactory($container);

$app->pipe('JsonMiddleware');
$app->pipe('HtmlMiddleware');

$app->get('/about.{extension}', function(ServerRequestInterface $request, ResponseInterface $response, callable $next) {
    $filledResponse = $response->write(sprintf('About me in %s format', $request->getAttribute('extension')));

    $result = $next($request, $filledResponse);

    if ($result === $filledResponse) {
        return new Response('php://memory', 400);
    }

    return $result;
});



$app->run();