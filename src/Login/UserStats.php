<?php

namespace App\Login;

use App\Core\DatabaseFactory;

class UserStats
{

    public function __construct(
        private readonly string $userName,
        private readonly DatabaseFactory $database = new DatabaseFactory()
    )
    {
    }

    public function incUserFailedLogin(int $times): bool
    {
        $sql = "UPDATE 
                    users
                SET 
                    user_failed_logins = user_failed_logins + :times
                WHERE 
                    user_name = :user_name";

        $query = $this->database
            ?->getFactory()
            ?->getConnection()
            ?->prepare($sql);

        $query?->execute(array(
                ':user_name' => $this->userName,
                ':times' => $times
            )
        );

        return $query?->fetch();
    }

    public function getFailedLoginTimes()
    {
        $sql = "SELECT 
                    user_failed_logins
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
                ':user_name' => $this->userName
            )
        );

        return $query?->fetch();
    }

    public function getFailedLoginLastTime()
    {
        $sql = "SELECT 
                    user_last_failed_login
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
                ':user_name' => $this->userName
            )
        );

        return $query?->fetch();
    }

}