<?php

namespace App\Register;

use App\Core\DatabaseFactory;
use DateTime;

class RegisterNewUser
{

    public function __construct(
        private readonly mixed $data,
        public bool $registrationResult = true,
        private readonly DatabaseFactory $database = new DatabaseFactory()
    )
    {
        $this->generateHash();

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

        $query->execute(array('
            :user_name' => $this->data->userName,
            ':user_password_hash' => $this->data->userPasswordHash,
            ':user_email' => $this->data->userEmail,
            ':user_creation_timestamp' => time(),
            ':user_activation_hash' => $this->data->userActivationHash,
            ':user_activation_expiry' => (new DateTime('+1 day'))->format('Y-m-d H:i:s'),
            ':user_provider_type' => 'DEFAULT'));

        if ($query->rowCount() <=> 1) {
            $this->registrationResult =  false;
        }
    }

    private function generateHash(): void
    {
        $this->data->userPasswordHash = password_hash($this->data->userPassword, PASSWORD_DEFAULT);
        $this->data->userActivationHash = sha1(random_int(PHP_INT_MIN, PHP_INT_MAX));
    }
}