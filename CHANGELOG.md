# Changelog

Semua perubahan penting pada project ini didokumentasikan di file ini.

Format mengikuti prinsip [Keep a Changelog](https://keepachangelog.com/en/1.1.0/) dan versi release mengikuti [Semantic Versioning](https://semver.org/).

## [Unreleased]

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
