<?php

// include the prod configuration
require __DIR__.'/prod.php';

// enable the debug mode
$app['debug'] = true;

$_config['dbConfig'] = array(
    'type' => 'mysql',
    'host' => 'localhost',
    'port' => 3306,
    'username' => 'username',
    'password' => '',
    'dbName' => 'database',
    'directory' => 'databaseDirectory'
);