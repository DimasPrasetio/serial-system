# D2P Production Rollout (Hostinger Shared Hosting)

Panduan ini adalah flow deploy production untuk `serial-system` di domain `https://elcodelabs.com`.

## Scope saat ini

Release terkini membawa:

- License API dan admin panel utama
- Public API landing BLASKU:
  - `GET /api/v1/public/pricing-plans`
  - `GET /api/v1/public/installer`
  - `GET /api/v1/public/trial`
  - `GET /api/v1/public/contact`
- Admin menu `Landing BLASKU` dengan submenu terpisah
- Order method landing BLASKU via WhatsApp direct dengan template pesan yang bisa dikustom admin

## Pre-D2P Checklist

- Backup database production tersedia
- Tag release target sudah dibuat dan sudah ada di remote
- File `.env` production tetap memakai:
  - `APP_ENV=production`
  - `APP_DEBUG=false`
  - `APP_URL=https://elcodelabs.com`
  - `CACHE_DRIVER=file`
  - `SESSION_DRIVER=file`
  - `QUEUE_CONNECTION=sync`
- Anda tahu tag rollback sebelumnya

## Workflow Release Lokal

```bash
npm run release:prepare
git add .
git commit -m "feat/fix: deskripsi perubahan"
git add VERSION CHANGELOG.md
git commit -m "chore(release): prepare vX.Y.Z"
git push origin main
git tag -a vX.Y.Z -m "Release vX.Y.Z"
git push origin vX.Y.Z
```

## D2P di Server

Gunakan path production yang aktif di domain `.com`. Contoh:

```bash
cd ~/domains/elcodelabs.com/serial-system
git fetch --tags
git restore .
git checkout vX.Y.Z
```

Jika `composer.json` atau `composer.lock` berubah:

```bash
composer install --no-dev --optimize-autoloader
```

Jalankan migration:

```bash
php artisan migrate --force
```

Sinkronkan permission admin:

```bash
php artisan db:seed --class=AdminRolePermissionSeeder --force
```

Untuk rollout awal modul landing BLASKU, atau jika baseline record landing belum ada, jalankan juga:

```bash
php artisan db:seed --class=BlaskuIntegrationSeeder --force
```

Catatan:
- Seeder BLASKU sekarang aman untuk bootstrap baseline landing yang belum ada dan tidak menimpa konten landing yang sudah diubah admin.
- Hindari `php artisan db:seed --force` penuh pada production rutin jika tidak memang ingin menjalankan seluruh baseline project.
- Karena `npm run release:prepare` wajib dijalankan sebelum tag, artifact `public/build` sudah ikut terbawa saat `git checkout vX.Y.Z`.

## Web Root dan Symlink

Struktur yang direkomendasikan:

- project repo: `~/domains/elcodelabs.com/serial-system`
- web root aktif: `~/domains/elcodelabs.com/public_html`

Symlink yang direkomendasikan:

```bash
ln -s /home/USER/domains/elcodelabs.com/serial-system/public /home/USER/domains/elcodelabs.com/public_html
```

Verifikasi:

```bash
readlink -f ~/domains/elcodelabs.com/public_html
ls -lah ~/domains/elcodelabs.com/public_html/build/assets
```

## Optimasi Cache Production

```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Scheduler

Project ini membutuhkan scheduler untuk sinkronisasi status lisensi dan cleanup token.

Cron Hostinger yang direkomendasikan:

```bash
* * * * * /usr/bin/php /home/USER/domains/elcodelabs.com/serial-system/artisan schedule:run >> /dev/null 2>&1
```

## Smoke Test Setelah D2P

### Public / Web

- Buka `/`
- Pastikan company profile render normal
- Pastikan asset `/build/*` tidak `404`

### API

- `GET /v1/ping` harus `200`
- `GET /api/v1/public/pricing-plans` harus `200`
- `GET /api/v1/public/contact` harus `200`
- `POST /v1/licenses/activate` tetap sesuai kontrak lama
- `POST /v1/licenses/trial` tetap sesuai kontrak lama

### Admin

- Login admin berhasil
- Dashboard bisa dibuka
- Menu `Landing BLASKU` tampil
- Halaman `Pricing`, `Installer`, `Trial`, dan `Contact` bisa dibuka
- Ubah satu field di `Landing BLASKU > Contact`, simpan, lalu verifikasi `GET /api/v1/public/contact` memantulkan perubahan

## Rollback

Jika perlu rollback code:

```bash
cd ~/domains/elcodelabs.com/serial-system
git fetch --tags
git checkout vPREVIOUS
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Jika rollback menyentuh migration, evaluasi dulu kompatibilitas data sebelum menjalankan `migrate:rollback`.
