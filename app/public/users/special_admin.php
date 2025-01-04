<?php
// special_admin.php
namespace App;

require_once __DIR__ . '/../../Core/Database.php';
require_once __DIR__ . '/../../Models/UserModel.php';
require_once __DIR__ . '/../../Controllers/SpecialAdminController.php';

use App\Controllers\SpecialAdminController;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// POST 요청 -> Ajax(또는 일반 POST) 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');

    $controller = new SpecialAdminController();
    $result = $controller->createAdmin($_POST);
    echo json_encode($result);
    exit;
}

// GET 요청 -> 관리자 생성 폼 표시
require_once __DIR__ . '/../../Views/layouts/header.php';
require_once __DIR__ . '/../../Views/admin/special_admin_form.php';
require_once __DIR__ . '/../../Views/layouts/footer.php';
