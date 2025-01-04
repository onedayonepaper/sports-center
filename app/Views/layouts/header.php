<?php
namespace App; // 네임스페이스는 꼭 맞출 필요는 없지만, 충돌 방지용으로 선언

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 로그인 상태
$loggedUser = null;
if (isset($_SESSION['user_id'])) {
    // 세션값만 사용(필요시 DB 다시 조회 가능)
    $loggedUser = [
      'user_id' => $_SESSION['user_id'],
      'role'    => $_SESSION['role'] ?? 'USER'
    ];
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>Docker-PHP App</title>
  <script 
    src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
    crossorigin="anonymous">
  </script>
  <style>
    body { font-family: sans-serif; margin: 20px; }
    header::after { content:""; display:block; clear:both; }
    .menu a { margin-right:10px; }
    .user-info { float:right; }
    .error { color:red; }
  </style>
</head>
<body>
<header>
  <div class="user-info">
    <?php if ($loggedUser): ?>
      로그인: <strong><?= htmlspecialchars($loggedUser['user_id']) ?></strong>
      (<?= htmlspecialchars($loggedUser['role']) ?>)
      <a href="/users/logout.php">로그아웃</a>
    <?php else: ?>
      <a href="/users/login.php">로그인</a>
      <a href="/users/register.php">회원가입</a>
    <?php endif; ?>
  </div>
  <div class="menu">
    <a href="/index.php">메인</a>
  </div>
</header>
<hr>
