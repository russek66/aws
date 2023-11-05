<?php

use App\Login\Login;
use App\Core\{Request, Session};
use App\Http\Controllers\Controller;

class LoginController extends Controller
{


    public function __construct(
        string $methodName,
        mixed $parameters = null,
        private readonly Login $login = new Login()
    )
    {
        parent::__construct();
        if ($this->authStatus) {
            $this->$methodName($parameters);
        }else {
            $this->view->render(filename: "error/blocked");
        }
    }

    public function index(): void
    {
        $this->view->render(filename: 'login/index');
    }

    public function login(): void
    {
        $this->view->render(filename: 'login/login');
        if (!Csrf::isTokenValid()) {
            // logout
        }
        $this->login->doLogin(
            Request::post('user_name'),
            Request::post('user_password'),
            Request::post('set_remember_me_cookie')
        );
    }

    public function logout(): void
    {
        $this->login->doLogout(userId: Session::get('user_id'));
    }
}