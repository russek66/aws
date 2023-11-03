<?php

namespace App\Core;

class Request
{

    public static function get(mixed $key):mixed
    {
        if (isset($_GET[$key])) {
            return $_GET[$key];
        }
        return "login/index";
    }

    public static function post(mixed $key):void
    {

    }

    public static function cookie($key)
    {
        if (isset($_COOKIE[$key])) {
            return $_COOKIE[$key];
        }
    }
}