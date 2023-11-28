<?php

namespace App\Register;

class RegisterValidateData
{

    public function __construct(
        private readonly mixed $data,
        private bool $validationResult = true
    )
    {

    }


    public function validateData(): RegisterValidateData
    {
        $this->validateUserName()
            ->validateUserPassword()
            ->validateUserEmail();

        return $this;
    }

    public function validateUserName(): RegisterValidateData
    {

        if (!preg_match('/^[a-z]\w{6,23}[^_]$/i', $this->data['user_name']) OR empty($this->data['user_name'])) {
            $this->validationResult = false;
        }
        return $this;
    }

    public function validateUserEmail(): RegisterValidateData
    {
        if (empty($this->data['user_email'])) {
            $this->validationResult = false;
        }
        if ($this->data['user_email'] !== $this->data['user_email_repeat']) {
            $this->validationResult = false;
        }
        if (!filter_var($this->data['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->validationResult = false;
        }

        return $this;
    }

    public function validateUserPassword(): RegisterValidateData
    {
        if (empty($this->data['user_password']) OR empty($this->data['user_password_repeat'])) {
            $this->validationResult = false;
        }

        if ($this->data['user_password'] !== $this->data['user_password_repeat']) {
            $this->validationResult = false;
        }

        if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $this->data['user_password'])) {
            $this->validationResult = false;
        }

        return $this;
    }

    public function getValidationResult(): bool
    {
        return $this->validationResult;
    }
}