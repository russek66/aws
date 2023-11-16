<?php

namespace App\Core;

class Csrf
{
    public function __construct()
    {

    }

    public function generateToken(): ?string
    {
        $maxTime    = 60 * 60 * 24;
        $storedTime = Session::get(key:'csrf_token_time');
        $csrfToken  = Session::get(key:'csrf_token');

        if ($maxTime + $storedTime <= time() || empty($csrfToken)) {
            Session::set(key:'csrf_token', param: bin2hex(random_bytes(50)));
            Session::set(key:'csrf_token_time', param: time());
        }

        return Session::get(key:'csrf_token');
    }

    public function validateToken(): bool
    {
        $token = Request::post('csrf_token');
        return $token === Session::get(key:'csrf_token') && !empty($token);
    }
}