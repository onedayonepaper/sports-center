<?php
// reservations/api_create.php
require_once __DIR__ . '/../../app/Core/Database.php';
require_once __DIR__ . '/../../app/Models/ReservationModel.php';

use App\Models\ReservationModel;

header("Content-Type: application/json; charset=utf-8");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status"=>"error", "message"=>"POST only"]);
    exit;
}

// 실제로는 session_start(); 하고 $_SESSION['user_id'] 사용 권장
$userId     = (int)($_POST['user_id'] ?? 1);
$facilityId = (int)($_POST['facility_id'] ?? 0);
$startTime  = $_POST['start_time'] ?? '';
$endTime    = $_POST['end_time'] ?? '';

// 시간 중복 체크
$available = ReservationModel::isTimeSlotAvailable($facilityId, $startTime, $endTime);
if (!$available) {
    echo json_encode(["status"=>"error", "message"=>"해당 시간대 이미 예약 존재"]);
    exit;
}

// 생성
$res = ReservationModel::createReservation($userId, $facilityId, $startTime, $endTime);
if ($res) {
    echo json_encode(["status"=>"success"]);
} else {
    echo json_encode(["status"=>"error", "message"=>"DB insert fail"]);
}
