<?php

namespace App\Core;

use PDO;
use PDOException;
use App\Http\Controllers\ErrorController;

class DatabaseFactory
{
    private static DatabaseFactory $factory;
    private PDO $database;

    public static function getFactory():DatabaseFactory {
        if (!self::$factory) {
            self::$factory = new DatabaseFactory();
        }
        return self::$factory;
    }

    public function getConnection():PDO {
        if (!$this->database) {
            try {
                $options = [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
                ];
                $this->database = new PDO(
                    Config::get('DB_TYPE') . ':host=' . Config::get('DB_HOST') . ';dbname=' .
                    Config::get('DB_NAME') . ';port=' . Config::get('DB_PORT') . ';charset=' . Config::get('DB_CHARSET'),
                    username: Config::get('DB_USER'),
                    password: Config::get('DB_PASS'),
                    options: $options
                );
            } catch (PDOException $e) {
                (new ErrorController)->fatalError(
                    message: 'FATAL_ERROR_DATABASE_CONNECTION' . ' Error code: ' . $e->getCode(),
                    errorPage: '404');
                exit;
            }
        }
        return $this->database;
    }
}
