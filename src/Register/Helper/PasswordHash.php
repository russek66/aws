<?php

namespace App\Register\Helper;

trait PasswordHash
{
    /**
     * Generates hash from given password and random activation hash.
     */
    private function generateHash(string $userPassword): array
    {
        $userPassword = password_hash($userPassword, PASSWORD_DEFAULT);
        $userActivationHash = sha1(random_int(PHP_INT_MIN, PHP_INT_MAX));

        return [
            'passwordHash' => $userPassword,
            'activationHash' => $userActivationHash
        ];
    }
}