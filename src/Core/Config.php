<?php

namespace App\Core;

use App\Http\Controllers\ErrorController;

class Config
{
    public static mixed $config = null;

    public static function get($key)
    {
        if (!self::$config) {

            $configFile = '../config/config.' . Environment::get() . '.php';

            if (!file_exists($configFile)) {
                (new ErrorController)->fatalError(message: 'FATAL_ERROR_PAGE_NOT_FOUND', errorPage: '404');
            }

            self::$config = require $configFile;
        }

        return self::$config[$key];
    }
}