CREATE DATABASE IF NOT EXISTS sports_db;
USE sports_db;

CREATE TABLE IF NOT EXISTS users (
    user_id   INT AUTO_INCREMENT PRIMARY KEY,
    username  VARCHAR(50) NOT NULL UNIQUE,
    password  VARCHAR(255) NOT NULL,
    role      VARCHAR(20) DEFAULT 'USER'
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS facilities (
  facility_id   INT AUTO_INCREMENT PRIMARY KEY,
  facility_name VARCHAR(100) NOT NULL,
  description   TEXT,
  max_capacity  INT DEFAULT 0,
  created_at    DATETIME DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE IF NOT EXISTS reservations (
  reservation_id INT AUTO_INCREMENT PRIMARY KEY,
  facility_id    INT NOT NULL,
  user_id        INT NOT NULL,
  start_time     DATETIME NOT NULL,
  end_time       DATETIME NOT NULL,
  note           TEXT,
  created_at     DATETIME DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (facility_id) REFERENCES facilities(facility_id),
  FOREIGN KEY (user_id)     REFERENCES users(user_id)
);
