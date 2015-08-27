<?php

use Interop\Container\Pimple\PimpleInterop;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Application;
use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Router\FastRoute;
use ZendExpressive\Middlewares\JsonMiddleware;

chdir(dirname(__DIR__));

require './vendor/autoload.php';

$container = new PimpleInterop();
$router = new FastRoute();

$container['Zend\Expressive\Router\RouterInterface'] = $router;
$container['JsonMiddleware'] = function() {
    return new JsonMiddleware();
};

$appFactory = new ApplicationFactory();
/* @var $app Application */
$app = $appFactory($container);


$app->pipe('JsonMiddleware');

$app->get('/page/{name}.json', function(ServerRequestInterface $request, ResponseInterface $response, callable $next) {
    $response->write('about me');

    $next($request, $response);
});



$app->run();