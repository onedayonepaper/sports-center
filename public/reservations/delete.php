<?php
// reservations/delete.php
// 예약 취소(삭제)

require_once __DIR__ . '/../../app/Core/Database.php';
require_once __DIR__ . '/../../app/Models/ReservationModel.php';

use App\Models\ReservationModel;

$resId = (int)($_GET['reservation_id'] ?? 0);
if ($resId <= 0) {
    exit("reservation_id가 올바르지 않습니다.");
}

$res = ReservationModel::deleteReservation($resId);
if ($res) {
    header("Location: list.php");
    exit;
} else {
    echo "삭제 실패!";
}
