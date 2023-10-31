<?php

namespace App\Core;

class Config
{
    public static mixed $config = null;

    public static function get($key)
    {
        if (!self::$config) {

            $configFile = '../config/config.' . Environment::get() . '.php';

            if (!file_exists($configFile)) {
                return false;

                //TO DO -> Throw error, log it and show Error page
            }

            self::$config = require $configFile;
        }

        return self::$config[$key];
    }
}