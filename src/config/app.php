<?php

return [
    'database' => [
        'driver' => 'mysql',
        'host' => $_ENV['host'],
        'database' => $_ENV['database'],
        'username' => $_ENV['username'],
        'password' => $_ENV['password'],
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ],
];