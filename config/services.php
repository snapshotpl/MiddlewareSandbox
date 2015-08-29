<?php

use Psr\Log\NullLogger;
use Slim\HttpCache\Cache;
use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Router\FastRoute;
use ZendExpressive\Middlewares\HtmlMiddleware;
use ZendExpressive\Middlewares\JsonMiddleware;
use ZendExpressive\Middlewares\LogRequestMiddleware;
use ZendExpressive\Middlewares\LogRequestResponseMiddleware;
use ZendExpressive\Middlewares\LogResponseMiddleware;
use ZendExpressive\Middlewares\NoneHtmlResponseAsHtmlMiddleware;

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

$container['logger'] = function () {
    return new NullLogger();
};

$container['LogRequestMiddleware'] = function ($dic) {
    return new LogRequestMiddleware($dic['logger']);
};

$container['LogResponseMiddleware'] = function ($dic) {
    return new LogResponseMiddleware($dic['logger']);
};

$container['LogRequestResponseMiddleware'] = function ($dic) {
    $logRequest = $dic['LogRequestMiddleware'];
    $logResponse = $dic['LogResponseMiddleware'];

    return new LogRequestResponseMiddleware($logRequest, $logResponse);
};

$container['NoneHtmlResponseAsHtmlMiddleware'] = function () {
    return new NoneHtmlResponseAsHtmlMiddleware();
};

$container['HttpCacheMiddleware'] = function () {
    return new Cache();
};
