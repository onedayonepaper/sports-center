<?php
namespace App\Core;

class Database {
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
            // .env 대신 getenv() 예시
            $host = getenv('DB_HOST') ?: 'db';         // docker-compose에서 DB 컨테이너명= db
            $dbname = getenv('DB_NAME') ?: 'sports_db';
            $user = getenv('DB_USER') ?: 'testuser';
            $pass = getenv('DB_PASS') ?: 'testpass';
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

            self::$conn = new \PDO($dsn, $user, $pass);
            self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }
}
