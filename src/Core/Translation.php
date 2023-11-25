<?php

namespace App\Core;

use App\Core\Session\SessionUsage;

class Translation
{
    use SessionUsage;

    public function __construct(
        private ?string $language = null,
        private readonly mixed $database = new DatabaseFactory()
    )
    {
        $this->language = $this->get('language');
    }

    public function getTranslation(): string
    {
        $sql = "SELECT 
                    user_id
                FROM 
                    translations
                WHERE 
                    language = :user_language
                LIMIT 1";

        $query = $this->database
            ?->getFactory()
            ?->getConnection()
            ?->prepare($sql);

        $query->execute(array(
                ':language' => $this->language
            )
        );

        return $query->fetch();
    }

}