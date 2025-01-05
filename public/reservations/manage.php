<?php
// reservations/manage.php

// PHP 로직 (DB 연결, Model, 세션 등) - 상단에 배치
require_once __DIR__ . '/../../app/Core/Database.php';
require_once __DIR__ . '/../../app/Models/ReservationModel.php';

use App\Models\ReservationModel;

// 만약 GET/POST 액션을 이 페이지에서 직접 처리하려면, 여기서 처리
// ex) if ($_GET['action'] === 'load') { ... } => JSON 출력 etc.

// (아래 예시에서는 대부분 Ajax 요청을 별도 구분하지 않고, 한 페이지 안에서 진행)

// HTML 시작
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>스포츠센터 예약 - jQuery 기반 (PHP 페이지 방식)</title>
  <!-- jQuery CDN -->
  <script 
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJ+Y+i7mZr3aScM8dGk1eSrE5H0hPHkHw6fIQ="
    crossorigin="anonymous">
  </script>
</head>
<body>
<h1>스포츠센터 예약 (jQuery + PHP 페이지)</h1>

<!-- 예약 목록을 표시할 테이블 -->
<button id="loadBtn">목록 새로고침</button>
<table border="1" cellpadding="5" id="resTable">
  <thead>
    <tr>
      <th>ID</th>
      <th>시설ID</th>
      <th>시작</th>
      <th>종료</th>
      <th>관리</th>
    </tr>
  </thead>
  <tbody>
    <!-- jQuery로 목록 불러와서 채울 예정 -->
  </tbody>
</table>

<hr>
<!-- 예약 생성 폼 -->
<h2>예약 만들기</h2>
<form id="createForm">
  <label>사용자 ID: <input type="number" name="user_id" value="1"></label><br>
  <label>시설 ID: <input type="number" name="facility_id" value="1"></label><br>
  <label>시작 (YYYY-MM-DD HH:MM:SS): <input type="text" name="start_time" value="2025-07-01 09:00:00"></label><br>
  <label>종료 (YYYY-MM-DD HH:MM:SS): <input type="text" name="end_time" value="2025-07-01 10:00:00"></label><br>
  <button type="submit">예약 생성</button>
</form>

<script>
$(document).ready(function(){
  // 1) 목록 로드(읽기)
  $("#loadBtn").click(function(){
    $.ajax({
      url: "manage.php",
      method: "GET",
      data: { action: "list" }, // list 액션
      dataType: "json",
      success: function(data){
        // data = 배열
        var tbody = $("#resTable tbody");
        tbody.empty();
        $.each(data, function(i, item){
          var tr = $("<tr>");
          tr.append($("<td>").text(item.reservation_id));
          tr.append($("<td>").text(item.facility_id));
          tr.append($("<td>").text(item.start_time));
          tr.append($("<td>").text(item.end_time));

          // 삭제 버튼
          var delBtn = $("<button>").text("삭제").click(function(){
            if(!confirm("정말 삭제?")) return;
            $.ajax({
              url: "manage.php",
              method: "POST",
              dataType: "json",
              data: {
                action: "delete",
                reservation_id: item.reservation_id
              },
              success: function(res){
                if(res.status === "success") {
                  alert("삭제 완료");
                  $("#loadBtn").click(); // 새로고침
                } else {
                  alert("오류: " + res.message);
                }
              }
            });
          });

          var tdManage = $("<td>").append(delBtn);
          tr.append(tdManage);

          tbody.append(tr);
        });
      }
    });
  });

  // 페이지 로드 시 자동 목록 불러오기
  $("#loadBtn").click();

  // 2) 예약 생성
  $("#createForm").submit(function(e){
    e.preventDefault(); // 폼 기본 전송 막기
    var formData = $(this).serialize(); // user_id, facility_id, start_time, end_time

    $.ajax({
      url: "manage.php",
      method: "POST",
      dataType: "json",
      data: formData + "&action=create",
      success: function(res){
        if(res.status === "success"){
          alert("예약 생성됨");
          $("#createForm")[0].reset();
          $("#loadBtn").click();
        } else {
          alert("오류: " + res.message);
        }
      }
    });
  });
});
</script>
</body>
</html>

<?php
// 맨 아래쪽에, Ajax 액션 처리 로직
if (isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
    // JSON 응답을 보낼 것이므로, 버퍼에 남은 HTML을 방해하지 않도록 flush etc.
    // 실무에선 "HTML + JSON" 섞이면 충돌 가능 → 주의 or 별도 파일 분리
    // 여기선 예시 목적상 한 파일에 통합

    header("Content-Type: application/json; charset=utf-8");

    if ($action === 'list') {
        // 목록
        $list = ReservationModel::getAllReservations();
        echo json_encode($list);
        exit;
    }
    elseif ($action === 'create') {
        // 생성
        $userId     = (int)($_POST['user_id'] ?? 1);
        $facilityId = (int)($_POST['facility_id'] ?? 0);
        $startTime  = $_POST['start_time'] ?? '';
        $endTime    = $_POST['end_time'] ?? '';

        // 중복 체크
        $available = ReservationModel::isTimeSlotAvailable($facilityId, $startTime, $endTime);
        if (!$available) {
            echo json_encode(["status"=>"error","message"=>"이미 예약 존재"]);
            exit;
        }
        $res = ReservationModel::createReservation($userId, $facilityId, $startTime, $endTime);
        if($res) {
            echo json_encode(["status"=>"success"]);
        } else {
            echo json_encode(["status"=>"error","message"=>"DB insert fail"]);
        }
        exit;
    }
    elseif ($action === 'delete') {
        $resId = (int)($_POST['reservation_id'] ?? 0);
        $del = ReservationModel::deleteReservation($resId);
        if ($del) {
            echo json_encode(["status"=>"success"]);
        } else {
            echo json_encode(["status"=>"error","message"=>"Delete fail"]);
        }
        exit;
    }
    // etc... update 등 확장 가능
}
