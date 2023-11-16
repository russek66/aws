<?php

namespace App\Core;

class Session
{

    public function __construct()
    {
        $this->init();
    }

    public function init(): void
    {
        if (session_id() == '') {
            session_start();
        }
    }

    public static function destroy(): void
    {
        session_destroy();
    }

    public static function userIsLoggedIn(): bool
    {
        return false;
    }

    public static function isSessionBroken(): bool
    {
        return false;
    }

    public static function updateSessionId(string $userId): void
    {
    }

    public static function get(string $key): ?string
    {
        if (isset($_SESSION[$key])) {
            return Filter::XSSFilter($_SESSION[$key]);
        }
    }

    public static function set(string $key, int|string|null $param): void
    {
        $_SESSION[$key] = $param;
    }

    public static function add(string $key, $value): void
    {
        $_SESSION[$key][] = $value;
    }
}