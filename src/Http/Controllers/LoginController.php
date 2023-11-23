<?php

use App\Login\Login;
use App\Login\LoginSocial;
use App\Core\{Csrf, Request, Session};
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    use Request;

    public function __construct(
        string $methodName,
        mixed $parameters = null,
        private readonly Login $login = new Login(),
        private readonly LoginSocial $loginSocial = new LoginSocial()
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
        if (!(new Csrf())->validateToken()) {
            $this->logout();
        }
        $this->login->doLogin(
            $this->post('user_name'),
            $this->post('user_password'),
            $this->post('set_remember_me_cookie')
        );
    }

    public function loginSocial(): void
    {
        $this->view->render(filename: 'login/social');
        $this->loginSocial->doLoginSocial();
    }

    public function logout(): void
    {
        $this->login->doLogout();
        $this->loginSocial->doLogout();
    }
}