<?php

namespace App\Services;

use App\Core\View;
use App\Core\Session;

class Auth
{

    public static function checkSessionConcurrency()
    {
    }

    public static function checkAuthentication(): bool
    {
        Session::init();
        if (!Session::userIsLoggedIn()) {
            Session::destroy();
            return false;
        }
    }
}