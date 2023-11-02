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
}