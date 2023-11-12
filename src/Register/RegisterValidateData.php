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

    public function validateData(): bool
    {
        $this->validateUserName()
            ->validateUserPassword()
            ->validateUserEmail();

        return $this->validationResult;
    }

    public function validateUserName(): RegisterValidateData
    {

        if (!preg_match('/^[a-zA-Z0-9]{2,64}$/', $this->data->username) OR empty($this->data->username)) {
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
}