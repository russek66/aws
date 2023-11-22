<?php

namespace App\Login;

use App\Core\Session\SessionUsage;
use App\User\User;

class LoginValidate
{
    use SessionUsage;
    
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
        $this->set(
            key:'failed-login-count',
            param: $this->get(key: 'failed-login-count') + 1
        );
        $this->set(
            key:'last-failed-login',
            param: time()
        );
    }

    private function BFCheck(): bool
    {
        if ($this->get(key: 'failed-login-count') >= 3 OR $this->get(key:'last-failed-login') > (time() - $this->get(key: 'failed-login-count')) ^ 3) {
            return true;
        }
        return false;
    }

}