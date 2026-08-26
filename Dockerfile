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
FROM php:8.4-cli

# =========================
# Install system dependencies
# =========================
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libzip-dev \
    libonig-dev \
    libicu-dev \
    default-mysql-client \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl \
    && rm -rf /var/lib/apt/lists/*


# =========================
# Install Composer
# =========================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html


# =========================
# Install Laravel dependencies
# =========================
COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist


# =========================
# Copy Laravel application
# =========================
COPY . .


# =========================
# Copy Vite build
# =========================
COPY --from=assets /app/public/build ./public/build


# =========================
# Prepare Laravel
# =========================
RUN mkdir -p \
        storage/framework/sessions \
        storage/framework/views \
        storage/framework/cache \
        storage/logs \
        bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && composer dump-autoload --optimize


# =========================
# Check MySQL dump client
# =========================
RUN echo "Checking MySQL client..." \
    && which mysqldump \
    && mysqldump --version


# =========================
# Entrypoint
# =========================
RUN cat <<'EOF' > /entrypoint.sh
#!/bin/sh
set -e

echo "======================================"
echo "Starting Laravel..."
echo "======================================"


# =========================
# Ensure .env exists
# =========================
if [ ! -f .env ]; then
    echo ".env not found, creating empty one..."
    touch .env
fi


# =========================
# Check APP_KEY
# =========================
if [ -z "$APP_KEY" ]; then
    echo "APP_KEY is missing, generating..."
    php artisan key:generate --force
else
    echo "APP_KEY exists."
fi


# =========================
# Storage link
# =========================
echo "Creating storage link..."

php artisan storage:link || true


# =========================
# Database migration
# =========================
echo "Running database migrations..."

php artisan migrate --force


# =========================
# Clear Laravel cache
# =========================
echo "Clearing Laravel cache..."

php artisan optimize:clear


# =========================
# Cache configuration
# =========================
echo "Caching Laravel configuration..."

php artisan config:cache


# =========================
# Cache routes
# =========================
echo "Caching Laravel routes..."

php artisan route:cache


# =========================
# Railway PORT
# =========================
PORT="${PORT:-8080}"

echo "======================================"
echo "Laravel is starting..."
echo "Port: $PORT"
echo "======================================"


# =========================
# Start Laravel
# =========================
exec php artisan serve \
    --host=0.0.0.0 \
    --port="$PORT"
EOF


RUN chmod +x /entrypoint.sh


# =========================
# Railway port
# =========================
EXPOSE 8080


# =========================
# Start container
# =========================
ENTRYPOINT ["/entrypoint.sh"]