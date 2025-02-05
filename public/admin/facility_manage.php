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

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'ADMIN') {
    header("HTTP/1.1 403 Forbidden");
    echo "접근 불가 - 관리자만 이용 가능합니다.";
    exit;
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
require_once __DIR__ . '/../../app/Views/admin/facility_manage_view.php';
require_once __DIR__ . '/../../app/Views/layouts/footer.php';
