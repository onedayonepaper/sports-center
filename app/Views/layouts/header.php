<?php
namespace App;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 로그인 상태 체크
$loggedUser = null;
if (isset($_SESSION['user_id'])) {
    $loggedUser = [
        'user_id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'role'    => $_SESSION['role'] ?? 'USER'
    ];
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>Sports Center</title>
  <script 
    src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
    crossorigin="anonymous">
  </script>
  <style>
    body { font-family: sans-serif; margin: 20px; }
    header::after { content: ""; display: block; clear: both; }
    .menu a { margin-right:10px; }
    .user-info { float:right; }
    .error { color:red; }
  </style>
</head>
<body>
<header>
  <div class="user-info">
    <?php if ($loggedUser): ?>
      <strong><?= htmlspecialchars($loggedUser['username']) ?></strong>
      (Role: <?= htmlspecialchars($loggedUser['role']) ?>)
      <a href="/users/logout.php">로그아웃</a>
    <?php else: ?>
      <a href="/users/login.php">로그인</a>
      <a href="/users/register.php">회원가입</a>
    <?php endif; ?>
  </div>
  <div class="menu">
    <a href="/index.php">메인</a>
      <?php if ($loggedUser && $loggedUser['role'] === 'ADMIN'): ?>
          <a href="/admin/admin_manage.php">관리자화면</a>
      <?php endif; ?>
    <a href="/facilities/list.php">시설 목록</a>
    <a href="/reservations/list.php">예약 목록</a>
  </div>
</header>
<hr>
