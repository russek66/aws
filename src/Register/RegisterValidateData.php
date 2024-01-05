<?php

namespace App\Register;

use App\Core\Text;
use App\DataTransfer\RegisterDTO;
use App\Enum\RegisterAttemptStatus;

class RegisterValidateData
{

    use Text {
        Text::get as getText;
    }

    public function __construct(
        private readonly RegisterDTO $RDTO,
        private bool $result = true,
        private mixed $resultMessage = RegisterAttemptStatus::SUCCESS
    )
    {

    }

    public function validateData(): RegisterValidateData
    {
        return $this->validateUserName()
            ?->validateUserPassword()
            ?->validateUserEmail();
    }

    public function validateUserName(): ?RegisterValidateData
    {

        if (!preg_match('/^[a-z]\w{6,23}[^_]$/i', $this->RDTO->userName) OR empty($this->RDTO->userName)) {
            $this->result = false;
            $this->resultMessage = RegisterAttemptStatus::FAILED_USER;
            return null;
        }
        return $this;
    }

    public function validateUserEmail(): ?RegisterValidateData
    {
        if (empty($this->RDTO->userEmail)) {
            $this->result = false;
            $this->resultMessage = RegisterAttemptStatus::FAILED_EMPTY_EMAIL;
            return null;
        }

        if ($this->RDTO->userEmail !== $this->RDTO->userEmailRepeat) {
            $this->result = false;
            $this->resultMessage = RegisterAttemptStatus::FAILED_EMAIL_REPEAT_WRONG;
            return null;
        }

        if (!filter_var($this->RDTO->userEmail, FILTER_VALIDATE_EMAIL)) {
            $this->result = false;
            $this->resultMessage = RegisterAttemptStatus::FAILED_INVALID_EMAIL_FORMAT;
            return null;
        }

        return $this;
    }

    public function validateUserPassword(): ?RegisterValidateData
    {
        if (empty($this->RDTO->userPassword) OR empty($this->RDTO->userPasswordRepeat)) {
            $this->result = false;
            $this->resultMessage = RegisterAttemptStatus::FAILED_EMPTY_PASSWORD;
            return null;
        }

        if ($this->RDTO->userPassword !== $this->RDTO->userPasswordRepeat) {
            $this->result = false;
            $this->resultMessage = RegisterAttemptStatus::FAILED_PASSWORD_REPEAT_WRONG;
            return null;
        }

        if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $this->RDTO->userPassword)) {
            $this->result = false;
            $this->resultMessage = RegisterAttemptStatus::FAILED_INVALID_PASSWORD_FORMAT;
            return null;
        }

        return $this;
    }
}