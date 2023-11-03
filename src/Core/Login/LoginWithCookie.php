<?php

namespace App\Core\Login;

class LoginWithCookie
{
    private mixed $cookie;

    public function doLoginWithCookie(): bool
    {
        if (!$this->cookie) {
            return false;
        }
    }

    public function deleteCookie()
    {

    }

    public function setCookie(mixed $cookie): void
    {
        $this->cookie = $cookie;
    }
}