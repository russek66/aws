<?php

namespace App\Login;

use App\Core\Session;
use App\User\User;

class LoginValidate
{

    public function validateUser(?string $userName, ?string $userPassword): bool
    {
        if ($this->BFCheck()) {
            return false;
        }

        if (empty([$userName, $userPassword])) {
            return false;
        }
        
        $user = new User(userName: $userName);
        $userStats = new UserStats(userName: $userName);

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

    private function loginThrottle(?UserStats $userStats): bool
    {
        if ($userStats->getFailedLoginTimes() >= 3 OR $userStats->getFailedLoginLastTime() > (time() - $userStats->getFailedLoginTimes() ^ 3)) {
            return true;
        }
        return false;
    }

    private function incNameNotFound(): void
    {
        Session::set(
            'failed-login-count',
            Session::get('failed-login-count') + 1
        );
        Session::set('last-failed-login', time());
    }

    private function BFCheck(): bool
    {
        if (Session::get('failed-login-count') >= 3 OR Session::get('last-failed-login') > (time() - Session::get('failed-login-count')) ^ 3) {
            Session::add('feedback_negative',Text::get('FEEDBACK_LOGIN_FAILED_3_TIMES'));
            return true;
        }
        return false;
    }
}