<?php

namespace App\Register;

class RegisterData
{

    public function __construct(
        private mixed $data,
    )
    {
        $this->filterData($this->data)
            ->validateData();
    }

    private function validateData(): void
    {

    }

    private function filterData($data): RegisterData
    {
        foreach ($data as $key => $value) {
            $data[$key] = trim($value);
            $data[$key] = stripslashes($data[$key]);
            $data[$key] = strip_tags($data[$key]);
        }

        $this->data = $data;
        return $this;
    }

    public function validateUserName(): bool
    {

        if (!preg_match('/^[a-zA-Z0-9]{2,64}$/', $this->data->username) OR empty($this->data->username)) {
            return false;
        }

        return true;
    }

    public function validateUserEmail(): bool
    {
        if (empty($this->data->userEmail)) {
            return false;
        }
        if ($this->data->userEmail !== $this->data->userEmailRepeat) {
            return false;
        }
        if (!filter_var($this->data->userEmail, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    public function validateUserPassword(): bool
    {
        if (empty($this->data->userPassword) OR empty($this->data->userPasswordRepeat)) {
            return false;
        }

        if ($this->data->userPassword !== $this->data->userPasswordRepeat) {
            return false;
        }

        if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $this->data->userPassword)) {
            return false;
        }

        return true;
    }
}