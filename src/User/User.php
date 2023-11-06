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

    public function getUserIdByName(): mixed
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

    public function getUserPasswordByName(): bool
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

    public function deleteRememberedUserById(string $userId)
    {
        $sql = "UPDATE 
                    users
                SET 
                    user_remember_me_token = :user_remember_me_token
                WHERE 
                    user_id = :user_id 
                LIMIT 1";

        $query = $this->database
            ?->getFactory()
            ?->getConnection()
            ?->prepare($sql);

        $query?->execute(array(
                ':user_id' => $userId,
                ':user_remember_me_token' => null
            )
        );

        return $query?->fetch();
    }

    public function getUserNameById(string $userId)
    {
        $sql = "SELECT 
                    user_name
                FROM 
                    users
                WHERE 
                    user_id = :user_id
                AND 
                    user_provider_type = :provider_type
                LIMIT 1";

        $query = $this->database
            ?->getFactory()
            ?->getConnection()
            ?->prepare($sql);

        $query?->execute(array(
                ':user_id' => $userId,
                ':provider_type' => 'DEFAULT'
            )
        );

        return $query?->fetch();
    }
}