# Release Versioning

Panduan ini mendefinisikan cara versioning release project agar konsisten, mudah rollback, dan mudah diaudit.

## Tujuan

- Menentukan versi release secara jelas untuk setiap deploy production
- Memudahkan rollback dan investigasi incident
- Menjaga kompatibilitas API dan perubahan database tetap terkontrol

## Single Source of Truth

- File versi aktif project: `VERSION`
- Riwayat perubahan release: `CHANGELOG.md`
- Git annotated tag sebagai penanda release production: `vX.Y.Z`

## Format Versi (SemVer)

Gunakan format: `MAJOR.MINOR.PATCH`

- `MAJOR`:
  - perubahan incompatible / breaking change
  - perubahan kontrak API yang tidak kompatibel (mis. API v2)
- `MINOR`:
  - fitur baru kompatibel
  - endpoint baru kompatibel
  - penambahan modul/admin capability tanpa breaking
- `PATCH`:
  - bug fix
  - hardening/security fix
  - perbaikan performa tanpa mengubah contract

## Aturan Praktis untuk Project Ini

- Perubahan incompatible pada API `/v1/*` **tidak boleh** masuk sebagai patch/minor.
- Jika kontrak API berubah incompatible:
  - buat versi API baru (mis. `/v2/licenses`)
  - pertimbangkan bump `MAJOR`.
- Migration schema kompatibel (index, kolom nullable, dsb) biasanya `PATCH` atau `MINOR` tergantung dampak fitur.

## Workflow Release

### 1. Siapkan release di local

1. Tentukan jenis release (`PATCH` / `MINOR` / `MAJOR`)
2. Update file `VERSION`
3. Pindahkan catatan perubahan dari `[Unreleased]` ke section release baru di `CHANGELOG.md`
4. Commit dan push ke `main`

```bash
git add VERSION CHANGELOG.md
git commit -m "chore(release): prepare v1.0.1"
git push origin main
```

### 2. Buat dan push annotated tag

Tag dibuat **sebelum D2P** — tag adalah anchor dari versi yang akan di-deploy.

```bash
git tag -a v1.0.1 -m "Release v1.0.1"
git push origin v1.0.1
```

Catatan:
- Selalu gunakan **annotated tag** (`-a`), bukan lightweight tag
- Tag ini yang menjadi referensi deploy di server

### 3. D2P (di server / Hostinger)

Deploy dari tag yang sudah dibuat. Ikuti panduan di `D2P_PRODUCTION_ROLLOUT.md`.

### Jika D2P gagal karena perlu perubahan code

Jangan hapus tag yang sudah ada. Buat fix, lalu rilis versi baru:

- Buat fix di local
- Bump `PATCH` (mis. `v1.0.1` → `v1.0.2`)
- Ulangi workflow dari langkah 1

## Hotfix Workflow

Jika ada bug production yang harus cepat diperbaiki:

1. Buat fix di local
2. Bump `PATCH`, update `CHANGELOG.md`
3. Commit + push ke `main`
4. Buat dan push tag baru
5. D2P dari tag baru

Contoh: `v1.0.1` → `v1.0.2`

## Checklist Release Singkat

Sebelum D2P:
- [ ] `VERSION` sudah benar
- [ ] `CHANGELOG.md` sudah diperbarui (Unreleased dipindah ke versi baru)
- [ ] Commit release sudah di-push ke `main`
- [ ] Annotated tag `vX.Y.Z` sudah dibuat dan di-push

Setelah D2P:
- [ ] Smoke test API lulus
- [ ] Tidak ada error di `storage/logs/laravel.log`
