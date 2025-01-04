<?php
namespace App\Controllers;

use App\Models\UserModel;

/**
 * 최초 관리자 계정 생성 로직
 * - 보통 한 번만 사용 후 숨김/삭제
 */
class SpecialAdminController
{
    /**
     * createAdmin
     * - username, password 받음
     * - role='ADMIN' 으로 새 계정 생성
     */
    public function createAdmin(array $data): array
    {
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';
        $role = 'ADMIN'; // 무조건 관리자

        // 이미 있는지 확인
        $exist = UserModel::getUserByUsername($username);
        if ($exist) {
            return [
                'status'  => 'error',
                'message' => '이미 존재하는 아이디',
            ];
        }

        // 계정 생성
        $res = UserModel::createUser($username, $password, $role);
        if ($res) {
            return [
                'status'  => 'success',
                'message' => '관리자 계정 생성 완료',
            ];
        } else {
            return [
                'status'  => 'error',
                'message' => 'DB Insert 실패',
            ];
        }
    }
}
