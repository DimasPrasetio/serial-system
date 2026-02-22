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

## Workflow Release (Best Practice, Minimal)

### Sebelum D2P (di local)

1. Tentukan jenis release (`PATCH` / `MINOR` / `MAJOR`)
2. Update file `VERSION`
3. Pindahkan catatan perubahan yang siap rilis dari `Unreleased` ke section release baru di `CHANGELOG.md`
4. Commit perubahan versioning

Contoh:

```bash
git add VERSION CHANGELOG.md
git commit -m "chore(release): prepare v1.0.1"
git push origin main
```

### D2P (di server / Hostinger)

Ikuti panduan di `D2P_PRODUCTION_ROLLOUT.md`.

### Setelah D2P sukses (di local)

Buat tag release **annotated** lalu push:

```bash
git tag -a v1.0.1 -m "Release v1.0.1"
git push origin v1.0.1
```

Catatan:
- Tag dibuat **setelah** deploy production sukses (agar tag benar-benar merepresentasikan release yang live)
- Jangan pakai lightweight tag untuk release production

## Hotfix Workflow

Jika ada bug production yang harus cepat diperbaiki:

1. Buat fix
2. Bump `PATCH`
3. Update `CHANGELOG.md`
4. D2P
5. Tag release baru

Contoh:
- `v1.0.1` -> `v1.0.2`

## Checklist Release Singkat

Sebelum release:
- `VERSION` sudah benar
- `CHANGELOG.md` sudah diperbarui
- test utama lulus
- migration sudah direview

Setelah release:
- tag `vX.Y.Z` sudah dibuat dan dipush
- changelog sesuai release yang live
