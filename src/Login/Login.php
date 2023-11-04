<?php

namespace App\Login;

use App\Core\Session;

class Login
{

    public function doLogin(
        ?string $userName,
        ?string $userPassword,
        bool $rememberMeCookie
    )
    {

    }

    public function doLogout(string $userId): bool
    {
        $this->deleteCookie($userId);
        Session::destroy();
        Session::updateSessionId($userId);
    }

    private function deleteCookie(string $userId)
    {
    }
}