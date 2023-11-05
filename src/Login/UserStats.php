<?php

namespace App\Login;

class UserStats
{

    public function __construct(private string $userName)
    {
    }

    public function incFailedLogin(): UserStats
    {
        return $this;
    }

    public function saveFailedLogin(): void
    {

    }
}