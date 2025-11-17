# Railway Troubleshooting - Error 502

## Penyebab Umum Error 502:

### 1. **Database Connection Gagal**
Pastikan environment variables database sudah benar di Railway:
```
DB_CONNECTION=mysql
DB_HOST=<provided-by-railway>
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=<provided-by-railway>
DB_PASSWORD=<provided-by-railway>
```

Railway biasanya otomatis inject `DATABASE_URL`. Jika ada, Laravel akan menggunakannya.

### 2. **APP_KEY Belum Di-set**
```
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

Generate dengan:
```bash
php artisan key:generate --show
```
Lalu copy hasilnya ke Railway environment variables.

### 3. **Migration Gagal**
Jika tabel sudah ada, migration bisa gagal. Solusi:
- Hapus database dan buat ulang di Railway
- Atau skip migration dengan menghapus `--seed` dari startCommand

### 4. **Port Tidak Cocok**
Railway inject `$PORT` variable. Pastikan startCommand menggunakan:
```bash
php artisan serve --host=0.0.0.0 --port=$PORT
```

## Checklist Environment Variables Railway:

✅ **Wajib:**
- `APP_KEY` - Generate dari `php artisan key:generate --show`
- `APP_ENV=production`
- `APP_DEBUG=false`
- Database credentials (biasanya auto dari Railway MySQL service)

✅ **Admin Default:**
- `ADMIN_NAME=admin`
- `ADMIN_EMAIL=admin@example.com`
- `ADMIN_PASSWORD=password_kuat`

## Cara Debug di Railway:

1. **Lihat Logs:**
   - Buka Railway dashboard → project Anda → **Deployments**
   - Klik deployment terakhir → **View Logs**
   - Cari error message merah

2. **Common Error Messages:**

   **"Connection refused"**
   - Database belum ready atau credentials salah
   - Tunggu beberapa menit setelah add MySQL service
   - Pastikan MySQL service dalam status "Active"

   **"No application encryption key"**
   - Set `APP_KEY` di environment variables

   **"Class not found"**
   - Build gagal, cek build logs
   - Mungkin `composer install` error

   **"Port already in use"**
   - Restart deployment

3. **Test Database Connection:**
   Tambahkan route test (hapus setelah verify):
   ```php
   Route::get('/test-db', function() {
       try {
           \DB::connection()->getPdo();
           return "Database connected!";
       } catch (\Exception $e) {
           return "Database error: " . $e->getMessage();
       }
   });
   ```

## Start Script yang Lebih Aman:

File `start.sh` sudah dibuat dengan error handling:
```bash
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
```

Script ini akan tetap start server meskipun migration/seeding gagal.

## Solusi Cepat:

### Jika error terus:
1. **Simplify startCommand** di `railway.json`:
   ```json
   "startCommand": "php artisan serve --host=0.0.0.0 --port=$PORT"
   ```
   
2. **Manual Migration** (setelah app running):
   - Buka Railway **Shell** tab
   - Jalankan: `php artisan migrate --force`
   - Jalankan: `php artisan db:seed --force`

3. **Check PHP Version:**
   Railway default PHP 8.1+. Pastikan `composer.json` compatible:
   ```json
   "require": {
       "php": "^8.1"
   }
   ```

## Kontak Railway Support:
Jika masih error, screenshot logs dan tanya di:
- Railway Discord: https://discord.gg/railway
- Railway Help: https://help.railway.app
