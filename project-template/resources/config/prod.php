<?php

// Doctrine: DB options
//$app['db.options'] = array(
//    'driver' => 'pdo_sqlite',
//    'path' => __DIR__.'/../../var/database.dat',
//);


$_config = array(
    'tablePrefix' => '',
    'globalSalt' => 'someSalt',

    'dateFormatDb' => 'Y-m-d',

    'languages' => array(
        "en" => "English",
//        "id" => "Indonesia"
    ),
    'defaultLanguage' => "en",

    'dbConfig' => array(
        'type' => 'mysql', // or pgsql
        'host' => '127.0.0.1',
        'port' => 3306,
        'username' => 'username',
        'password' => 'password',
        'dbName' => 'database',
        'directory' => 'databaseDirectory'
    ),

    'smtp' => array(
        'host' => 'smtp.website.com',
        'username' => 'mail@email.com',
        'password' => '',
        'port' => '465',
        'encryption' => 'ssl',
        'auth_mode' => null,
        'senderEmail' => 'mail@email.com'
    )
);