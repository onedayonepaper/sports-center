<?php
require_once __DIR__ . '/../../../app/Core/Database.php';
require_once __DIR__ . '/../../../app/Models/UserModel.php';
require_once __DIR__ . '/../../../app/Controllers/UserController.php';

use App\Controllers\UserController;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 간단한 로그아웃 처리
$controller = new UserController();
$controller->logout();

// 메인페이지로 리다이렉트
header("Location: /index.php");
exit;
