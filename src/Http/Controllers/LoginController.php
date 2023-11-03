<?php


use App\Http\Controllers\Controller;

class LoginController extends Controller
{

    public function __construct(string $methodName, mixed $parameters = null)
    {
        parent::__construct();
        if ($this->authStatus) {
            $this->$methodName($parameters);
        }else {
            $this->view->render("error/blocked");
        }
    }

    public function index():void
    {
        $this->view->render(filename: 'login/index');
    }

    public function login()
    {

    }

    public function loginWithCookie()
    {
        $login_successful = LoginModel::loginWithCookie(Request::cookie('remember_me'));
        if ($login_successful) {
            Redirect::to('dashboard/index');
        } else {
            LoginModel::deleteCookie();
            Redirect::to('login/index');
        }
    }

    public function logout()
    {

    }
}