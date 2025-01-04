<?php
namespace App;

use App\Core\Database;
use App\Models\UserModel;

require_once __DIR__ . '/../../app/Core/Database.php';
require_once __DIR__ . '/../../app/Models/UserModel.php';

// 간단한 접근 토큰
$token = $_GET['token'] ?? '';
if($token !== 'abcd1234'){
    die("비공개 페이지. 접근 권한 없음.");
}

// Ajax 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $exist = UserModel::getUserByUsername($username);
    if($exist) {
        echo json_encode(["status"=>"error","message"=>"이미 존재하는 아이디"]);
        exit;
    }
    $res = UserModel::createUser($username, $password, 'ADMIN');
    if($res) {
        echo json_encode(["status"=>"success","message"=>"최초 관리자 생성 성공"]);
    } else {
        echo json_encode(["status"=>"error","message"=>"DB Insert 실패"]);
    }
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>최초 관리자 생성</title>
  <script 
    src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
    crossorigin="anonymous">
  </script>
</head>
<body>
<h1>최초 관리자 생성</h1>
<p>(비공개 링크, 1회용)</p>

<div id="err" style="color:red;"></div>
<div id="msg" style="color:blue;"></div>

<form id="adminForm">
  <label>아이디: <input type="text" name="username" required></label><br>
  <label>비밀번호: <input type="password" name="password" required></label><br>
  <button type="submit">생성</button>
</form>

<script>
$(function(){
  $('#adminForm').submit(function(e){
    e.preventDefault();
    let formData = $(this).serialize();

    $.ajax({
      url: 'special_admin.php?token=<?= urlencode($token) ?>',
      method: 'POST',
      data: formData,
      dataType: 'json',
      success: function(res){
        if(res.status === 'success'){
          $('#msg').text(res.message);
          $('#err').text('');
          $('#adminForm')[0].reset();
        } else {
          $('#msg').text('');
          $('#err').text(res.message);
        }
      },
      error: function(){
        $('#err').text("통신 오류");
      }
    });
  });
});
</script>
</body>
</html>
