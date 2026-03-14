# Changelog

Semua perubahan penting pada project ini didokumentasikan di file ini.

Format mengikuti prinsip [Keep a Changelog](https://keepachangelog.com/en/1.1.0/) dan versi release mengikuti [Semantic Versioning](https://semver.org/).

## [Unreleased]

## [1.1.5] - 2026-03-14

### Fixed
- Wiring middleware throttle pada `routes/api.php` diselaraskan dengan limiter baru (`license-read` dan `license-write`) agar endpoint lisensi tidak lagi mereferensikan limiter lama `license-critical`.

## [1.1.4] - 2026-03-14

### Changed
- Rate limiting API disesuaikan untuk pola polling agar lebih andal: endpoint read (`/v1/licenses/status` dan `/v1/licenses/devices`) sekarang memakai limiter `license-read` yang berbasis identitas token dan lebih longgar.
- Endpoint write lisensi (`activate`, `trial`, `renew`, dan `devices/deactivate`) dipisah ke limiter `license-write` agar tetap protektif tanpa mengganggu traffic polling.
- Baseline limiter group `api` ditingkatkan untuk mengurangi false-positive throttling pada beban request yang lebih tinggi.

## [1.1.3] - 2026-03-13

### Added
- Helper release baru `npm run release:prepare` untuk menjalankan build dan memverifikasi artifact `public/build` sebelum tag release dibuat.

### Changed
- Panduan release sekarang mewajibkan proses build asset sebelum commit release dan pembuatan tag.
- Panduan deploy shared hosting dan D2P diselaraskan dengan struktur server `serial-system` dan penggunaan symlink `public_html -> serial-system/public`.

## [1.1.2] - 2026-03-13

### Changed
- `BlaskuIntegrationSeeder` sekarang hanya melakukan bootstrap record landing BLASKU yang belum ada, sehingga aman dipakai untuk rollout baseline tanpa menimpa konten landing yang sudah disesuaikan admin.
- Panduan deploy shared hosting dan D2P production diperbarui agar sesuai dengan flow production `elcodelabs.com`, cache command yang valid saat ini, dan smoke test untuk public API landing BLASKU.
- README dan `.env.example` diselaraskan dengan identitas project `serial-system` agar setup dan deploy tidak lagi mengacu ke skeleton Laravel generik.

## [1.1.1] - 2026-03-13

### Added
- Template pesan order WhatsApp terpisah untuk alur `Tanya & Order` langsung dari landing page BLASKU.
- Submenu admin `Landing BLASKU` yang memisahkan halaman `Ringkasan`, `Pricing`, `Installer`, `Trial`, dan `Contact`.

### Changed
- Response `GET /api/v1/public/contact` sekarang menegaskan metode order `whatsapp_direct`, tujuan nomor, CTA, dan template pesan order yang bisa dikustom dari admin panel.
- Admin panel `Landing BLASKU > Contact` sekarang mengelola template pesan WhatsApp umum dan template pesan order secara terpisah.

## [1.1.0] - 2026-03-13

### Added
- Public API baru untuk landing page BLASKU:
  - `GET /api/v1/public/pricing-plans`
  - `GET /api/v1/public/installer`
  - `GET /api/v1/public/trial`
  - `GET /api/v1/public/contact`
- Modul admin baru `Landing BLASKU` untuk mengelola konten landing page langsung dari `serial-system`.
- Schema dan model baru untuk pricing plans, installer, trial setting, dan contact setting landing BLASKU.
- Seeder default untuk konten landing BLASKU agar admin panel dan public API langsung memiliki baseline data.
- Feature test untuk kontrak public API landing BLASKU.

### Changed
- Permission admin ditambah dengan `manage-blasku-landing` agar pengelolaan landing BLASKU bisa dibatasi per role.
- Application `BLASKU` sekarang juga menjadi source of truth untuk data public landing page, bukan hanya lisensi desktop app.

## [1.0.5] - 2026-03-01

### Fixed
- Asset 3D Spline untuk landing page sekarang di-load dari `public/build/assets/spline/*` agar ikut alur deploy shared-hosting yang memang sudah mem-publish `public/build`.

### Changed
- `npm run build` sekarang juga menyalin static runtime assets Spline ke `public/build/assets/spline`.
- Panduan D2P dan shared-hosting diperjelas agar smoke test memverifikasi asset 3D hero tidak 404.

## [1.0.2] - 2026-02-23

### Added
- `public/build` (Vite compiled assets) dilacak di git untuk mendukung atomic tag-based deployment di shared hosting.

### Changed
- `.gitignore`: hapus `/public/build` agar build assets ikut ter-commit.
- `D2P_PRODUCTION_ROLLOUT.md`: dokumentasi alur git-based deploy — clone untuk release pertama, `git fetch --tags && git restore . && git checkout vX.Y.Z` untuk release berikutnya.

## [1.0.1] - 2026-02-23

### Added
- Release versioning baseline (`VERSION`, `CHANGELOG.md`, dan panduan release process).
- Panduan D2P khusus Hostinger Shared Hosting.

### Changed
- Hardening concurrency untuk alur license activation, trial, dan renewal agar lebih aman pada concurrent request.
- Penambahan command audit integritas data dan migration hardening untuk rollout production yang lebih aman.

## [1.0.0] - 2026-02-22

### Added
- Baseline release formal pertama untuk project production ini (retroaktif) sebagai titik awal versioning release.
- License API v1 (`/v1/licenses/*`) dengan kontrak stabil.
- Admin panel Laravel (session-based) untuk aplikasi, plan, serial, lisensi, dan device management.
- Scheduler maintenance lisensi (sync expired status dan cleanup token).

### Notes
- Release ini dipakai sebagai titik awal penerapan release tagging dan changelog terstruktur.
