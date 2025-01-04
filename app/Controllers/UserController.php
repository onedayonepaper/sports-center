<?php
namespace App\Controllers;

use App\Models\UserModel;

class UserController
{
    // 로그인
    public function loginProcess(array $data): array
    {
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        $user = UserModel::getUserByUsername($username);
        if (!$user) {
            return ['status'=>'error','message'=>'존재하지 않는 사용자'];
        }
        if (!password_verify($password, $user['password'])) {
            return ['status'=>'error','message'=>'비밀번호 불일치'];
        }

        // 로그인 성공 -> 세션 저장
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];
        return ['status'=>'success','message'=>'로그인 성공'];
    }

    // 회원가입
    public function registerProcess(array $data): array
    {
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        // 중복 체크
        $exist = UserModel::getUserByUsername($username);
        if ($exist) {
            return ['status'=>'error','message'=>'이미 존재하는 아이디'];
        }

        $res = UserModel::createUser($username, $password, 'USER');
        if ($res) {
            return ['status'=>'success','message'=>'회원가입 완료'];
        }
        return ['status'=>'error','message'=>'DB Insert 실패'];
    }

    // 로그아웃
    public function logout()
    {
        session_destroy();
    }
}
