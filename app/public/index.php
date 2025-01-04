<?php
// index.php (메인 페이지)

require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/UserModel.php';

use App\Models\UserModel;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = '';
$users = [];
try {
    // 필요 시 getAllUsers()를 구현해서 가져온다고 가정
    $users = UserModel::getAllUsers();
} catch (\Exception $e) {
    $error = $e->getMessage();
}

// 공통 헤더
require_once __DIR__ . '/../Views/layouts/header.php';
?>
<h1>스포츠 센터 메인</h1>

<?php if ($error): ?>
  <div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<p>유저 목록(테스트):</p>
<ul>
  <?php foreach ($users as $u): ?>
    <li><?= htmlspecialchars($u['username']) ?> (ID: <?= $u['user_id'] ?>)</li>
  <?php endforeach; ?>
</ul>

<?php
// 공통 푸터
require_once __DIR__ . '/../Views/layouts/footer.php';
