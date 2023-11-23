<?php

namespace App\Core\Session;


use App\Core\Filter;
use App\Login\LoginSocialValidate;

trait SessionUsage
{
    use Filter;

    public function userIsLoggedIn(): bool
    {
        $loginValidate = new LoginSocialValidate();
        $validationResult = $loginValidate->validateSocialUser(
            userId: $this->get(key: 'user_id'),
            provider: $this->get(key: 'provider'));

        if (!$validationResult) {
            return false;
        }
        return true;
    }

    public function isSessionBroken(): bool
    {
        return false;
    }

    public function updateSessionId(string $userId): void
    {
    }

    public function get(string $key): ?string
    {
        if (isset($_SESSION[$key])) {
            return $this->XSSFilter($_SESSION[$key]);
        }
        return null;
    }

    public function set(string $key, int|string|null $param): void
    {
        $_SESSION[$key] = $param;
    }

    public static function add(string $key, $value): void
    {
        $_SESSION[$key][] = $value;
    }
}