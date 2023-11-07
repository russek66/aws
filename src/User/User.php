<?php

namespace App\User;

use App\Core\DatabaseFactory;

readonly class User
{

    public function __construct(
        private ?string $userName = null,
        private ?string $userId = null,
        private DatabaseFactory $database = new DatabaseFactory()
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

    public function deleteRememberedUserById()
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
                ':user_id' => $this->userId,
                ':user_remember_me_token' => null
            )
        );

        return $query?->fetch();
    }

    public function getUserNameById()
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
                ':user_id' => $this->userId,
                ':provider_type' => 'DEFAULT'
            )
        );

        return $query?->fetch();
    }
}