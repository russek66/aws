<?php

use App\Core\View;
use App\Http\Controllers\Controller;
use App\Services\Auth;

class LoginController extends Controller
{
    public function __construct(string $methodName, mixed $parameters = null)
    {
        parent::__construct();
        if (!Auth::checkAuthentication()) {
            $this->View->render("error/blocked");
        }else {
            $this->$methodName($parameters);
        }
    }

    public function index():void
    {
        $this->View->render(filename: 'login/index');
    }

    public function login()
    {

    }

    public function loginWithCookie()
    {

    }

    public function logout()
    {

    }
}