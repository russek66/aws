<?php

namespace App\Register;

class Register
{

    public function __construct(
        public mixed $data,
        public mixed $response = null
    )
    {
        $this->validateData();
    }

    public function validateData(): mixed
    {
        new RegisterData($this->data);
    }
}