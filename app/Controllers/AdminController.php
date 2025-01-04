<?php
namespace App\Controllers;

use App\Models\UserModel;

class AdminController
{
    /**
     * Ajax 요청 분기 처리
     */
    public function handleAjax(array $data): array
    {
        $action = $data['action'] ?? '';

        if ($action === 'updateRole') {
            $userId  = intval($data['user_id'] ?? 0);
            $newRole = $data['new_role'] ?? 'USER';
            $ok = UserModel::updateRole($userId, $newRole);
            return $ok
                ? ['status'=>'success','message'=>'역할 변경 성공']
                : ['status'=>'error','message'=>'DB 업데이트 실패'];
        }
        else if ($action === 'deleteUser') {
            // 삭제 기능 구현 예시
            // ...
            return ['status'=>'success','message'=>'유저 삭제 성공(예시)'];
        }

        // 그 외 action이 없는 경우
        return ['status'=>'error','message'=>'알 수 없는 action'];
    }
}
