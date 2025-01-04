<?php
require_once __DIR__ . '/../../app/Core/Database.php';
require_once __DIR__ . '/../../app/Models/UserModel.php';

use App\Models\UserModel;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = '';
$allUsers = [];
try {
    $allUsers = UserModel::getAllUsers(); // 필요하면 getAllUsers() 구현
} catch(\Exception $e){
    $error = $e->getMessage();
}

// 헤더
require_once __DIR__ . '/../../app/Views/layouts/header.php';
?>

<h1>메인 페이지</h1>
<?php if($error): ?>
  <div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<p>여기는 메인입니다.</p>

<?php
// 푸터
require_once __DIR__ . '/../../app/Views/layouts/footer.php';
