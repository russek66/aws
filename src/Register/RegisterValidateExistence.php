<?php

namespace App\Register;

use App\Core\DatabaseFactory;

class RegisterValidateExistence
{

    public function __construct(
        protected mixed $data,
        private readonly DatabaseFactory $database = new DatabaseFactory()
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
                ':user_name' => $this->data->userName
            )
        );

        $query?->fetch();
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
                ':user_email' => $this->data->userEmail
            )
        );

        $query?->fetch();
        return true;
    }

    public function validateExistence(): bool
    {
        if ($this->validateNameExistence() OR $this->validateEmailExistence()) {
            return true;
        }
        return false;
    }
}