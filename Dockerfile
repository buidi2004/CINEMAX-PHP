# Stage 1: Build dependencies
FROM composer:latest AS builder

WORKDIR /app
COPY composer.json ./
# Ignore errors if no lock file or missing dependencies initially
RUN composer install --no-dev --no-scripts --no-interaction --prefer-dist || true

# Stage 2: Production image
FROM webdevops/php-nginx:8.3-alpine

# Set Document Root for Nginx
ENV WEB_DOCUMENT_ROOT=/app/public
ENV PHP_DATE_TIMEZONE="UTC"

# Set working directory
WORKDIR /app

# Copy application files
COPY . /app/

# Copy vendor directory from builder
COPY --from=builder /app/vendor/ /app/vendor/

# Ensure proper permissions
RUN chown -R application:application /app

# Configure Nginx to listen on $PORT provided by Render
RUN echo '#!/bin/sh' > /opt/docker/provision/entrypoint.d/20-set-port.sh \
    && echo 'sed -i "s/listen 80;/listen ${PORT:-80};/g" /opt/docker/etc/nginx/vhost.conf' >> /opt/docker/provision/entrypoint.d/20-set-port.sh \
    && echo 'sed -i "s/listen \[::\]:80;/listen \[::\]:${PORT:-80};/g" /opt/docker/etc/nginx/vhost.conf' >> /opt/docker/provision/entrypoint.d/20-set-port.sh \
    && chmod +x /opt/docker/provision/entrypoint.d/20-set-port.sh

EXPOSE 80
