<?php
namespace App\Models;

use App\Core\Database;

class ReservationModel
{
    /**
     * 예약 생성
     */
    public static function createReservation(int $facilityId, int $userId, string $start, string $end, string $note = ''): bool
    {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO reservations (facility_id, user_id, start_time, end_time, note)
                VALUES (:fid, :uid, :start_time, :end_time, :note)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':fid', $facilityId);
        $stmt->bindValue(':uid', $userId);
        $stmt->bindValue(':start_time', $start);
        $stmt->bindValue(':end_time', $end);
        $stmt->bindValue(':note', $note);
        return $stmt->execute();
    }

    /**
     * 모든 예약 목록
     * - 단순히 'INNER JOIN'으로 facility_name, username 등을 가져오고 싶다면 다음과 같이 할 수 있음
     */
    public static function getAllReservations(): array
    {
        $pdo = Database::getConnection();
        // JOIN 예시 (시설명/유저명도 함께 표시하려면)
        $sql = "
          SELECT r.*, f.facility_name, u.username
            FROM reservations r
       LEFT JOIN facilities f ON r.facility_id = f.facility_id
       LEFT JOIN users      u ON r.user_id     = u.user_id
        ORDER BY r.reservation_id DESC
        ";
        return $pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * 특정 예약 조회
     */
    public static function getReservationById(int $reservationId): ?array
    {
        $pdo = Database::getConnection();
        $sql = "
          SELECT r.*, f.facility_name, u.username
            FROM reservations r
       LEFT JOIN facilities f ON r.facility_id = f.facility_id
       LEFT JOIN users      u ON r.user_id     = u.user_id
           WHERE r.reservation_id = :rid
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':rid', $reservationId);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /**
     * 예약 수정
     */
    public static function updateReservation(int $reservationId, int $facilityId, int $userId, string $start, string $end, string $note=''): bool
    {
        $pdo = Database::getConnection();
        $sql = "
          UPDATE reservations
             SET facility_id = :fid,
                 user_id     = :uid,
                 start_time  = :start_time,
                 end_time    = :end_time,
                 note        = :note
           WHERE reservation_id = :rid
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':fid', $facilityId);
        $stmt->bindValue(':uid', $userId);
        $stmt->bindValue(':start_time', $start);
        $stmt->bindValue(':end_time', $end);
        $stmt->bindValue(':note', $note);
        $stmt->bindValue(':rid', $reservationId);
        return $stmt->execute();
    }

    /**
     * 예약 삭제
     */
    public static function deleteReservation(int $reservationId): bool
    {
        $pdo = Database::getConnection();
        $sql = "DELETE FROM reservations WHERE reservation_id = :rid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':rid', $reservationId);
        return $stmt->execute();
    }
}
