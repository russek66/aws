<?php

namespace App\Register;

use App\Core\DatabaseFactory;
use App\Core\Text;
use App\Enum\RegisterAttemptStatus;

class RegisterValidateExistence
{

    use Text {
        Text::get as getText;
    }

    public function __construct(
        private readonly mixed $object,
        private readonly DatabaseFactory $database = new DatabaseFactory(),
        private bool $validationResult = true,
        private mixed $validationResultMessage = RegisterAttemptStatus::SUCCESS
    )
    {

    }

    public function validateNameExistence(): bool
    {
        $sql = "SELECT 
                    user_id
                FROM 
                    users
                WHERE 
                    user_name = :user_name
                LIMIT 1";

        $query = $this->database
            ?->getFactory()
            ?->getConnection()
            ?->prepare($sql);

        $query?->execute(array(
                ':user_name' => $this->object->userName
            )
        );

        $query?->fetch();
        $this->validationResultMessage = RegisterAttemptStatus::FAILED_USER_EXIST;

        return true;
    }

    public function validateEmailExistence(): bool
    {
        $sql = "SELECT 
                    user_id
                FROM 
                    users
                WHERE 
                    user_email = :user_email
                LIMIT 1";

        $query = $this->database
            ?->getFactory()
            ?->getConnection()
            ?->prepare($sql);

        $query?->execute(array(
                ':user_email' => $this->object->userEmail
            )
        );

        $query?->fetch();
        $this->validationResultMessage = RegisterAttemptStatus::FAILED_EMAIL_EXIST;

        return true;
    }

    public function validateExistence(): RegisterValidateExistence
    {
        if ($this->validateNameExistence() OR $this->validateEmailExistence()) {
            $this->validationResult = false;
        }
        return $this;
    }

    public function getValidationResult(): bool
    {
        return $this->validationResult;
    }

    public function getValidationMessage(): array
    {
        if($this->validationResultMessage === RegisterAttemptStatus::SUCCESS) {
            $msg = [
                'status'    => RegisterAttemptStatus::SUCCESS->name,
                'msg'       => $this->getText('registration',  RegisterAttemptStatus::SUCCESS->value)
            ];
        } else {
            $msg = [
                'status'    => RegisterAttemptStatus::FAILED->name,
                'msg'       => $this->getText('registration',  $this->validationResultMessage->value)
            ];
        }
        return $msg;
    }
}