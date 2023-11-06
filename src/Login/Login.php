<?php

namespace App\Login;

use App\Core\Config;
use App\Core\DatabaseFactory;
use App\Core\Request;
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

    public function doLogout(): bool
    {
        $userId = Session::get('user_id');

        $this->deleteCookie($userId);
        Session::destroy();
        Session::updateSessionId($userId);
        return true;
    }

    private function deleteCookie(string $userId)
    {
        // todo->fixLogic
        if (isset($userId)) {
            (new User())->getUserNameById($userId);
            (new User())->deleteRememberedUserById($userId);
        }

        (new LoginWithCookie())
            ->setCookie(Request::cookie(Config::get('COOKIE_REMEMBER_ME_NAME')))
            ->deleteCookie();
    }

    private function validateUser(string $userName, string $userPassword): bool
    {
        $user = new User(userName: $userName);
        $userStats = new UserStats(userName: $userName);
        if (!$user->getUserIdByName()) {
            // todo->session->failedLogin
            return false;
        } elseif ($this->loginThrottle($userStats)) {
            // todo->session->failedLogin
            return false;
        }
        if (!password_verify($userPassword, $user->getUserPasswordByName())) {
            $userStats->incUserFailedLogin(times: 1);
            return false;
        }
        // todo->session->resetFailedLogin
        return true;
    }

    private function loginThrottle(UserStats $userStats): bool
    {
        if ($userStats->getFailedLoginTimes() >=3){
            if ($userStats->getFailedLoginLastTime() > (time() - $userStats->getFailedLoginTimes() ^ 3)) {
                return true;
            }
        }
        return false;
    }
}