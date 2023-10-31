<?php

namespace App\Core;

class ErrorView
{

    public function renderError(string $error):void
    {
        require Config::get(key: 'ERROR_PATH_VIEW') .  $error . '.php';
    }
}