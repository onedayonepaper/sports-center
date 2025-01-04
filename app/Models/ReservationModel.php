<?php
namespace App\Models;

use App\Core\Database;

class ReservationModel
{
    /**
     * 예약 생성 (INSERT)
     * @param int $userId
     * @param int $facilityId
     * @param string $startTime 'YYYY-MM-DD HH:MM:SS'
     * @param string $endTime   'YYYY-MM-DD HH:MM:SS'
     * @return bool
     */
    public static function createReservation(int $userId, int $facilityId, string $startTime, string $endTime): bool
    {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO reservations (user_id, facility_id, start_time, end_time)
                VALUES (:uid, :fid, :start, :end)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':uid', $userId);
        $stmt->bindValue(':fid', $facilityId);
        $stmt->bindValue(':start', $startTime);
        $stmt->bindValue(':end', $endTime);

        return $stmt->execute();
    }

    /**
     * 예약 목록 JOIN users, facilities
     * @return array
     */
    public static function getAllReservations(): array
    {
        $pdo = Database::getConnection();
        $sql = "
          SELECT r.*, u.username, f.facility_name
          FROM reservations r
          JOIN users u ON r.user_id = u.user_id
          JOIN facilities f ON r.facility_id = f.facility_id
          ORDER BY r.reservation_id DESC
        ";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * 특정 reservation_id 조회
     */
    public static function getReservationById(int $resId): ?array
    {
        $pdo = Database::getConnection();
        $sql = "
          SELECT r.*, u.username, f.facility_name
          FROM reservations r
          JOIN users u ON r.user_id = u.user_id
          JOIN facilities f ON r.facility_id = f.facility_id
          WHERE r.reservation_id = :rid
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':rid', $resId);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /**
     * 예약 수정
     * (start_time, end_time, facility 변경 등)
     */
    public static function updateReservation(int $resId, int $facilityId, string $startTime, string $endTime): bool
    {
        $pdo = Database::getConnection();
        $sql = "
          UPDATE reservations
          SET facility_id = :fid,
              start_time = :start,
              end_time   = :end
          WHERE reservation_id = :rid
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':fid', $facilityId);
        $stmt->bindValue(':start', $startTime);
        $stmt->bindValue(':end', $endTime);
        $stmt->bindValue(':rid', $resId);

        return $stmt->execute();
    }

    /**
     * 예약 삭제(취소)
     */
    public static function deleteReservation(int $resId): bool
    {
        $pdo = Database::getConnection();
        $sql = "DELETE FROM reservations WHERE reservation_id = :rid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':rid', $resId);
        return $stmt->execute();
    }

    /**
     * 시간 중복 체크(간단 버전)
     * (end_time <= 시작) OR (start_time >= 끝) 이면 안 겹치는 구간
     * NOT(...)이면 겹침
     */
    public static function isTimeSlotAvailable(int $facilityId, string $startTime, string $endTime): bool
    {
        $pdo = Database::getConnection();
        $sql = "
          SELECT COUNT(*) as cnt
          FROM reservations
          WHERE facility_id = :fid
            AND NOT (end_time <= :start OR start_time >= :end)
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':fid'   => $facilityId,
            ':start' => $startTime,
            ':end'   => $endTime
        ]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return ((int)$row['cnt'] === 0);
    }
}
