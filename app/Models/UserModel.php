<?php
namespace App\Models;

use App\Core\Database;

class UserModel
{
    /**
     * 새 사용자 생성
     */
    public static function createUser(string $username, string $password, string $role='USER'): bool
    {
        $pdo = Database::getConnection();
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, role) 
                VALUES (:uname, :pass, :role)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':uname', $username);
        $stmt->bindValue(':pass', $hashed);
        $stmt->bindValue(':role', $role);
        return $stmt->execute();
    }

    
    

    /**
     * username으로 가져오기
     */
    public static function getUserByUsername(string $username): ?array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM users WHERE username = :uname";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':uname', $username);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /**
     * user_id로 가져오기
     */
    public static function getUserById(int $userId): ?array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM users WHERE user_id = :uid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':uid', $userId);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    


    /**
     * 모든 사용자 조회
     */
    public static function getAllUsers(): array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM users ORDER BY user_id DESC";
        return $pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * role 업데이트
     */
    public static function updateRole(int $userId, string $newRole): bool
    {
        $pdo = Database::getConnection();
        $sql = "UPDATE users SET role = :r WHERE user_id = :uid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':r', $newRole);
        $stmt->bindValue(':uid', $userId);
        return $stmt->execute();
    }
}
