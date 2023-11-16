<?php

namespace App\Core;

use App\Core\Request;
use App\Core\Session;

class Csrf
{
    public static function makeToken(): ?string
    {
        $maxTime    = 60 * 60 * 24;
        $storedTime = Session::get('csrf_token_time');
        $csrfToken  = Session::get('csrf_token');

        if ($maxTime + $storedTime <= time() || empty($csrfToken)) {
            Session::set('csrf_token', bin2hex(random_bytes(50)));
            Session::set('csrf_token_time', time());
        }

        return Session::get('csrf_token');
    }

    public static function isTokenValid(): bool
    {
        $token = Request::post('csrf_token');
        return $token === Session::get('csrf_token') && !empty($token);
    }
}