# D2P Production Rollout (Hostinger Shared Hosting)

Panduan ini adalah versi **Hostinger Shared Hosting** untuk deploy perubahan hardening concurrency pada License API dan migration index/constraint secara aman di production.

## Apa yang Sudah Disiapkan

- Hardening concurrency pada:
  - `activate` (serial lock + re-check di transaction)
  - `trial` (duplicate trial claim handling)
  - `renew` (renew serial lock + re-check di transaction)
- Command audit integritas data:
  - `php artisan licenses:audit-integrity`
- Migration hardening runtime:
  - unique `licenses.issued_serial_number_id`
  - index `licenses(status, expires_at_utc)`
  - index `license_tokens(revoked_at_utc, expires_at_utc)`

## Tujuan Rollout

- Mencegah double-activation / double-renew saat request concurrent.
- Menjaga konsistensi data existing.
- Membuat query runtime/scheduler lebih efisien saat data membesar.

## Strategy (Disarankan)

Gunakan **2 tahap**:

1. **Deploy code lebih dulu** (aman untuk existing data)
2. **Jalankan audit + migration hardening** saat jam sepi

## Pre-D2P Checklist (Hostinger Shared)

- Pastikan backup database terbaru tersedia.
- Pastikan Anda punya akses:
  - hPanel Hostinger
  - Database (phpMyAdmin / remote client)
  - File Manager / FTP / Git deploy (sesuai alur Anda)
- Pastikan environment production memakai:
  - `APP_ENV=production`
  - `APP_DEBUG=false`
- Pastikan Anda tahu cara rollback release sebelumnya.
- Tentukan versi release berikutnya (`PATCH` / `MINOR` / `MAJOR`) sesuai `RELEASE_VERSIONING.md`.
- Update file `VERSION` dan `CHANGELOG.md` **di local** sebelum mulai D2P.
- Pastikan file `.env` production **tetap** memakai setup shared hosting Anda saat ini (tidak perlu Redis):
  - `CACHE_DRIVER=file`
  - `SESSION_DRIVER=file`
  - `QUEUE_CONNECTION=sync`

## Struktur Path yang Dipakai (Sesuaikan Dulu)

Contoh path umum Hostinger shared:

- Project root (di luar web root): `/home/u123456789/domains/domainanda.com/`
- Public web root: `/home/u123456789/domains/domainanda.com/public_html/`

Jika project Laravel Anda ditempatkan berbeda, sesuaikan semua command di bawah.

## Tahap D2P (Jam Sepi) - Hostinger Shared

### 1. Build release di lokal (disarankan, bukan di server shared)

Jalankan di komputer/dev machine Anda:

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
```

Catatan:
- Shared hosting sering tidak ideal untuk build asset (`npm ci`, `npm run build`) di server.
- Upload hasil build (`public/build`) bersama source code release.

### 2. Upload / deploy release ke Hostinger

Pilih salah satu alur:

1. Git deploy via SSH (jika Anda gunakan)
2. Upload ZIP release lalu extract
3. FTP/SFTP

Pastikan file yang ter-upload mencakup:
- perubahan source code
- file migration baru
- file `public/build/*` hasil build lokal
- file `VERSION` dan `CHANGELOG.md` yang sudah diupdate

### 3. Jalankan preflight audit integritas data (WAJIB)

```bash
php artisan licenses:audit-integrity --fail-on-issues
```

Jika command ini mengembalikan issue:
- **Jangan lanjut migration hardening dulu**
- Perbaiki data terlebih dahulu

### 4. Jalankan migration (saat audit bersih)

```bash
php artisan migrate --force
```

Catatan:
- Migration hardening akan **menolak berjalan** jika ada duplicate `licenses.issued_serial_number_id`
- Ini mencegah perubahan schema yang berisiko pada data bermasalah

### 5. Optimasi cache Laravel (production, shared-hosting safe)

```bash
php artisan optimize:clear
php artisan config:cache
php artisan view:cache
```

Catatan penting untuk project Anda saat ini:
- **Jangan jalankan `php artisan route:cache` dulu** karena ada route closure (`/api/v1/ping`) yang biasanya membuat route cache gagal.
- Jika nanti route closure sudah diubah ke controller, Anda bisa tambahkan `route:cache`.

### 6. Queue worker / process (untuk project Anda saat ini: skip)

Karena `.env` Anda saat ini memakai:
- `QUEUE_CONNECTION=sync`

Maka **tidak perlu** `queue:restart` atau Supervisor worker.

### 7. Finalisasi release tag (setelah deploy sukses, dilakukan di local)

Setelah smoke test production lulus, buat **annotated git tag** dari commit release yang sudah live:

```bash
git tag -a vX.Y.Z -m "Release vX.Y.Z"
git push origin vX.Y.Z
```

Contoh:

```bash
git tag -a v1.0.1 -m "Release v1.0.1"
git push origin v1.0.1
```

Catatan:
- Tag dibuat **setelah** D2P sukses (bukan sebelum), agar tag merepresentasikan versi yang benar-benar live.
- Lihat `RELEASE_VERSIONING.md` untuk aturan bump versi.

## Smoke Test Setelah D2P

### Public

- Buka `/`
- Pastikan landing page render normal
- Cek navbar/logo/favicons tampil benar

### API

- `GET /api/v1/ping` → harus `200`
- Tes `activate`, `trial`, `status`, `renew` dengan skenario normal
- Tes ulang serial yang sama (harus ditolak sesuai rule)

### Admin

- Login admin
- Buka dashboard, serials, licenses
- Cek action reveal/void/revoke tetap normal

## Rollback Plan (Jika Ada Masalah)

### Jika masalah hanya di code (tanpa migration)

- Rollback release aplikasi ke versi sebelumnya

### Jika migration sudah jalan

- Jangan langsung rollback code tanpa evaluasi
- Index/constraint baru umumnya aman dipertahankan
- Jika benar-benar perlu revert migration:

```bash
php artisan migrate:rollback --step=1 --force
```

Lakukan hanya jika Anda yakin tidak ada data baru yang bergantung pada constraint tersebut.

## Rekomendasi Tahap Berikutnya (Opsional, Bukan Bagian Hardening Ini)

Untuk concurrency dan throughput production yang lebih baik:

1. Pindahkan `CACHE_DRIVER` ke `redis`
2. Pindahkan `SESSION_DRIVER` ke `redis`
3. Pertimbangkan `QUEUE_CONNECTION=redis` + worker
4. Review rate limit `license-critical` jika banyak user berada di IP yang sama

## Cron Job Hostinger (Laravel Scheduler) - Dibutuhkan atau Tidak?

### Apakah project Anda membutuhkannya?

**Ya, disarankan (praktis: iya, perlu).**

Project Anda punya scheduler di `app/Console/Kernel.php` untuk:
- `licenses:sync-statuses` (setiap 5 menit)
- `licenses:cleanup-tokens` (harian)

Jika cron scheduler **tidak** dijalankan:
- API masih bisa jalan (karena sebagian cek expired dilakukan saat request)
- Tapi sinkronisasi status expired massal dan cleanup token lama **tidak berjalan otomatis**

### Best Practice di Laravel (termasuk shared hosting)

Set **1 cron job** yang menjalankan:

```bash
php artisan schedule:run
```

Laravel akan menjalankan command terjadwal sesuai definisi di `Kernel`.

### Cara Set Cron Job di Hostinger hPanel (Shared Hosting)

1. Masuk ke `hPanel`
2. Buka menu `Advanced` -> `Cron Jobs`
3. Klik `Create Cron Job` / `Add Cron Job`
4. Pilih interval:
   - `Once Per Minute` (setiap 1 menit)
5. Isi command cron

### Command Cron (Template Hostinger Shared)

Gunakan salah satu format berikut (sesuaikan path project Anda):

```bash
/usr/bin/php /home/USERNAME/domains/DOMAIN/public_html/artisan schedule:run >> /dev/null 2>&1
```

Atau jika Laravel root Anda **bukan** `public_html` (lebih umum/lebih rapi), misalnya project root terpisah:

```bash
/usr/bin/php /home/USERNAME/domains/DOMAIN/laravel/artisan schedule:run >> /dev/null 2>&1
```

### Cara Menentukan Path yang Benar

Jika SSH tersedia:

```bash
pwd
which php
ls -la
```

Lalu pastikan:
- path `artisan` benar-benar ada
- binary PHP CLI valid (sering `/usr/bin/php`)

Jika SSH tidak tersedia:
- cek lokasi file `artisan` melalui File Manager Hostinger
- gunakan `php` atau `/usr/bin/php` sesuai yang didukung server Anda

### Opsi Debug Cron (sementara, lalu matikan)

Kalau mau memastikan cron jalan, pakai log file sementara:

```bash
/usr/bin/php /home/USERNAME/domains/DOMAIN/public_html/artisan schedule:run >> /home/USERNAME/cron-laravel.log 2>&1
```

Setelah terbukti berjalan normal, ganti kembali ke `>> /dev/null 2>&1`.

### Verifikasi Setelah Set Cron

1. Jalankan manual sekali:
   ```bash
   php artisan schedule:run
   ```
2. Tunggu 5-10 menit
3. Cek:
   - tidak ada error di `storage/logs/laravel.log`
   - command scheduler berjalan sesuai jadwal

### Jika Cron Tidak Bisa Jalan dari `public_html`

Itu biasanya berarti struktur deploy Laravel di shared hosting perlu dirapikan:
- `artisan` seharusnya berada di root project Laravel
- `public` (isi) yang dipublikasikan ke `public_html`

Jika Anda mau, saya bisa bantu buatkan struktur deploy Hostinger yang rapi (`project root + public_html`) khusus untuk Laravel Anda.
