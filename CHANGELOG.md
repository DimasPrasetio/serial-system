# Changelog

Semua perubahan penting pada project ini didokumentasikan di file ini.

Format mengikuti prinsip [Keep a Changelog](https://keepachangelog.com/en/1.1.0/) dan versi release mengikuti [Semantic Versioning](https://semver.org/).

## [Unreleased]

## [1.2.1] - 2026-03-27

### Added
- SEO: Open Graph meta tags (`og:title`, `og:description`, `og:url`, `og:image`, `og:type`, `og:site_name`, `og:locale`) ditambahkan ke layout publik agar pratinjau link di sosial media (WhatsApp, Facebook, dsb.) tampil dengan baik.
- SEO: Twitter Card meta tags (`twitter:card`, `twitter:title`, `twitter:description`, `twitter:image`) ditambahkan ke layout publik.
- SEO: Tag `<link rel="canonical">` ditambahkan ke layout publik, dapat di-override per halaman lewat `@section('canonical_url', ...)`.
- SEO: JSON-LD structured data `Organization` (Schema.org) ditambahkan ke layout publik agar Google dapat membaca informasi perusahaan (nama, alamat, kontak) sebagai rich result.
- Route baru `GET /sitemap.xml` yang menghasilkan sitemap dinamis berisi seluruh halaman publik (`/`, `/kebijakan-privasi`, `/ketentuan-layanan`), dengan URL diambil dari `APP_URL`.
- Route baru `GET /robots.txt` yang disajikan secara dinamis oleh Laravel; berisi aturan `Disallow` untuk `/admin/`, `/api/`, `/v1/`, serta pointer `Sitemap:` yang otomatis menggunakan `APP_URL`.

### Changed
- `public/robots.txt` (file statis) digantikan oleh route Laravel dinamis sehingga URL sitemap selalu sinkron dengan konfigurasi `APP_URL`.
- `company-profile.blade.php` ditambahkan `@section('canonical_url')` dan `@section('og_type')` secara eksplisit untuk halaman beranda.

## [1.2.0] - 2026-03-20

### Added
- Halaman publik `GET /kebijakan-privasi` dan `GET /ketentuan-layanan` dengan konten yang diturunkan dari data sistem yang nyata (data yang dikumpulkan, aturan lisensi, kontak resmi perusahaan).
- Footer landing page didesain ulang menjadi 3 kolom: brand + identitas hukum, navigasi (Tentang Kami, Kontak & Support), dan legal (Kebijakan Privasi, Ketentuan Layanan).
- Nama entitas hukum **PT. Prayora Karya Pratama** ditambahkan ke data perusahaan di `PublicController` dan ditampilkan di footer serta halaman legal.

### Fixed
- Pemilihan trial plan di `TrialLicenseService` diubah dari `.first()` ke `.latest()->first()` agar selalu menggunakan trial plan yang paling baru dibuat, bukan yang paling lama.

### Changed
- Admin panel: penambahan trial plan baru dengan `is_trial=true` kini diblokir apabila sudah ada trial plan aktif untuk aplikasi yang sama. Admin harus menonaktifkan trial lama terlebih dahulu sebelum membuat yang baru.

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
