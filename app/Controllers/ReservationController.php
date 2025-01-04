<?php
namespace App\Controllers;

use App\Models\ReservationModel;

class ReservationController
{
    public function handleAjax(array $data): array
    {
        $action = $data['action'] ?? '';

        if ($action === 'create') {
            // 필요한 필드 추출
            $facilityId = (int)($data['facility_id']  ?? 0);
            $userId     = (int)($data['user_id']      ?? 0);
            $start      = $data['start_time']         ?? '';
            $end        = $data['end_time']           ?? '';
            $note       = $data['note']               ?? '';

            $ok = ReservationModel::createReservation($facilityId, $userId, $start, $end, $note);
            return $ok
                ? ['status'=>'success','message'=>'예약 생성 완료']
                : ['status'=>'error','message'=>'DB Insert 실패'];
        }
        else if ($action === 'update') {
            $reservationId = (int)($data['reservation_id'] ?? 0);
            $facilityId    = (int)($data['facility_id']    ?? 0);
            $userId        = (int)($data['user_id']        ?? 0);
            $start         = $data['start_time']           ?? '';
            $end           = $data['end_time']             ?? '';
            $note          = $data['note']                 ?? '';

            $ok = ReservationModel::updateReservation($reservationId, $facilityId, $userId, $start, $end, $note);
            return $ok
                ? ['status'=>'success','message'=>'예약 수정 완료']
                : ['status'=>'error','message'=>'DB Update 실패'];
        }
        else if ($action === 'delete') {
            $reservationId = (int)($data['reservation_id'] ?? 0);
            $ok = ReservationModel::deleteReservation($reservationId);
            return $ok
                ? ['status'=>'success','message'=>'예약 삭제 완료']
                : ['status'=>'error','message'=>'DB Delete 실패'];
        }

        return ['status'=>'error','message'=>'알 수 없는 action'];
    }
}
