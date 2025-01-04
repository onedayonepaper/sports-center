<?php
// reservations/list.php
// 예약 목록 조회 페이지

require_once __DIR__ . '/../../app/Core/Database.php';
require_once __DIR__ . '/../../app/Models/ReservationModel.php';

use App\Models\ReservationModel;

// 예약 전체 목록 불러오기
$resList = ReservationModel::getAllReservations();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>예약 목록</title>
</head>
<body>
<h1>예약 목록</h1>
<table border="1" cellpadding="5">
  <tr>
    <th>ID</th>
    <th>시설</th>
    <th>시작시간</th>
    <th>종료시간</th>
    <th>사용자</th>
    <th>관리</th>
  </tr>
  <?php foreach($resList as $row): ?>
  <tr>
    <td><?= $row['reservation_id'] ?></td>
    <td><?= htmlspecialchars($row['facility_name']) ?></td>
    <td><?= $row['start_time'] ?></td>
    <td><?= $row['end_time'] ?></td>
    <td><?= htmlspecialchars($row['username']) ?></td>
    <td>
      <a href="update.php?reservation_id=<?= $row['reservation_id'] ?>">[수정]</a>
      <a href="delete.php?reservation_id=<?= $row['reservation_id'] ?>">[삭제]</a>
    </td>
  </tr>
  <?php endforeach; ?>
</table>

<a href="create.php">새 예약 만들기</a> |
<a href="../index.php">메인 페이지</a>

</body>
</html>
