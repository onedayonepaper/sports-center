<?php
// logout.php (로그아웃)

require_once __DIR__ . '/../../Core/Database.php';
require_once __DIR__ . '/../../Models/UserModel.php';
require_once __DIR__ . '/../../Controllers/UserController.php';

use App\Controllers\UserController;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 로그아웃
$controller = new UserController();
$controller->logout();

// 메인 페이지로 이동
header('Location: /index.php');
exit;
