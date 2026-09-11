# ---- Node stage: build frontend assets (public/build is gitignored) ----
FROM node:22-slim AS assets

WORKDIR /src

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build

# ---- Final FrankenPHP image ----
FROM dunglas/frankenphp:1-php8.5

# Install Composer plus the required PHP extensions (including MySQL)
RUN install-php-extensions \
    @composer \
    pcntl \
    pdo_mysql \
    opcache \
    intl \
    zip

# Set working directory inside the container
WORKDIR /app

# Copy the Laravel application files
COPY . /app

# Copy the freshly built frontend assets
COPY --from=assets /src/public/build /app/public/build

# Install production dependencies via Composer
RUN composer install --no-dev --optimize-autoloader

# Make storage writable
RUN chmod -R 775 storage bootstrap/cache

# Expose the Render HTTP port (default 10000)
EXPOSE 10000

# Cache config/route/view at container startup (so Render's runtime env vars are
# picked up), run migrations, then start FrankenPHP via Octane on $PORT.
ENTRYPOINT ["/bin/sh", "-c"]
CMD ["php artisan config:cache --quiet && php artisan route:cache --quiet && php artisan view:cache --quiet && php artisan migrate --force --quiet && exec php artisan octane:frankenphp --host=0.0.0.0 --port=${PORT:-10000}"]