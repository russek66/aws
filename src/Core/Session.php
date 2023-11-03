<?php

namespace App\Core;

class Session
{

    public static function init(): void
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
}