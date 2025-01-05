<?php
namespace App\Core;

class Database {
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
            // Railway에서 제공하는 환경 변수
            $host = getenv('MYSQLHOST') ?: getenv('DB_HOST') ?: 'localhost';
            $port = getenv('MYSQLPORT') ?: '3306';
            $dbname = getenv('MYSQLDATABASE') ?: getenv('DB_NAME') ?: 'sports_db';
            $user = getenv('MYSQLUSER') ?: getenv('DB_USER') ?: 'testuser';
            $pass = getenv('MYSQLPASSWORD') ?: getenv('DB_PASS') ?: 'testpass';

            // DSN에 포트 포함
            $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";

            try {
                self::$conn = new \PDO($dsn, $user, $pass);
                self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                // 필요하면 로깅 또는 에러 핸들링
                die("DB 연결 오류: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
