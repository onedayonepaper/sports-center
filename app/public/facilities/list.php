<?php
// facilities/list.php

require_once __DIR__ . '/../../app/Core/Database.php';
require_once __DIR__ . '/../../app/Models/FacilityModel.php';

// 목록 조회
use App\Models\FacilityModel;

$facilities = FacilityModel::getAllFacilities();
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>시설 목록</title></head>
<body>
<h1>시설 목록</h1>
<ul>
<?php foreach($facilities as $fac): ?>
  <li>
    <?= htmlspecialchars($fac['facility_name']) ?>
    (ID: <?= $fac['facility_id'] ?>)
    <a href="update.php?facility_id=<?= $fac['facility_id'] ?>">[수정]</a>
    <a href="delete.php?facility_id=<?= $fac['facility_id'] ?>">[삭제]</a>
  </li>
<?php endforeach; ?>
</ul>

<a href="create.php">시설 등록</a>
</body>
</html>
