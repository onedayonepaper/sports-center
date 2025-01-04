<?php
// reservations/api_delete.php
require_once __DIR__ . '/../../app/Core/Database.php';
require_once __DIR__ . '/../../app/Models/ReservationModel.php';

use App\Models\ReservationModel;

header("Content-Type: application/json; charset=utf-8");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status"=>"error", "message"=>"POST only"]);
    exit;
}

$resId = (int)($_POST['reservation_id'] ?? 0);
if ($resId <= 0) {
    echo json_encode(["status"=>"error", "message"=>"Invalid reservation_id"]);
    exit;
}

$del = ReservationModel::deleteReservation($resId);
if ($del) {
    echo json_encode(["status"=>"success"]);
} else {
    echo json_encode(["status"=>"error", "message"=>"Delete fail"]);
}
