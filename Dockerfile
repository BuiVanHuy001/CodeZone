# --- STAGE 1: Base ---
# Nền tảng PHP với các extension cần thiết cho Laravel
FROM php:8.2-fpm-alpine AS base

# Cài đặt các package hệ thống cần thiết
# gd, exif, bcmath, pdo_mysql là các extension phổ biến cho Laravel
RUN apk add --no-cache \
    $PHPIZE_DEPS \
    git \
    curl \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev

# Cài đặt các PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    zip \
    gd \
    exif \
    pcntl \
    bcmath

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Tạo user nếu chưa tồn tại (tránh lỗi "group 'www-data' in use")
RUN adduser -u 1000 -S -G www-data www-data || true

# Đặt thư mục làm việc
WORKDIR /var/www/html

# --- STAGE 2: Composer Dependencies ---
FROM base AS vendor

COPY database/ database/
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --prefer-dist \
    && composer dump-autoload --optimize

# --- STAGE 3: Frontend Assets ---
FROM node:20-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm install

COPY vite.config.js ./
COPY resources/ resources/
RUN npm run build

# --- STAGE 4: Production Image ---
FROM base AS production

# Copy toàn bộ code
COPY . .

# Copy vendor từ stage 'vendor'
COPY --from=vendor /var/www/html/vendor/ ./vendor/

# Copy assets đã build từ stage 'frontend'
COPY --from=frontend /app/public/build ./public/build

# Phân quyền cho thư mục storage và bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Chạy bằng user không phải root
USER www-data

# Tối ưu hóa cho Laravel production
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Expose port 9000 và khởi động php-fpm
EXPOSE 9000
CMD ["php-fpm"]
