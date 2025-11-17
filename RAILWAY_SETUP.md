# Railway Deployment Setup

## Prerequisites
Railway akan otomatis menyediakan database MySQL atau PostgreSQL saat Anda tambahkan service database.

## Environment Variables yang Harus Diset di Railway

### 1. Database Configuration
Railway biasanya menyediakan `DATABASE_URL` otomatis. Jika tidak, set manual:
```
DB_CONNECTION=mysql
DB_HOST=<railway-db-host>
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=<railway-db-username>
DB_PASSWORD=<railway-db-password>
```

### 2. Admin Default Credentials
```
ADMIN_NAME=admin
ADMIN_EMAIL=admin@example.com
ADMIN_PASSWORD=<gunakan-password-kuat>
```

⚠️ **PENTING**: Ganti `ADMIN_PASSWORD` dengan password yang kuat untuk production!

### 3. Laravel Configuration
```
APP_ENV=production
APP_DEBUG=false
APP_KEY=<generate-dengan-php-artisan-key-generate>
APP_URL=<url-railway-anda>
```

## Deploy Command
Pastikan Railway menjalankan migration saat deploy. Tambahkan di **Settings > Deploy**:

### Start Command:
```bash
php artisan migrate --force --seed && php artisan config:cache && php artisan serve --host=0.0.0.0 --port=$PORT
```

Atau gunakan custom build script di `railway.json` atau `Procfile`.

## Cara Deploy
1. Connect repository GitHub ke Railway
2. Tambahkan MySQL/PostgreSQL database service di Railway
3. Set environment variables di atas
4. Deploy akan berjalan otomatis
5. Setelah deploy, akses aplikasi dan login dengan kredensial admin

## Login Credentials (Default)
- Email: `admin@example.com`
- Password: (sesuai yang Anda set di `ADMIN_PASSWORD`)
- Role: `admin`

## Troubleshooting

### Error: Database file does not exist (SQLite)
- Pastikan `DB_CONNECTION=mysql` atau `pgsql` di Railway, bukan `sqlite`
- Railway environment otomatis menggunakan MySQL/PostgreSQL

### Error: SQLSTATE[HY000] [2002] Connection refused
- Pastikan database service sudah ter-deploy di Railway
- Cek environment variables database sudah benar

### Admin tidak bisa login
- Pastikan `php artisan migrate --seed` sudah dijalankan
- Cek environment variables `ADMIN_EMAIL` dan `ADMIN_PASSWORD` sudah benar
- Password harus sama dengan yang di-hash saat seeding
