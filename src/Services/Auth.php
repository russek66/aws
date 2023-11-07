<?php

namespace App\Services;

use App\Core\{Config, Request, Session};
use App\Login\{Login, LoginWithCookie};

class Auth
{
    private bool $authenticationCookieStatus = true;
    private bool $authenticationStatus = true;
    private bool $concurrencyStatus = true;

    public function __construct
    (
        protected Session $session = new Session(),
        protected Login $login = new Login(),
        protected LoginWithCookie $loginWithCookie = new LoginWithCookie()
    )
    {
        $this->checkAuthentication()
            ->checkCookieAuthentication()
            ->checkSessionConcurrency();
    }

    public function checkSessionConcurrency(): void
    {
        if($this->session->isSessionBroken()){
            $this->login->doLogout();
            $this->concurrencyStatus = false;
        }
    }

    public function checkAuthentication(): Auth
    {
        if (!$this->session->userIsLoggedIn()) {
            $this->session->destroy();
            $this->authenticationStatus = false;
        }
        return $this;
    }

    public function checkCookieAuthentication(): Auth
    {
        $cookie = Request::cookie(Config::get('COOKIE_REMEMBER_ME_NAME'));
        $this->loginWithCookie->setCookie($cookie);

        if (!$this->authenticationStatus AND $cookie) {
            if (!$this->loginWithCookie->doLoginWithCookie()) {
                $this->loginWithCookie->deleteCookie();
                $this->authenticationCookieStatus = false;
            }
        }
        return $this;
    }

    public function getAuthStatus(): bool
    {
        return ($this->concurrencyStatus AND $this->authenticationStatus AND $this->authenticationCookieStatus);
    }
}