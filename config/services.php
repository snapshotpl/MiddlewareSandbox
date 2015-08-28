<?php

use Psr\Log\NullLogger;
use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Router\FastRoute;
use ZendExpressive\Middlewares\HtmlMiddleware;
use ZendExpressive\Middlewares\JsonMiddleware;
use ZendExpressive\Middlewares\LogRequestMiddleware;
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

$container['NoneHtmlResponseAsHtmlMiddleware'] = function () {
    return new NoneHtmlResponseAsHtmlMiddleware();
};
