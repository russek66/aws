<?php

namespace App\Core\View;

use App\Core\Config;

class ViewError
{
    use Config;

    public function renderError(string $error):void
    {
        require $this->get(key: 'ERROR_PATH_VIEW') . $error . '.php';
    }

    public function renderFatalError(string $error):void
    {
        require $this->get(key: 'ERROR_PATH_VIEW') . $error . '.php';
    }
}