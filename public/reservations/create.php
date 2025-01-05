<?php
// reservations/create.php
// 새 예약 만들기

require_once __DIR__ . '/../../app/Core/Database.php';
require_once __DIR__ . '/../../app/Models/ReservationModel.php';
require_once __DIR__ . '/../../app/Models\FacilityModel.php';

use App\Models\ReservationModel;
use App\Models\FacilityModel;

// (선택) 세션 로그인 체크 (권장)
// session_start();
// if(!isset($_SESSION['user_id'])) {
//    exit("로그인이 필요합니다.");
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'] ?? 1; // 실제로는 $_SESSION['user_id'] 사용을 권장
    $facilityId = (int)($_POST['facility_id'] ?? 0);
    $startTime  = $_POST['start_time'] ?? '';
    $endTime    = $_POST['end_time'] ?? '';

    // 시간 중복 체크
    $available = ReservationModel::isTimeSlotAvailable($facilityId, $startTime, $endTime);
    if (!$available) {
        $error = "해당 시간대는 이미 예약이 존재합니다.";
    } else {
        $res = ReservationModel::createReservation($userId, $facilityId, $startTime, $endTime);
        if ($res) {
            header("Location: list.php");
            exit;
        } else {
            $error = "예약 등록 실패!";
        }
    }
}

// 시설 목록 불러와서 <select>에 표시 (사용자가 시설 선택)
$facilities = FacilityModel::getAllFacilities();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>예약 생성</title>
</head>
<body>
<h1>예약 생성</h1>
<?php if(!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="post">
  <!-- 실제로는 user_id를 세션에서 처리 -->
  <label>사용자 ID: <input type="number" name="user_id" value="1"></label><br>

  <label>시설:
    <select name="facility_id">
    <?php foreach($facilities as $fac): ?>
      <option value="<?= $fac['facility_id'] ?>"><?= htmlspecialchars($fac['facility_name']) ?></option>
    <?php endforeach; ?>
    </select>
  </label><br>

  <label>시작 시간: <input type="datetime-local" name="start_time"></label><br>
  <label>종료 시간: <input type="datetime-local" name="end_time"></label><br>

  <button type="submit">예약하기</button>
</form>

<a href="list.php">예약 목록</a>
</body>
</html>
