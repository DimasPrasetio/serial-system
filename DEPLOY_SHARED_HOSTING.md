# Deployment Checklist (Shared Hosting)

## 1) Environment
- PHP 8.1+
- MySQL 8+
- Extensions: `pdo_mysql`, `openssl`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`

## 2) `.env` minimum
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://your-domain`
- `CACHE_DRIVER=file`
- `SESSION_DRIVER=file`
- `QUEUE_CONNECTION=database` atau `sync`
- `DB_CONNECTION=mysql`
- `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

## 3) Install & migrate
```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan db:seed --class=AdminRolePermissionSeeder --force
```

## 4) Cache optimize
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 5) Scheduler cPanel
Tambahkan cron:
```bash
* * * * * php /home/USER/path-to-project/artisan schedule:run >> /dev/null 2>&1
```

## 6) Public entrypoint
- Pastikan docroot mengarah ke folder `public/`.
- Pastikan `storage/` dan `bootstrap/cache/` writable.

## 7) Default admin seeder
- Email: `admin@example.com`
- Password: `Admin12345`
- Segera ganti password setelah login pertama.
