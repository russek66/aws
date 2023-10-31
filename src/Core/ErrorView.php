<?php

namespace App\Core;

class ErrorView
{

    public function renderError(string $error):void
    {
        require Config::get(key: 'PATH_VIEW') . 'error/' . $error . '.php';
    }
}