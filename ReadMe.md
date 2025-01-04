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
 ├── app/
 │    ├── Core/
 │    │    └── Database.php      (PDO 연결)
 │    ├── Models/
 │    │    ├── FacilityModel.php
 │    │    ├── UserModel.php
 │    │    └── ReservationModel.php
 ├── mysql-init/
 │    └── schema.sql
 ├── php/
 │    └── Dockerfile
 └── public/
      ├── index.php                   (메인 페이지 or 안내)
      ├── facilities/
      │    ├── list.php              (시설 목록)
      │    ├── create.php            (시설 등록)
      │    ├── update.php            (시설 수정)
      │    └── delete.php            (시설 삭제)
      ├── reservations/
      │    ├── list.php
      │    ├── create.php
      │    ├── update.php
      │    └── delete.php
      └── users/
           ├── login.php
           ├── logout.php
           ├── register.php
           └── list.php
           └── create_admin_secret.php
 ├── docker-compose.yml
 └── ReadMe.md
```

```
sports-center/
├── app/
│   ├── Core/
│   │   └── Database.php       # PDO 연결 (DB 싱글턴)
│   ├── Models/
│   │   ├── FacilityModel.php  # 시설 관련 DB 로직
│   │   ├── UserModel.php      # 사용자(회원) 관련 DB 로직
│   │   └── ReservationModel.php # 예약 관련 DB 로직
│   # (선택) Controllers/ 디렉토리를 둘 수도 있으나, 
│   #  이번 "URL=파일경로" + "php 페이지" 방식에서는 파일별로 직접 Model 호출

├── mysql-init/
│   └── schema.sql             # MySQL 초기 스키마 (테이블 생성 쿼리)

├── php/
│   └── Dockerfile             # PHP+Apache 이미지를 빌드하기 위한 Dockerfile
│                              # (pdo_mysql, mysqli 등 확장 설치 & Composer 등)

├── public/
│   ├── index.php              # 메인 페이지(간단 안내 or 홈)
│   │
│   ├── facilities/
│   │   ├── list.php           # 시설 목록
│   │   ├── create.php         # 시설 등록
│   │   ├── update.php         # 시설 수정
│   │   └── delete.php         # 시설 삭제
│   │
│   ├── reservations/
│   │   ├── list.php           # (전통) 예약 목록
│   │   ├── create.php         # (전통) 예약 생성
│   │   ├── update.php         # (전통) 예약 수정
│   │   ├── delete.php         # (전통) 예약 삭제
│   │
│   │   # jQuery Ajax 방식 (한 파일 안에 HTML + JS + PHP를 섞을 수도 있고)
│   │   ├── manage.php         # 예: jQuery로 Ajax( list, create, delete ) 처리
│   │   # 또는 api_list.php / api_create.php / api_delete.php 식으로 분리 가능
│
│   ├── users/
│   │   ├── login.php          # 로그인 (세션)
│   │   ├── logout.php         # 로그아웃
│   │   ├── register.php       # 회원가입
│   │   └── list.php           # 사용자 목록 (관리자용)
│
├── docker-compose.yml         # 전체 docker-compose 구성 (app, db, phpmyadmin)
└── ReadMe.md                  # 문서 (프로젝트 소개, 실행 방법 등)

```