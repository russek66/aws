<?php

namespace App\Register;

use App\Core\DatabaseFactory;
use App\DataTransfer\RegisterDTO;
use App\Enum\RegisterAttemptStatus;
use App\Register\Helper\PasswordHash;
use DateTime;

class RegisterNewUser implements NewUserInterface
{
    use PasswordHash;

    public function __construct(
        private readonly RegisterDTO $RDTO,
        private bool $result = true,
        private mixed $resultMessage = RegisterAttemptStatus::SUCCESS,
        private readonly DatabaseFactory $database = new DatabaseFactory()
    )
    {
        $this->registerUser();
    }

    public function registerUser(): void
    {
        $sql = "INSERT INTO users (
                    user_name, 
                    user_password_hash, 
                    user_email, 
                    user_creation_timestamp, 
                    user_activation_hash, 
                    user_activation_expiry,
                    user_provider_type)
                VALUES (
                    :user_name, 
                    :user_password_hash, 
                    :user_email, 
                    :user_creation_timestamp, 
                    :user_activation_hash, 
                    :user_activation_expiry,
                    :user_provider_type)";

        $query = $this->database
            ?->getFactory()
            ?->getConnection()
            ?->prepare($sql);

        $query->execute([
            ':user_name' => $this->RDTO->userName,
            ':user_password_hash' => $this->RDTO->userPassword,
            ':user_email' => $this->RDTO->userEmail,
            ':user_creation_timestamp' => time(),
            ':user_activation_hash' =>  $this->RDTO->userActivationHash,
            ':user_activation_expiry' => (new DateTime('+1 day'))->format('Y-m-d H:i:s'),
            ':user_provider_type' => 'DEFAULT'
        ]);

        if ($query->rowCount() <=> 1) {
            $this->result =  false;
            $this->resultMessage = RegisterAttemptStatus::FAILED_EMAIL_SEND;
        }
    }
}