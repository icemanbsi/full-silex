<?php

/** RUN DEBUG SERVER :
 *  php -S localhost:8080 -t / index_dev.php
 */
use Symfony\Component\HttpFoundation\Request;


function startApp(){
    require_once __DIR__ . '/vendor/autoload.php';

    define("BASEPATH", __DIR__);

    Symfony\Component\Debug\Debug::enable();

    $app = new App\Application('dev');
    Request::enableHttpMethodParameterOverride();

    if (PHP_SAPI != 'cli') {
        $app->run();
        return $app;
    }
    else{
        return false;
    }
}

//router
if (preg_match('/\.css|\.js|\.jpg|\.png|\.map|\.ttf|\.woff$/', $_SERVER['REQUEST_URI'], $match)) {
    $mimeTypes = [
        '.css' => 'text/css',
        '.js'  => 'application/javascript',
        '.jpg' => 'image/jpg',
        '.png' => 'image/png',
        '.woff' => 'application/font-woff',
        '.ttf' => 'application/font-sfnt',
        '.svg' => 'image/svg+xml',
        '.map' => 'application/json'
    ];
    $path = __DIR__ . $_SERVER['SCRIPT_NAME'];
    if (is_file($path)) {
        header("Content-Type: {$mimeTypes[$match[0]]}");
        require $path;
        exit;
    }
}
startApp();
