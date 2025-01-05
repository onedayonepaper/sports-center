<?php
namespace App\Core;

class Database {
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
//            $host = getenv('DB_HOST') ?: 'db';
//            $dbname = getenv('DB_NAME') ?: 'sports_db';
//            $user = getenv('DB_USER') ?: 'testuser';
//            $pass = getenv('DB_PASS') ?: 'testpass';
//            $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
            $host   = getenv('MYSQLHOST')       ?: 'db';
            $port   = getenv('MYSQLPORT')       ?: '3306';
            $dbname = getenv('MYSQL_DATABASE')    ?: 'sports_db';
            $user   = getenv('MYSQLUSER')       ?: 'testuser';
            $pass   = getenv('MYSQLPASSWORD')   ?: 'testpass';

            // DSN에 port까지 넣어주면 확실
            $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";


            self::$conn = new \PDO($dsn, $user, $pass);
            self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }
}
