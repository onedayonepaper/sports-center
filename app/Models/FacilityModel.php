<?php
namespace App\Models;

use App\Core\Database;

class FacilityModel
{
    public static function createFacility(string $name, string $desc = '', int $capacity = 0): bool
    {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO facilities (facility_name, description, max_capacity)
                VALUES (:name, :desc, :cap)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':desc', $desc);
        $stmt->bindValue(':cap', $capacity);
        return $stmt->execute();
    }

    public static function getAllFacilities(): array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM facilities ORDER BY facility_id DESC";
        return $pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getFacilityById(int $fid): ?array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM facilities WHERE facility_id = :fid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':fid', $fid);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function updateFacility(int $fid, string $name, string $desc = '', int $capacity = 0): bool
    {
        $pdo = Database::getConnection();
        $sql = "UPDATE facilities
                SET facility_name = :name,
                    description   = :desc,
                    max_capacity  = :cap
                WHERE facility_id = :fid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':desc', $desc);
        $stmt->bindValue(':cap', $capacity);
        $stmt->bindValue(':fid', $fid);
        return $stmt->execute();
    }

    public static function deleteFacility(int $fid): bool
    {
        $pdo = Database::getConnection();
        $sql = "DELETE FROM facilities WHERE facility_id = :fid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':fid', $fid);
        return $stmt->execute();
    }
}
