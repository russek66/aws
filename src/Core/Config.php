<?php

namespace App\Core;

use App\Http\Controllers\ErrorController;

trait Config
{
    public mixed $config = null;

    public function get($key): mixed
    {
        if (!$this->config) {
            $configFile = '../config/config.' . Environment::get() . '.php';
            if (!file_exists($configFile)) {
//                (new ErrorController())->fatalError(message: 'FATAL_ERROR_PAGE_NOT_FOUND', errorPage: '404');
                return false;
            }
            $this->config = require $configFile;
        }
        return $this->config[$key];
    }
}