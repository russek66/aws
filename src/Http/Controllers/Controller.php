<?php

namespace App\Http\Controllers;

use App\Core\{View, Session};
use App\Services\Auth;

class Controller
{
    public function __construct(public View $View = new View())
    {
        Session::init();
//        if (!Session::userIsLoggedIn() AND Request::cookie('remember_me')) {
//
//        }
    }
}
