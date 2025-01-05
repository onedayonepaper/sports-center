<?php
// facilities/delete.php

require_once __DIR__ . '/../../app/Core/Database.php';
require_once __DIR__ . '/../../app/Models/FacilityModel.php';

use App\Models\FacilityModel;

// GET 파라미터로 facility_id 받기
$fid = $_GET['facility_id'] ?? null;
if (!$fid) {
    die("facility_id가 필요합니다.");
}

$fid = (int)$fid;
$res = FacilityModel::deleteFacility($fid);
if ($res) {
    header("Location: list.php");
    exit;
} else {
    echo "삭제 실패!";
}
