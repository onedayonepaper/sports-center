<?php
namespace App\Models;

use App\Core\Database;

class FacilityModel
{
    /**
     * 시설 등록 (INSERT)
     * @param string $facilityName
     * @param string|null $description
     * @param int $capacity
     * @return bool
     */
    public static function createFacility(string $facilityName, ?string $description = null, int $capacity = 0): bool
    {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO facilities (facility_name, description, max_capacity)
                VALUES (:fname, :desc, :cap)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':fname', $facilityName);
        $stmt->bindValue(':desc', $description);
        $stmt->bindValue(':cap', $capacity);

        return $stmt->execute();
    }

    /**
     * 시설 전체 목록 (SELECT)
     * @return array
     */
    public static function getAllFacilities(): array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM facilities ORDER BY facility_id DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * 특정 facility_id로 시설 정보 조회
     * @param int $facilityId
     * @return array|null
     */
    public static function getFacilityById(int $facilityId): ?array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM facilities WHERE facility_id = :fid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':fid', $facilityId);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /**
     * 시설 수정 (UPDATE)
     * @param int $facilityId
     * @param string $facilityName
     * @param string|null $description
     * @param int $capacity
     * @return bool
     */
    public static function updateFacility(int $facilityId, string $facilityName, ?string $description, int $capacity): bool
    {
        $pdo = Database::getConnection();
        $sql = "UPDATE facilities
                SET facility_name = :fname,
                    description = :desc,
                    max_capacity = :cap
                WHERE facility_id = :fid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':fname', $facilityName);
        $stmt->bindValue(':desc', $description);
        $stmt->bindValue(':cap', $capacity);
        $stmt->bindValue(':fid', $facilityId);

        return $stmt->execute();
    }

    /**
     * 시설 삭제 (DELETE)
     * @param int $facilityId
     * @return bool
     */
    public static function deleteFacility(int $facilityId): bool
    {
        $pdo = Database::getConnection();
        $sql = "DELETE FROM facilities WHERE facility_id = :fid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':fid', $facilityId);
        return $stmt->execute();
    }
}
