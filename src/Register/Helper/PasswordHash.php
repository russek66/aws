<?php

namespace App\Register\Helper;

trait PasswordHash
{
    private function generateHash(string $userPassword): array
    {
        $userPassword = password_hash($userPassword, PASSWORD_DEFAULT);
        $userActivationHash = sha1(random_int(PHP_INT_MIN, PHP_INT_MAX));

        return [
            $userPassword,
            $userActivationHash
        ];
    }
}