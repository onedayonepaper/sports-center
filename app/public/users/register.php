<?php
require_once __DIR__ . '/../../../app/Core/Database.php';
require_once __DIR__ . '/../../../app/Models/UserModel.php';
require_once __DIR__ . '/../../../app/Controllers/UserController.php';

use App\Controllers\UserController;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// POST: Ajax 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');

    $controller = new UserController();
    $result = $controller->registerProcess($_POST);
    echo json_encode($result);
    exit;
}

// GET: 회원가입 폼
require_once __DIR__ . '/../../../app/Views/layouts/header.php';
require_once __DIR__ . '/../../../app/Views/user/register_form.php';
require_once __DIR__ . '/../../../app/Views/layouts/footer.php';
