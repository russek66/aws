<?php

namespace App\User;

use App\Core\DatabaseFactory;
use DateTime;

readonly class UserChartData
{

    public function __construct(
        private mixed $database = new DatabaseFactory()
    )
    {

    }
    public function getNewUsersFromLastDays($days = 30)
    {
        $sql = "SELECT 
                    *
                FROM 
                    users
                WHERE 
                    user_creation_timestamp >= :days
                LIMIT 1";

        $query = $this->database
            ?->getFactory()
            ?->getConnection()
            ?->prepare($sql);

        $query?->execute(array(
                ':days' => (new DateTime())->modify("-{$days} days")
            )
        );

        return $query?->fetch();
    }
}