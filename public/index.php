<?php

require_once __DIR__.'/../vendor/autoload.php';

use App\Core\Application;

putenv('APPLICATION_ENV=local');

error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('session.cookie_httponly', 1);

(new Application([
    'uri' => $_SERVER['REQUEST_URI'],
    'method' => $_SERVER['REQUEST_METHOD']
]
))->run();