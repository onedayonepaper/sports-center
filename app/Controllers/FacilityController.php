<?php
namespace App\Controllers;

use App\Models\FacilityModel;

class FacilityController
{
    public function handleAjax(array $data): array
    {
        $action = $data['action'] ?? '';

        if ($action === 'create') {
            $name     = $data['facility_name'] ?? '';
            $desc     = $data['description'] ?? '';
            $capacity = (int)($data['max_capacity'] ?? 0);

            $ok = FacilityModel::createFacility($name, $desc, $capacity);
            return $ok
                ? ['status'=>'success','message'=>'시설 등록 성공']
                : ['status'=>'error','message'=>'DB Insert 실패'];
        }
        else if ($action === 'update') {
            $fid      = (int)($data['facility_id']   ?? 0);
            $name     = $data['facility_name']       ?? '';
            $desc     = $data['description']         ?? '';
            $capacity = (int)($data['max_capacity']  ?? 0);

            $ok = FacilityModel::updateFacility($fid, $name, $desc, $capacity);
            return $ok
                ? ['status'=>'success','message'=>'시설 수정 성공']
                : ['status'=>'error','message'=>'DB Update 실패'];
        }
        else if ($action === 'delete') {
            $fid = (int)($data['facility_id'] ?? 0);
            $ok  = FacilityModel::deleteFacility($fid);
            return $ok
                ? ['status'=>'success','message'=>'시설 삭제 성공']
                : ['status'=>'error','message'=>'DB Delete 실패'];
        }

        return ['status'=>'error','message'=>'알 수 없는 action'];
    }
}
