<?php

namespace App\Core;

use PDO;
use PDOException;
use App\Http\Controllers\ErrorController;

class DatabaseFactory
{
    use Config;

    private static ?DatabaseFactory $factory = null;
    private ?PDO $database = null;

    public static function getFactory(): ?DatabaseFactory
    {
        if (!self::$factory) {
            self::$factory = new DatabaseFactory();
        }
        return self::$factory;
    }

    public function getConnection(): ?PDO
    {
        if (!$this->database) {
            try {
                $options = [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
                ];
                $this->database = new PDO(
                    $this->get('DB_TYPE') . ':host=' . $this->get('DB_HOST') . ';dbname=' .
                    $this->get('DB_NAME') . ';port=' . $this->get('DB_PORT') . ';charset=' . $this->get('DB_CHARSET'),
                    username: $this->get('DB_USER'),
                    password: $this->get('DB_PASS'),
                    options: $options
                );
            } catch (PDOException $e) {
                (new ErrorController())->fatalError(
                    message: 'FATAL_ERROR_DATABASE_CONNECTION' . ' Error code: ' . $e->getCode(),
                    errorPage: '404');
                exit;
            }
        }
        return $this->database;
    }
}
