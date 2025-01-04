<?php
// reservations/update.php
// 예약 정보 수정 (시작/종료 시간 등)

require_once __DIR__ . '/../../app/Core/Database.php';
require_once __DIR__ . '/../../app/Models/ReservationModel.php';
require_once __DIR__ . '/../../app/Models/FacilityModel.php';

use App\Models\ReservationModel;
use App\Models\FacilityModel;

// GET으로 reservation_id를 받아와서 해당 예약 정보 표시
$resId = (int)($_GET['reservation_id'] ?? 0);
if ($resId <= 0) {
    exit("잘못된 접근입니다.");
}

$reservation = ReservationModel::getReservationById($resId);
if (!$reservation) {
    exit("존재하지 않는 예약입니다.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $facilityId = (int)($_POST['facility_id'] ?? 0);
    $startTime  = $_POST['start_time'] ?? '';
    $endTime    = $_POST['end_time'] ?? '';

    // 중복 체크
    $available = ReservationModel::isTimeSlotAvailable($facilityId, $startTime, $endTime);
    if (!$available) {
        $error = "해당 시간대는 이미 예약이 있습니다.";
    } else {
        $res = ReservationModel::updateReservation($resId, $facilityId, $startTime, $endTime);
        if ($res) {
            header("Location: list.php");
            exit;
        } else {
            $error = "수정 실패!";
        }
    }
}

// 시설 목록
$facilities = FacilityModel::getAllFacilities();
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>예약 수정</title></head>
<body>
<h1>예약 수정</h1>
<?php if(!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="post">
  <label>예약 ID: <?= $reservation['reservation_id'] ?></label><br>

  <label>시설:
    <select name="facility_id">
    <?php foreach($facilities as $fac): ?>
      <option value="<?= $fac['facility_id'] ?>"
        <?= $fac['facility_id'] == $reservation['facility_id'] ? 'selected' : '' ?>>
        <?= htmlspecialchars($fac['facility_name']) ?>
      </option>
    <?php endforeach; ?>
    </select>
  </label><br>

  <label>시작 시간:
    <input type="datetime-local" name="start_time"
      value="<?= str_replace(' ','T',$reservation['start_time']) ?>">
  </label><br>

  <label>종료 시간:
    <input type="datetime-local" name="end_time"
      value="<?= str_replace(' ','T',$reservation['end_time']) ?>">
  </label><br>

  <button type="submit">수정하기</button>
</form>

<a href="list.php">예약 목록</a>
</body>
</html>
