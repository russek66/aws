<?php

namespace App\DTO;

final readonly class RegisterDTO
{
    public function __construct
    (
        public ?string $userName,
        public ?string $userPassword,
        public ?string $userPasswordRepeat,
        public ?string $userEmail,
        public ?string $userEmailRepeat,
    )
    {
    }



}