
# ==========================================
# Etapa 1: Compilar los recursos frontend
# ==========================================
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


# ==========================================
# Etapa 2: Aplicación Laravel + Apache
# ==========================================
FROM php:8.3-apache

WORKDIR /var/www/html

# Dependencias del sistema y extensiones PHP
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libsqlite3-dev \
    unzip \
    && docker-php-ext-install \
    pdo_sqlite \
    mbstring \
    bcmath \
    intl \
    zip \
    opcache \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configurar Apache para servir Laravel desde /public
RUN a2enmod rewrite headers \
    && sed -ri 's!/var/www/html!/var/www/html/public!g' \
       /etc/apache2/sites-available/000-default.conf \
    && sed -ri 's/<VirtualHost \*:80>/<VirtualHost *:10000>/' \
       /etc/apache2/sites-available/000-default.conf \
    && sed -ri 's/^Listen 80$/Listen 10000/' \
       /etc/apache2/ports.conf

# Copiar aplicación
COPY . .

# Instalar dependencias PHP de producción
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

# Copiar recursos frontend compilados
COPY --from=frontend /app/public/build ./public/build

# Preparar directorios de Laravel
RUN mkdir -p \
    database \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data \
       storage bootstrap/cache database

# Puerto utilizado por Render
EXPOSE 10000

# Inicializar Laravel
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
