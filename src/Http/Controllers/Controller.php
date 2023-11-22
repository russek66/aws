<?php

namespace App\Http\Controllers;

use App\Core\View\View;
use App\Services\Auth;

class Controller
{
    protected bool $authStatus;

    public function __construct(protected View $view = new View(), protected Auth $auth = new Auth())
    {
        $this->authStatus = $auth->getAuthStatus();
    }
}
