<?php
// facilities/create.php

require_once __DIR__ . '/../../app/Core/Database.php';
require_once __DIR__ . '/../../app/Models/FacilityModel.php';

use App\Models\FacilityModel;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $desc = $_POST['desc'] ?? '';
    $capacity = (int)($_POST['capacity'] ?? 0);

    $res = FacilityModel::createFacility($name, $desc, $capacity);
    if ($res) {
        // 등록 성공 → 목록 페이지로 이동
        header("Location: list.php");
        exit;
    } else {
        $error = "등록 실패!";
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>시설 등록</title></head>
<body>
<h1>시설 등록</h1>
<?php if(!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="post" action="">
  <label>시설명: <input type="text" name="name"></label><br>
  <label>설명: <textarea name="desc"></textarea></label><br>
  <label>정원: <input type="number" name="capacity"></label><br>
  <button type="submit">등록</button>
</form>

<a href="list.php">목록으로</a>
</body>
</html>
