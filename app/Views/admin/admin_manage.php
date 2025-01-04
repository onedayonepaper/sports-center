<?php
use App\Models\UserModel;

// 관리자 화면에 보여줄 목록
$allUsers = UserModel::getAllUsers();
?>
<h1>관리자 화면</h1>
<p>관리자 전용 역할 변경/삭제 예시</p>

<table border="1" cellspacing="0" cellpadding="5">
  <thead>
    <tr><th>User ID</th><th>Username</th><th>Role</th><th>변경</th></tr>
  </thead>
  <tbody>
  <?php foreach ($allUsers as $u): ?>
    <tr data-userid="<?= $u['user_id'] ?>">
      <td><?= $u['user_id'] ?></td>
      <td><?= htmlspecialchars($u['username']) ?></td>
      <td class="role"><?= htmlspecialchars($u['role']) ?></td>
      <td>
        <select class="roleSelect">
          <option value="USER"  <?= $u['role']==='USER' ? 'selected':'' ?>>USER</option>
          <option value="ADMIN" <?= $u['role']==='ADMIN' ? 'selected':'' ?>>ADMIN</option>
        </select>
        <button class="roleUpdateBtn">역할변경</button>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<script>
$(function(){
  // 역할 변경 버튼
  $('.roleUpdateBtn').on('click', function(){
    let tr = $(this).closest('tr');
    let userId  = tr.data('userid');
    let newRole = tr.find('.roleSelect').val();

    $.ajax({
      url: '/users/admin_manage.php',  // admin_manage.php 절대경로
      method: 'POST',
      data: {
        action: 'updateRole',
        user_id: userId,
        new_role: newRole
      },
      dataType: 'json',
      success: function(res){
        if (res.status === 'success') {
          alert(res.message);
          tr.find('.role').text(newRole);
        } else {
          alert('오류: ' + res.message);
        }
      },
      error: function(){
        alert("통신 오류");
      }
    });
  });
});
</script>
