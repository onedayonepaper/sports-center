# 코드작성
- 모든 코드는 jQuery사용중점으로 코드를 작성
- 모든 것은 jQuery Ajax로 서버와 통신, JSON 응답을 받아 DOM을 동적으로 조작

### 유저파일
최초 관리자 계정 생성: special_admin.php (비공개 페이지)
일반 회원가입: register.php
관리자 전용 화면: admin_manage.php (사용자 목록/승격)
로그인/로그아웃은 기존 login.php, logout.php를 그대로 사용한다고 가정
모든 주요 기능(회원가입, 승격 등)을 jQuery Ajax로 처리

```json
sports-center/
 ├── public/                  # (웹 루트)
 │    ├── index.php           # 메인 엔트리
 │    ├── facilities/         # 시설 관련 파일
 │    ├── reservations/       # 예약 관련 파일
 │    └── users/              # 유저 관련 파일
 ├── app/
 │    ├── Controllers/
 │    │    ├── AdminController.php
 │    │    ├── FacilityController.php
 │    │    ├── ReservationController.php
 │    │    ├── SpecialAdminController.php
 │    │    ├── UserController.php
 │    ├── Core/
 │    │    └── Database.php      (PDO 연결)
 │    ├── Models/
 │    │    ├── FacilityModel.php
 │    │    ├── UserModel.php
 │    │    └── ReservationModel.php
 │    ├── Views/
 │    │    ├── admin
 │    │    ├── facility
 │    │    ├── layouts
 │    │    │    ├── header.php
 │    │    │    └── footer.php
 │    │    └── user
 │    │    ├── reservations
 │    │    └── user
 ├── initdb/
 │    └── init.sql
 ├── docker-compose.yml
 ├── Dockerfile
 └── ReadMe.md
```

