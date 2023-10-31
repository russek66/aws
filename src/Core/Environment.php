<?php

namespace App\Core;

class Environment
{
    public static function get():string
    {
        return (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : "development");
    }
}
