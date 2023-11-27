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
        if (empty($this->data->userEmail)) {
            $this->validationResult = false;
        }
        if ($this->data->userEmail !== $this->data->userEmailRepeat) {
            $this->validationResult = false;
        }
        if (!filter_var($this->data->userEmail, FILTER_VALIDATE_EMAIL)) {
            $this->validationResult = false;
        }

        return $this;
    }

    public function validateUserPassword(): RegisterValidateData
    {
        if (empty($this->data->userPassword) OR empty($this->data->userPasswordRepeat)) {
            $this->validationResult = false;
        }

        if ($this->data->userPassword !== $this->data->userPasswordRepeat) {
            $this->validationResult = false;
        }

        if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $this->data->userPassword)) {
            $this->validationResult = false;
        }

        return $this;
    }

    public function getValidationResult(): bool
    {
        return $this->validationResult;
    }
}