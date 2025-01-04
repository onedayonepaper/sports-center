<?php
namespace App;

use App\Core\Database;
use App\Models\UserModel;

session_start();
require_once __DIR__ . '/../../app/Core/Database.php';
require_once __DIR__ . '/../../app/Models/UserModel.php';

// 관리자 체크
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ADMIN') {
    die("관리자 전용 페이지");
}

// Ajax
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');
    $action = $_POST['action'] ?? '';

    if ($action === 'load_users') {
        $list = UserModel::getAllUsers();
        echo json_encode($list);
        exit;
    }
    elseif ($action === 'promote') {
        $uid = (int)($_POST['user_id'] ?? 0);
        if ($uid > 0) {
            UserModel::updateRole($uid, 'ADMIN');
            echo json_encode(["status"=>"success"]);
        } else {
            echo json_encode(["status"=>"error","message"=>"잘못된 user_id"]);
        }
        exit;
    }
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>관리자 - 사용자 관리</title>
  <script 
    src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
    crossorigin="anonymous">
  </script>
</head>
<body>
<h1>관리자 전용 - 사용자 관리</h1>
<a href="../index.php">메인 페이지</a>
<hr>

<button id="loadBtn">사용자 목록</button>
<table border="1" cellpadding="5" id="userTable">
  <thead>
    <tr>
      <th>ID</th>
      <th>아이디</th>
      <th>권한</th>
      <th>가입일</th>
      <th>승격</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

<div id="err" style="color:red;"></div>

<script>
$(function(){
  $('#loadBtn').click(loadUsers).click(); // 첫 로드 시 목록

  function loadUsers(){
    $.ajax({
      url: 'admin_manage.php',
      method: 'POST',
      data: { action: 'load_users' },
      dataType: 'json',
      success: function(res){
        buildTable(res);
      },
      error: function(){
        $('#err').text("목록 로드 실패");
      }
    });
  }

  function buildTable(userList){
    let $tbody = $('#userTable tbody');
    $tbody.empty();
    $.each(userList, function(i, user){
      let $tr = $('<tr>');
      $tr.append($('<td>').text(user.user_id));
      $tr.append($('<td>').text(user.username));
      $tr.append($('<td>').text(user.role));
      $tr.append($('<td>').text(user.created_at));

      let $td = $('<td>');
      if(user.role !== 'ADMIN'){
        let $btn = $('<button>').text('승격').click(function(){
          promoteUser(user.user_id);
        });
        $td.append($btn);
      } else {
        $td.text('(이미 관리자)');
      }
      $tr.append($td);
      $tbody.append($tr);
    });
  }

  function promoteUser(uid){
    $.ajax({
      url: 'admin_manage.php',
      method: 'POST',
      data: { action:'promote', user_id: uid },
      dataType: 'json',
      success: function(res){
        if(res.status === 'success'){
          alert("승격 완료");
          loadUsers();
        } else {
          alert("오류: " + res.message);
        }
      },
      error: function(){
        alert("통신 오류");
      }
    });
  }
});
</script>
</body>
</html>
