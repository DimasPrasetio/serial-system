@extends('admin.layouts.app')

@section('content')
<!-- docs-layout-v4 -->
<section data-docs-root>
    <div class="mb-4">
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Management</p>
        <h2 class="mt-1 text-3xl font-bold text-slate-800">Docs</h2>
    </div>

    <section class="panel mb-5">
        <div class="panel-body">
            <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-5">
                <button type="button" data-docs-tab-button="onboarding" class="btn-secondary h-11 w-full justify-center text-center">Onboarding</button>
                <button type="button" data-docs-tab-button="playbook" class="btn-secondary h-11 w-full justify-center text-center">Playbook</button>
                <button type="button" data-docs-tab-button="menus" class="btn-secondary h-11 w-full justify-center text-center">Referensi Menu</button>
                <button type="button" data-docs-tab-button="troubleshoot" class="btn-secondary h-11 w-full justify-center text-center">Troubleshoot</button>
                <button type="button" data-docs-tab-button="governance" class="btn-secondary h-11 w-full justify-center text-center">Governance</button>
            </div>
        </div>
    </section>

    <div data-docs-tab-panel="onboarding" class="panel panel-body space-y-4">
        <h3 class="text-xl font-semibold text-slate-800">Onboarding Cepat Admin Baru</h3>
        <p class="text-sm text-slate-500">Target: admin baru paham alur utama dalam 30 menit pertama.</p>
        <div class="grid gap-3 md:grid-cols-3">
            <article class="docs-item-accent">
                <p class="text-sm font-semibold text-slate-800">Langkah 1 (5 Menit)</p>
                <p class="mt-1 text-sm text-slate-500">Buka <strong>Dashboard</strong> untuk memahami metrik lisensi aktif, kedaluwarsa, dan nonaktif.</p>
            </article>
            <article class="docs-item-accent">
                <p class="text-sm font-semibold text-slate-800">Langkah 2 (10 Menit)</p>
                <p class="mt-1 text-sm text-slate-500">Pelajari struktur <strong>Aplikasi</strong> dan <strong>Paket</strong>, lalu coba buat satu data contoh.</p>
            </article>
            <article class="docs-item-accent">
                <p class="text-sm font-semibold text-slate-800">Langkah 3 (10 Menit)</p>
                <p class="mt-1 text-sm text-slate-500">Buat satu <strong>Kode Aktivasi</strong> pesanan user, lalu verifikasi penggunaan serial dan status lisensi di menu <strong>Lisensi</strong>.</p>
            </article>
        </div>
        <div class="docs-item">
            <p class="text-sm font-semibold text-slate-800">Checklist Kompetensi Dasar</p>
            <ul class="mt-2 space-y-2 text-sm text-slate-500">
                <li>Memahami perbedaan data <strong>Aplikasi</strong>, <strong>Paket</strong>, <strong>Kode Aktivasi</strong>, dan <strong>Lisensi</strong>.</li>
                <li>Dapat membuat kode aktivasi tanpa kesalahan relasi aplikasi/paket.</li>
                <li>Memahami flow aktivasi: <strong>Trial</strong> (email) dan <strong>Paid</strong> (email + serial activation).</li>
                <li>Dapat membaca status lisensi dan melakukan tindakan yang tepat.</li>
            </ul>
        </div>
    </div>

    <div data-docs-tab-panel="playbook" class="panel panel-body hidden space-y-4">
        <h3 class="text-xl font-semibold text-slate-800">Playbook Operasional</h3>
        <div class="grid gap-3 md:grid-cols-3">
            <article class="docs-item">
                <p class="text-sm font-semibold text-slate-800">Harian</p>
                <ul class="mt-2 space-y-1.5 text-sm text-slate-500">
                    <li>Review lisensi yang akan kedaluwarsa.</li>
                    <li>Cek kode aktivasi terbaru (status: available/used/void).</li>
                    <li>Pastikan tidak ada anomali status lisensi.</li>
                </ul>
            </article>
            <article class="docs-item">
                <p class="text-sm font-semibold text-slate-800">Mingguan</p>
                <ul class="mt-2 space-y-1.5 text-sm text-slate-500">
                    <li>Audit akun admin aktif dan hak aksesnya.</li>
                    <li>Review paket yang tidak lagi dipakai.</li>
                    <li>Evaluasi volume aktivasi per aplikasi.</li>
                </ul>
            </article>
            <article class="docs-item">
                <p class="text-sm font-semibold text-slate-800">Bulanan</p>
                <ul class="mt-2 space-y-1.5 text-sm text-slate-500">
                    <li>Rotasi token aplikasi berisiko tinggi.</li>
                    <li>Sinkronisasi SOP dengan tim support.</li>
                    <li>Review indikator performa dan error operasional.</li>
                </ul>
            </article>
        </div>

        <div class="docs-item-accent">
            <p class="text-sm font-semibold text-slate-800">Alur Kerja Paling Direkomendasikan</p>
            <ol class="mt-2 space-y-2 text-sm text-slate-500">
                <li>1. Setup <strong>Aplikasi</strong> dengan identitas dan token yang valid.</li>
                <li>2. Buat <strong>Paket</strong> sesuai kebijakan durasi dan batas perangkat.</li>
                <li>3. Generate <strong>Kode Aktivasi</strong> pesanan user berdasarkan aplikasi + paket paid.</li>
                <li>4. User melakukan aktivasi (Trial: email, Paid: email + serial activation), lalu admin monitor hasilnya di menu <strong>Lisensi</strong>.</li>
            </ol>
        </div>
    </div>

    <div data-docs-tab-panel="menus" class="panel panel-body hidden space-y-3">
        <h3 class="text-xl font-semibold text-slate-800">Referensi Tiap Menu</h3>

        <details class="docs-item" open>
            <summary class="cursor-pointer text-sm font-semibold text-slate-800">Dashboard</summary>
            <p class="mt-2 text-sm text-slate-500">Pusat monitoring cepat untuk kondisi lisensi saat ini dan tren operasional utama.</p>
            <p class="mt-2 text-sm text-slate-500"><strong>Kapan dipakai:</strong> awal shift, sebelum closing harian, dan saat investigasi insiden.</p>
        </details>

        <details class="docs-item">
            <summary class="cursor-pointer text-sm font-semibold text-slate-800">Admin</summary>
            <p class="mt-2 text-sm text-slate-500">Mengelola akun admin, role, dan status akses untuk menjaga kontrol operasional.</p>
            <p class="mt-2 text-sm text-slate-500"><strong>Catatan:</strong> nonaktifkan akun yang tidak aktif lebih dari 30 hari.</p>
        </details>

        <details class="docs-item">
            <summary class="cursor-pointer text-sm font-semibold text-slate-800">Aplikasi</summary>
            <p class="mt-2 text-sm text-slate-500">Registrasi aplikasi yang menggunakan lisensi, termasuk pemeliharaan token akses.</p>
            <p class="mt-2 text-sm text-slate-500"><strong>Catatan:</strong> rotasi token hanya setelah koordinasi dengan tim integrasi.</p>
        </details>

        <details class="docs-item">
            <summary class="cursor-pointer text-sm font-semibold text-slate-800">Paket</summary>
            <p class="mt-2 text-sm text-slate-500">Konfigurasi paket lisensi: durasi, perangkat maksimum, dan status penggunaan.</p>
            <p class="mt-2 text-sm text-slate-500"><strong>Catatan:</strong> gunakan penamaan paket yang konsisten untuk memudahkan audit.</p>
        </details>

        <details class="docs-item">
            <summary class="cursor-pointer text-sm font-semibold text-slate-800">Kode Aktivasi</summary>
            <p class="mt-2 text-sm text-slate-500">Generator serial pesanan user untuk aktivasi baru dan perpanjangan lisensi.</p>
            <p class="mt-2 text-sm text-slate-500"><strong>Catatan:</strong> status serial yang digunakan sistem adalah <strong>available</strong>, <strong>used</strong>, dan <strong>void</strong>.</p>
        </details>

        <details class="docs-item">
            <summary class="cursor-pointer text-sm font-semibold text-slate-800">Lisensi</summary>
            <p class="mt-2 text-sm text-slate-500">Pusat kendali status lisensi pelanggan, termasuk aktivasi, revoke, dan pengecekan device binding.</p>
            <p class="mt-2 text-sm text-slate-500"><strong>Catatan:</strong> gunakan halaman detail lisensi untuk cek masa aktif, status revoke, token, dan perangkat tertaut saat menangani komplain.</p>
        </details>
    </div>

    <div data-docs-tab-panel="troubleshoot" class="panel panel-body hidden space-y-3">
        <h3 class="text-xl font-semibold text-slate-800">Troubleshooting Cepat</h3>
        <details class="docs-item" open>
            <summary class="cursor-pointer text-sm font-semibold text-slate-800">Kasus: Kode aktivasi gagal dipakai</summary>
            <ul class="mt-2 space-y-1.5 text-sm text-slate-500">
                <li>Pastikan serial tidak berstatus <strong>void</strong> atau <strong>used</strong> oleh akun lain.</li>
                <li>Cek apakah paket dan aplikasi masih aktif.</li>
                <li>Validasi batas device belum terlampaui.</li>
            </ul>
        </details>
        <details class="docs-item">
            <summary class="cursor-pointer text-sm font-semibold text-slate-800">Kasus: Lisensi terlihat aktif tapi validasi lisensi di aplikasi client gagal</summary>
            <ul class="mt-2 space-y-1.5 text-sm text-slate-500">
                <li>Verifikasi integrasi token di sisi aplikasi client.</li>
                <li>Cek mismatch <strong>X-Application-Code</strong> atau <strong>X-Application-Token</strong>.</li>
                <li>Audit apakah lisensi sempat di-revoke lalu diaktifkan kembali.</li>
            </ul>
        </details>
        <details class="docs-item">
            <summary class="cursor-pointer text-sm font-semibold text-slate-800">Kasus: Perlu menonaktifkan akses segera</summary>
            <ul class="mt-2 space-y-1.5 text-sm text-slate-500">
                <li>Gunakan menu <strong>Lisensi</strong> untuk revoke lisensi.</li>
                <li>Bila terkait perangkat tertentu, nonaktifkan device binding terkait.</li>
                <li>Catat alasan tindakan untuk kebutuhan audit internal.</li>
            </ul>
        </details>
    </div>

    <div data-docs-tab-panel="governance" class="panel panel-body hidden space-y-3">
        <h3 class="text-xl font-semibold text-slate-800">Keamanan & Tata Kelola</h3>
        <div class="grid gap-3 md:grid-cols-2">
            <article class="docs-item-accent">
                <p class="text-sm font-semibold text-slate-800">Prinsip Akses Minimum</p>
                <p class="mt-1 text-sm text-slate-500">Berikan hak akses sesuai kebutuhan kerja. Hindari akun super-admin untuk aktivitas rutin.</p>
            </article>
            <article class="docs-item-accent">
                <p class="text-sm font-semibold text-slate-800">Jejak Audit Jelas</p>
                <p class="mt-1 text-sm text-slate-500">Setiap perubahan penting harus punya alasan operasional yang dapat ditelusuri.</p>
            </article>
        </div>

        <details class="docs-item" open>
            <summary class="cursor-pointer text-sm font-semibold text-slate-800">FAQ: Kapan token aplikasi harus dirotasi?</summary>
            <p class="mt-2 text-sm text-slate-500">Saat terjadi kebocoran kredensial, perpindahan tim integrasi, atau jadwal rotasi berkala bulanan/kuartalan.</p>
        </details>
        <details class="docs-item">
            <summary class="cursor-pointer text-sm font-semibold text-slate-800">FAQ: Apa indikator operasi sehat?</summary>
            <p class="mt-2 text-sm text-slate-500">Rasio aktivasi sukses tinggi, minim kode void karena human error, dan tidak ada lonjakan revoke tanpa alasan jelas.</p>
        </details>
        <details class="docs-item">
            <summary class="cursor-pointer text-sm font-semibold text-slate-800">FAQ: Siapa yang boleh revoke lisensi?</summary>
            <p class="mt-2 text-sm text-slate-500">Admin yang memiliki izin <strong>manage-licenses</strong>. Mekanisme persetujuan tambahan mengikuti kebijakan internal perusahaan.</p>
        </details>
    </div>
</section>
@endsection
