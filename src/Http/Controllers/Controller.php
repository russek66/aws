<?php

namespace App\Http\Controllers;

use Exception;
use App\Core\{View, Session};
use App\Services\Auth;

class Controller
{
    public function __construct(public View $View = new View())
    {
        Session::init();
        Auth::checkSessionConcurrency();
    }
}
