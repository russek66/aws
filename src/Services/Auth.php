<?php

namespace App\Services;

use App\Core\Session;

class Auth
{
    private bool $authenticationStatus = true;
    private bool $concurrencyStatus = true;

    public function __construct()
    {
        $this->checkAuthentication()->checkSessionConcurrency();
    }

    public function checkSessionConcurrency(): void
    {
        if(Session::isSessionBroken()){
            LoginModel::logout();
            $this->concurrencyStatus = false;
        }
    }

    public function checkAuthentication(): Auth
    {
        if (!Session::userIsLoggedIn()) {
            Session::destroy();
            $this->authenticationStatus = false;
        }
        return $this;
    }

    public function getAuthStatus(): bool
    {
        return ($this->concurrencyStatus && $this->authenticationStatus);
    }
}