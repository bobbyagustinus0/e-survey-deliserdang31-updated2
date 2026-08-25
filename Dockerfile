# syntax=docker/dockerfile:1.4

# =========================
# Stage 1: Build Vite
# =========================
FROM node:20-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json* ./

RUN npm install

COPY . .

RUN npm run build


# =========================
# Stage 2: Laravel PHP
# =========================
FROM php:8.4-cli-alpine

# Install system dependencies + PHP extensions
RUN apk add --no-cache \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install Composer dependencies
COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist

# Copy Laravel application
COPY . .

# Copy Vite build
COPY --from=assets /app/public/build ./public/build

# Prepare Laravel
RUN mkdir -p \
        storage/framework/sessions \
        storage/framework/views \
        storage/framework/cache \
        storage/logs \
        bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && composer dump-autoload --optimize

# =========================
# Entrypoint
# =========================
RUN cat <<'EOF' > /entrypoint.sh
#!/bin/sh
set -e

echo "Starting Laravel..."

# Generate APP_KEY only if it doesn't exist
if [ -z "$APP_KEY" ]; then
    echo "APP_KEY is missing, generating..."
    php artisan key:generate --force
fi

# Create storage link
php artisan storage:link || true

# Clear old Laravel caches
php artisan optimize:clear

# Cache configuration and routes
php artisan config:cache
php artisan route:cache

# Run database migrations
php artisan migrate --force

# Railway PORT
PORT="${PORT:-8080}"

echo "Starting Laravel on port $PORT..."

exec php artisan serve \
    --host=0.0.0.0 \
    --port="$PORT"
EOF

RUN chmod +x /entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["/entrypoint.sh"]
