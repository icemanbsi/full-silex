<?php

/** RUN DEBUG SERVER :
 *  php -S localhost:8080 -t / index_dev.php
 */

// [START index_php]
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/vendor/autoload.php';

define("BASEPATH", __DIR__);

Symfony\Component\Debug\Debug::enable();

$app = new App\Application('dev');
Request::enableHttpMethodParameterOverride();
// @codeCoverageIgnoreStart
if (PHP_SAPI != 'cli') {
    $app->run();
}
// @codeCoverageIgnoreEnd

return $app;
// [END index_php]
