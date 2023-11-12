<?php

namespace App\Register;

use App\Core\DatabaseFactory;

class RegisterSaveNewUser
{

    public function __construct(
        private readonly mixed $data,
        public bool $registrationResult = true,
        private readonly DatabaseFactory $database = new DatabaseFactory()
    )
    {
        $sql = "INSERT INTO users (
                    user_name, 
                    user_password_hash, 
                    user_email, 
                    user_creation_timestamp, 
                    user_activation_hash, 
                    user_provider_type)
                VALUES (
                    :user_name, 
                    :user_password_hash, 
                    :user_email, 
                    :user_creation_timestamp, 
                    :user_activation_hash, 
                    :user_provider_type)";

        $query = $this->database
            ?->getFactory()
            ?->getConnection()
            ?->prepare($sql);

        $query->execute(array('
            :user_name' => $this->data->userName,
            ':user_password_hash' => $this->data->userPasswordHash,
            ':user_email' => $this->data->userEmail,
            ':user_creation_timestamp' => $this->data->userCreationTimestamp,
            ':user_activation_hash' => $this->data->userActivationHash,
            ':user_provider_type' => 'DEFAULT'));

        if ($query->rowCount() <=> 1) {
            $this->registrationResult =  false;
        }
    }
}