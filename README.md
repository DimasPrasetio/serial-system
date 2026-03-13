# Serial System

`serial-system` adalah backend Laravel untuk:

- License API desktop application
- Admin panel operasional
- Public API landing BLASKU yang dikonsumsi `blasku-reach-grow`

## Stack

- Laravel 10
- PHP 8.1+
- MySQL
- Vite untuk asset admin/public

## Modul utama

- License API: `/v1/licenses/*`
- Health check: `GET /v1/ping`
- Public landing API BLASKU:
  - `GET /api/v1/public/pricing-plans`
  - `GET /api/v1/public/installer`
  - `GET /api/v1/public/trial`
  - `GET /api/v1/public/contact`
- Admin panel: `/admin/*`

## Setup singkat local

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
npm run build
php artisan serve
```

## Dokumen penting

- Deploy shared hosting: `DEPLOY_SHARED_HOSTING.md`
- D2P production rollout: `D2P_PRODUCTION_ROLLOUT.md`
- Release versioning: `RELEASE_VERSIONING.md`
- Changelog: `CHANGELOG.md`

## Catatan deploy BLASKU landing

- Konten landing BLASKU dikelola dari admin panel menu `Landing BLASKU`
- Order method landing BLASKU saat ini adalah WhatsApp direct
- Seeder `BlaskuIntegrationSeeder` aman dipakai untuk bootstrap baseline landing yang belum ada, tanpa menimpa konten landing yang sudah disesuaikan admin
