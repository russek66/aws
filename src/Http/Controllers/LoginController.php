<?php


use App\Http\Controllers\Controller;
use App\Services\Auth;

class LoginController extends Controller
{
    public function __construct(string $methodName, mixed $parameters = null)
    {
        parent::__construct();

        if ((new Auth())->getAuthStatus()) {
            $this->$methodName($parameters);
        }else {
            $this->View->render("error/blocked");
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