<?php

namespace App\Login;

use App\Core\Config;
use App\Core\Session;
use App\User\User;
use App\User\UserData;
use Hybridauth\Exception\Exception;
use Hybridauth\Hybridauth;

class LoginValidate
{

    public function validateUser(
        ?string $userName = null,
        ?string $userPassword = null
    ): bool {
        if ($this->BFCheck()) {
            return false;
        }

        if (empty([$userName, $userPassword])) {
            return false;
        }

        $user = new User(userName: $userName);
        $userStats = new LoginUserStats(userName: $userName);

        if (! $user->getUserIdByName()) {
            $this->incNameNotFound();

            // todo->session->failedLogin
            return false;
        } elseif ($this->loginThrottle($userStats)) {
            return false;
        }
        if (! password_verify($userPassword, $user->getUserPasswordByName())) {
            $userStats->incUserFailedLogin(times: 1);

            return false;
        }

        // todo->session->resetFailedLogin
        return true;
    }

    private function loginThrottle(?LoginUserStats $userStats): bool
    {
        if ($userStats->getFailedLoginTimes() >= 3 OR $userStats->getFailedLoginLastTime() > (time() - $userStats->getFailedLoginTimes() ^ 3)) {
            return true;
        }
        return false;
    }

    private function incNameNotFound(): void
    {
        Session::set(
            key:'failed-login-count',
            param: Session::get(key: 'failed-login-count') + 1
        );
        Session::set(
            key:'last-failed-login',
            param: time()
        );
    }

    private function BFCheck(): bool
    {
        if (Session::get(key: 'failed-login-count') >= 3 OR Session::get(key:'last-failed-login') > (time() - Session::get(key: 'failed-login-count')) ^ 3) {
            return true;
        }
        return false;
    }

}