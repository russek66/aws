<?php

namespace App\Http\API\User;

use App\Core\DatabaseFactory;
use App\Core\View\View;
use DateTime;

readonly class UserChartData
{

    public function __construct(
        private mixed $database = new DatabaseFactory()
    )
    {
    }

    public function getNewUsersFromLastDays($days = 30): string
    {
        $sql = "SELECT 
                    COUNT(user_id)
                FROM 
                    users
                WHERE 
                    user_creation_timestamp >= :days
                LIMIT 1";

        $query = $this->database
            ?->getFactory()
            ?->getConnection()
            ?->prepare($sql);

        $query?->execute([
                ':days' => (new DateTime())->modify("-{$days} days")
            ]
        );

        return (new View())->renderJSON(200, $query?->fetch());
    }

    public function getTotalUsersFromLastDays($days = 30): string
    {
        $sql = "SELECT 
                    COUNT(user_id)
                FROM 
                    users
                WHERE 
                    user_creation_timestamp >= :days
                LIMIT 1";

        $query = $this->database
            ?->getFactory()
            ?->getConnection()
            ?->prepare($sql);

        $query?->execute([
                ':days' => (new DateTime())->modify("-{$days} days")
            ]
        );

        return (new View())->renderJSON(200, $query?->fetch());
    }

    public function getTotalUsersInMonth($month = 1, $year = 2024): string
    {
        $sql = "SELECT 
                    COUNT(user_id)
                FROM 
                    users
                WHERE 
                    user_creation_timestamp >= :daysStart
                AND
                    user_creation_timestamp >= :daysEnd
                LIMIT 1";

        $query = $this->database
            ?->getFactory()
            ?->getConnection()
            ?->prepare($sql);

        $date = new DateTime("{$year}/{$month}/01");

        $query?->execute([
                ':daysStart' => $date->modify('first day of this month')->getTimestamp(),
                ':daysEnd' => $date->modify('last day of this month')->getTimestamp()
            ]
        );

        return (new View())->renderJSON(200, $query?->fetch());
    }

    public function getTotalUsers(): string
    {
        $sql = "SELECT 
                    COUNT(user_id)
                FROM 
                    users
                LIMIT 1";

        $query = $this->database
            ?->getFactory()
            ?->getConnection()
            ?->prepare($sql);

        $query?->execute([
                ':days' => (new DateTime())->modify("-{$days} days")
            ]
        );

        return (new View())->renderJSON(200, $query?->fetch());
    }


}