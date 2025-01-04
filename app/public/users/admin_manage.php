<?php
// admin_manage.php
namespace App;

require_once __DIR__ . '/../../Core/Database.php';
require_once __DIR__ . '/../../Models/UserModel.php';
require_once __DIR__ . '/../../Controllers/AdminController.php';

use App\Controllers\AdminController;

// 세션
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 관리자 권한 체크
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'ADMIN') {
    header("HTTP/1.1 403 Forbidden");
    echo "접근 불가 - 관리자 전용 페이지입니다.";
    exit;
}

// POST 요청 -> Ajax 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');

    $adminController = new AdminController();
    $result = $adminController->handleAjax($_POST);
    echo json_encode($result);
    exit;
}

// GET 요청 -> 관리자 화면
require_once __DIR__ . '/../../Views/layouts/header.php';
require_once __DIR__ . '/../../Views/admin/admin_manage.php';
require_once __DIR__ . '/../../Views/layouts/footer.php';
