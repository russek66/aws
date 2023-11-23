<?php

namespace App\Core;

trait Request
{

    public function get(mixed $key):mixed
    {
        if (isset($_GET[$key])) {
            return $_GET[$key];
        }
        return "index/index";
    }

    public function post(mixed $key): mixed
    {

    }

    public function cookie(string $key): mixed
    {
        if (isset($_COOKIE[$key])) {
            return $_COOKIE[$key];
        }
        return false;
    }
}