<?php

namespace App\Register;

use App\Core\DatabaseFactory;
use App\Register\Helper\PasswordHash;
use DateTime;

class RegisterNewUserSocial implements NewUserInterface
{
    use PasswordHash;

    public function __construct(
        private readonly mixed $data,
        public bool $registrationResult = true,
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
            '
        :user_name' => $this->data->userName,
            ':user_password_hash' => $this->generateHash($this->data->userPassword),
            ':user_email' => $this->data->userEmail,
            ':user_creation_timestamp' => time(),
            ':user_activation_hash' => $this->data->userActivationHash,
            ':user_activation_expiry' => (new DateTime('+1 day'))->format(
                'Y-m-d H:i:s'),
            ':user_provider_type' => 'DEFAULT'
        ]);

        if ($query->rowCount() <=> 1) {
            $this->registrationResult = false;
        }
    }
}