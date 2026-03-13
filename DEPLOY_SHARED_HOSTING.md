# Deployment Checklist (Shared Hosting)

Checklist singkat ini untuk deploy `serial-system` di shared hosting dengan production URL `https://elcodelabs.com`.

## 1) Environment minimum

- PHP `8.1+`
- MySQL `8+`
- Extension PHP: `pdo_mysql`, `openssl`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`
- Docroot mengarah ke folder `public/`
- Folder `storage/` dan `bootstrap/cache/` writable

## 2) `.env` production minimum

```dotenv
APP_NAME="El Code Labs Serial System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://elcodelabs.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

## 3) First deploy / fresh install

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan db:seed --class=AdminRolePermissionSeeder --force
php artisan db:seed --class=BlaskuIntegrationSeeder --force
```

Catatan:
- `AdminRolePermissionSeeder` membuat permission dan default admin.
- `BlaskuIntegrationSeeder` membuat baseline BLASKU termasuk pricing, installer, trial, contact, dan aman dipakai ulang untuk membuat record landing yang masih belum ada.

## 4) Existing production update

```bash
php artisan migrate --force
php artisan db:seed --class=AdminRolePermissionSeeder --force
```

Jalankan baseline BLASKU hanya jika record landing memang belum ada:

```bash
php artisan db:seed --class=BlaskuIntegrationSeeder --force
```

## 5) Cache optimize

```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 6) Scheduler cron

Tambahkan cron Hostinger/cPanel:

```bash
* * * * * /usr/bin/php /home/USER/domains/elcodelabs.com/production/artisan schedule:run >> /dev/null 2>&1
```

## 7) Smoke test minimum

- `GET /v1/ping` harus `200`
- `GET /api/v1/public/pricing-plans` harus `200`
- `GET /api/v1/public/contact` harus `200`
- Login admin berhasil
- Menu `Landing BLASKU` tampil
- Halaman `Pricing`, `Installer`, `Trial`, dan `Contact` bisa dibuka

## 8) Default admin

- Email: `admin@example.com`
- Password: `Admin12345`
- Segera ganti password setelah login pertama
