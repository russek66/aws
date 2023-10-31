<?php

class Config
{
    public static mixed $config;

    public static function get($key)
    {
        if (!self::$config) {

            $configFile = '../application/config/config.' . Environment::get() . '.php';

            if (!file_exists($configFile)) {
                return false;
            }

            self::$config = require $configFile;
        }

        return self::$config[$key];
    }
}