<?php
namespace App;

require_once __DIR__ . '/../../app/Core/Database.php';
require_once __DIR__ . '/../../app/Models/FacilityModel.php';
require_once __DIR__ . '/../../app/Controllers/FacilityController.php';

use App\Controllers\FacilityController;
use App\Models\FacilityModel;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// POST -> Ajax 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');

    $controller = new FacilityController();
    $result = $controller->handleAjax($_POST);
    echo json_encode($result);
    exit;
}

// GET -> 시설 목록 + 뷰 렌더
$facilities = FacilityModel::getAllFacilities();

// 뷰 렌더
require_once __DIR__ . '/../../app/Views/layouts/header.php';
require_once __DIR__ . '/../../app/Views/facility/list_view.php';
require_once __DIR__ . '/../../app/Views/layouts/footer.php';
