<?php

namespace App\Login;

use App\Core\Session;
use App\User\User;

class Login
{

    public function doLogin(
        ?string $userName,
        ?string $userPassword,
        ?bool $rememberMeCookie = null
    ): bool
    {
        if (empty($userName) OR empty($userPassword)) {
            return false;
        }
        $validationResult = $this->validateUser(userName: $userName, userPassword: $userPassword);
        if (!$validationResult) {
            return false;
        }

        return true;
    }

    public function doLogout(string $userId): bool
    {
        $this->deleteCookie($userId);
        Session::destroy();
        Session::updateSessionId($userId);
        return true;
    }

    private function deleteCookie(string $userId)
    {
    }

    private function validateUser(string $userName, string $userPassword): bool
    {
        $user = new User(userName: $userName);
        if (!$user->getUserIdByName()) {
            (new UserStats(userName: $userName))
                ->incFailedLogin()
                ->saveFailedLogin();
        }
        $user->getUsernamePasswordByName(userName: $userName);

        return true;
    }
}