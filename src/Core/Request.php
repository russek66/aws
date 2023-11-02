<?php

namespace App\Core;

class Request
{

    public static function get(mixed $key): mixed{
        if (isset($_GET[$key])) {
            return $_GET[$key];
        }
        return "index/showIndex/42";
    }
}