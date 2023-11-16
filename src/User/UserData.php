<?php

namespace App\User;

use App\Core\DatabaseFactory;

class UserData
{

    public function __construct(
        private mixed $data,
        private readonly DatabaseFactory $database = new DatabaseFactory()
    )
    {

    }

    public function getUserTokenById(): mixed
    {
        $sql = "SELECT 
                    user_access_token
                FROM 
                    users
                WHERE 
                    user_id = :user_id
                LIMIT 1";

        $query = $this->database
            ?->getFactory()
            ?->getConnection()
            ?->prepare($sql);

        $query?->execute(array(
                ':user_name' => $this->data->userId
            )
        );

        return $query?->fetch();
    }
}