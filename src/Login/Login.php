<?php

namespace App\Login;

use App\Core\Config;
use App\Core\Request;
use App\Core\Session;
use App\User\User;

class Login
{

    public function doLogin(
        ?string $userName,
        ?string $userPassword,
        ?bool $rememberMeCookie = null,
        LoginValidate $loginValidate = new LoginValidate()
    ): bool
    {
        $validationResult = $loginValidate->validateUser(userName: $userName, userPassword: $userPassword);
        if (!$validationResult) {
            return false;
        }

        return true;
    }

    public function doLogout(): bool
    {
        $userId = Session::get(key: 'user_id');

        $this->deleteCookie($userId);
        Session::destroy();
        Session::updateSessionId($userId);
        return true;
    }

    private function deleteCookie(?string $userId): void
    {
        if ($userId ?? false) {
            (new User(userId: $userId))
                ->deleteRememberedUserById();
        }

        (new LoginWithCookie())
            ->setCookie(Request::cookie(Config::get('COOKIE_REMEMBER_ME_NAME')))
            ->deleteCookie();
    }
}