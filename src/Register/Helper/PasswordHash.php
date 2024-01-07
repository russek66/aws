<?php

namespace App\Register\Helper;

trait PasswordHash
{

    private function generateHash(string $userPassword): string
    {
        return password_hash($userPassword, PASSWORD_DEFAULT);

    }

    private function generateActivationHash(): string
    {
        return sha1(random_int(PHP_INT_MIN, PHP_INT_MAX));
    }
}