<?php


// [START index_php]
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/vendor/autoload.php';

define("BASEPATH", __DIR__);

$app = new App\Application('prod');
Request::enableHttpMethodParameterOverride();
// @codeCoverageIgnoreStart
if (PHP_SAPI != 'cli') {
    $app->run();
}
// @codeCoverageIgnoreEnd

return $app;
// [END index_php]
