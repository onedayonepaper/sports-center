<?php
// reservations/api_list.php
require_once __DIR__ . '/../../app/Core/Database.php';
require_once __DIR__ . '/../../app/Models/ReservationModel.php';

use App\Models\ReservationModel;

// JSON 헤더
header("Content-Type: application/json; charset=utf-8");

// DB에서 모든 예약 조회
$reservations = ReservationModel::getAllReservations();
// 배열을 JSON으로 변환 후 출력
echo json_encode($reservations);
