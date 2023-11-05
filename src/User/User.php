<?php

namespace App\User;

use App\Core\DatabaseFactory;

class User
{

    public function __construct(
        private readonly string $userName,
        private readonly DatabaseFactory $database = new DatabaseFactory()
    )
    {

    }

    public function getUserIdByName(string $userName): mixed
    {
        $sql = "SELECT 
                    user_id
                FROM 
                    users
                WHERE 
                    user_name = :user_name
                AND 
                    user_provider_type = :provider_type
                LIMIT 1";

        $query = $this->database
            ?->getFactory()
            ?->getConnection()
            ?->prepare($sql);

        $query?->execute(array(
                ':user_name' => $this->userName,
                ':provider_type' => 'DEFAULT'
            )
        );

        return $query?->fetch();
    }

    public function getUsernamePasswordByName(string $userName): bool
    {
        $sql = "SELECT 
                    user_password_hash
                FROM 
                    users
                WHERE 
                    user_name = :user_name
                AND 
                    user_provider_type = :provider_type
                LIMIT 1";

        $query = $this->database
            ?->getFactory()
            ?->getConnection()
            ?->prepare($sql);

        $query?->execute(array(
                ':user_name' => $this->userName,
                ':provider_type' => 'DEFAULT'
            )
        );

        return $query?->fetch();
    }
}