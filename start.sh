#!/bin/bash
set -e

echo "Running migrations..."
php artisan migrate --force || echo "Migration failed, continuing..."

echo "Running seeders..."
php artisan db:seed --force || echo "Seeding failed, continuing..."

echo "Caching config..."
php artisan config:cache || echo "Config cache failed, continuing..."

echo "Starting server..."
php artisan serve --host=0.0.0.0 --port=$PORT
