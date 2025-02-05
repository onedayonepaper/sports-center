<?php
namespace App;

require_once __DIR__ . '/../../app/Core/Database.php';
require_once __DIR__ . '/../../app/Models/ReservationModel.php';
require_once __DIR__ . '/../../app/Controllers/ReservationController.php';

use App\Models\ReservationModel;
use App\Controllers\ReservationController;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// POST -> Ajax
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');

    $controller = new ReservationController();
    $result = $controller->handleAjax($_POST);
    echo json_encode($result);
    exit;
}

// GET -> 예약 목록 조회 + 뷰 로드
$reservations = ReservationModel::getAllReservations();

require_once __DIR__ . '/../../app/Views/layouts/header.php';
require_once __DIR__ . '/../../app/Views/reservations/list_view.php';
require_once __DIR__ . '/../../app/Views/layouts/footer.php';
