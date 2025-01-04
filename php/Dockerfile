# php:8.1-fpm 이미지를 기반으로
FROM php:8.1-fpm

# 필요한 PHP 확장 설치 (pdo_mysql 등)
RUN docker-php-ext-install pdo pdo_mysql

# 만약 추가 라이브러리가 필요하다면 아래처럼 작성
# RUN apt-get update && apt-get install -y \
#     libfreetype6-dev \
#     libjpeg62-turbo-dev \
#     libpng-dev \
#  && docker-php-ext-install gd

# (선택) Xdebug, Composer 등을 설치할 수 있음
# COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html
