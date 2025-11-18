#!/bin/bash
set -e

# Wait for database to be ready
echo "Waiting for database..."
sleep 5

echo "Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo "Running migrations..."
php artisan migrate --force || { echo "Migration failed!"; exit 1; }

echo "Running seeders..."
php artisan db:seed --force || echo "Seeding skipped (may already exist)..."

echo "Caching config..."
php artisan config:cache

echo "Creating storage link..."
php artisan storage:link || echo "Storage link exists..."

echo "Starting server..."
php artisan serve --host=0.0.0.0 --port=$PORT
