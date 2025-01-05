<?php
// login.php (로그인)

require_once __DIR__ . '/../../Core/Database.php';
require_once __DIR__ . '/../../Models/UserModel.php';
require_once __DIR__ . '/../../Controllers/UserController.php';

use App\Controllers\UserController;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// POST 요청: Ajax 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');
    $controller = new UserController();
    $result = $controller->loginProcess($_POST);
    echo json_encode($result);
    exit;
}

// GET 요청: 로그인 폼 페이지
require_once __DIR__ . '/../../Views/layouts/header.php';
require_once __DIR__ . '/../../Views/user/login_form.php';
require_once __DIR__ . '/../../Views/layouts/footer.php';
