<?php

use Interop\Container\Pimple\PimpleInterop;

$container = new PimpleInterop();

require __DIR__.'/services.php';

return $container;