<?php

namespace App\Core\Login;

use App\Core\Config;

class LoginWithCookie
{
    private mixed $cookie;

    public function doLoginWithCookie(): bool
    {
        if (!$this->cookie) {
            return false;
        }
    }

    public function deleteCookie(): void
    {
        setcookie(
            Config::get('COOKIE_REMEMBER_NAME'),
            false,
            time() - (3600 * 24 * 3650),
            Config::get('COOKIE_PATH'),
            Config::get('COOKIE_DOMAIN'),
            Config::get('COOKIE_SECURE'),
            Config::get('COOKIE_HTTP')
        );
    }

    public function setCookie(mixed $cookie): void
    {
        $this->cookie = $cookie;
    }
}