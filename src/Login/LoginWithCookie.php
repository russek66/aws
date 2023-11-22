<?php

namespace App\Login;

use App\Core\Config;

class LoginWithCookie
{
    use Config;

    private mixed $cookie;

    public function doLoginWithCookie(): bool
    {
        if (!$this->cookie) {
            return false;
        }
        return true;
    }

    public function deleteCookie(): void
    {
        setcookie(
            $this->cookie,
            false,
            time() - (3600 * 24 * 3650),
            $this->get('COOKIE_PATH'),
            $this->get('COOKIE_DOMAIN'),
            $this->get('COOKIE_SECURE'),
            $this->get('COOKIE_HTTP')
        );
    }

    public function setCookie(mixed $cookie): LoginWithCookie
    {
        $this->cookie = $cookie;
        return $this;
    }
}