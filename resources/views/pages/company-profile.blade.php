@extends('layouts.public')

@section('title', 'ElcodeLabs — Digitalisasi Operasional untuk Bisnis yang Berkembang')
@section('meta_description', 'ElcodeLabs membantu bisnis mendigitalkan operasional — dari kasir, stok, hingga laporan — agar lebih rapi, cepat, dan terkendali.')

@section('content')
    <!-- MODERN LOADER -->
    <script>document.body.classList.add('is-page-loading');</script>
    <div id="page-loader">
        <div class="modern-cube-loader">
            <div class="cube-face cube-front"></div>
            <div class="cube-face cube-back"></div>
            <div class="cube-face cube-right"></div>
            <div class="cube-face cube-left"></div>
            <div class="cube-face cube-top"></div>
            <div class="cube-face cube-bottom"></div>
        </div>
        <div class="loader-brand">ELCODELABS<span class="loader-dots"></span></div>
    </div>

    @php
        $splineScenePath = 'assets/spline/company-profile-hero.splinecode';
        $splineViewerPath = 'vendor/spline/spline-viewer-1.12.58.js';
        $splineSceneUrl = asset($splineScenePath) . '?v=' . filemtime(public_path($splineScenePath));
        $splineViewerUrl = asset($splineViewerPath) . '?v=' . filemtime(public_path($splineViewerPath));
    @endphp

    <section id="hero" class="relative w-full min-h-[100vh] flex items-center bg-slate-950">
        <!-- Radial blur overlay to ensure text readability -->
        <div
            class="absolute inset-0 z-0 bg-[radial-gradient(circle_at_center,transparent_0%,rgba(2,6,23,0.8)_100%)] pointer-events-none">
        </div>

        <div class="pub-container relative z-10 grid lg:grid-cols-2 gap-12 items-center pt-32 pb-20 overflow-visible">

            <!-- Left Column: Text Content -->
            <div class="relative z-30 text-center lg:text-left pointer-events-auto">
                <span
                    class="inline-flex items-center gap-2 rounded-full border border-brand-500/30 bg-brand-500/10 px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-brand-400 backdrop-blur-md shadow-[0_0_15px_rgba(59,130,246,0.15)] mb-6 gs-reveal">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
                    </span>
                    Solusi Digital untuk UMKM
                </span>

                <h1
                    class="text-3xl font-extrabold leading-tight tracking-normal text-white sm:text-5xl lg:text-[3.5rem] mb-4 sm:mb-6 drop-shadow-2xl">
                    Operasional Bisnis<br>
                    <span class="text-gradient inline-block">Lebih Rapi</span> dengan<br>
                    Sistem Digital yang Tepat
                </h1>

                <p
                    class="max-w-xl text-sm leading-relaxed text-slate-300 sm:text-lg drop-shadow-md font-normal mb-8 sm:mb-10 mx-auto lg:mx-0">
                    Kurangi salah catat, percepat laporan, dan kendalikan stok —
                    mulai dari kebutuhan inti bisnis Anda, berkembang bertahap.
                </p>

                <div class="flex flex-wrap gap-3 sm:gap-4 justify-center lg:justify-start">
                    <a href="{{ $company['whatsapp_url'] }}" target="_blank" rel="noopener noreferrer"
                        class="pub-btn-primary px-6 py-3 text-sm">
                        Diskusi Kebutuhan Anda
                        <svg class="h-4 w-4 ml-2 cursor-pointer transition-transform group-hover:translate-x-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                    <a href="#services" class="pub-btn-ghost px-6 py-3 text-sm">
                        Lihat Layanan Kami
                    </a>
                </div>

            </div>

            <!-- Right Column: 3D Spline -->
            <div class="relative z-20 hidden w-full h-[350px] sm:h-[500px] lg:block lg:h-[750px]">
                <!-- Ensure container completely overlaps the left side and extends infinitely right, completely discarding layout bounding -->
                <div
                    class="absolute inset-0 lg:left-auto lg:inset-y-0 lg:right-[-50%] lg:w-[200%] w-full h-full flex items-center justify-center
                                                                                translate-x-[8%] sm:translate-x-0 scale-100 sm:scale-[1.15] lg:scale-[1.25] lg:translate-x-[10vw] xl:translate-x-[12vw]">
                    <spline-viewer class="block w-full h-full overflow-visible" style="touch-action: pan-y;"
                        data-url="{{ $splineSceneUrl }}"></spline-viewer>
                </div>
            </div>

        </div>

        <!-- Scroll Indicator -->
        <div
            class="absolute bottom-6 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-white/40 select-none pointer-events-none hidden md:flex">
            <span class="text-[10px] font-bold uppercase tracking-[0.3em]">Jelajahi</span>
            <div class="w-[1px] h-12 bg-gradient-to-b from-white/40 to-transparent animate-pulse"></div>
        </div>
    </section>


    <section id="about" class="pub-section relative">
        <div class="pub-container relative">
            <!-- Glow effect behind about section -->
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-[500px] bg-brand-500/10 blur-[100px] rounded-full pointer-events-none">
            </div>

            <div class="relative z-10 mx-auto max-w-2xl text-center gs-reveal">
                <span class="pub-label">Tentang Kami</span>
                <h2 class="pub-h2 mt-4">Bukan Sekadar Software,<br>Tapi Solusi yang Anda Butuhkan</h2>
                <p class="pub-lead mx-auto">
                    Kami membantu pemilik bisnis mendigitalkan operasional harian — dari pencatatan
                    transaksi, kontrol stok, hingga laporan keuangan — agar lebih rapi, cepat, dan minim kesalahan.
                </p>
            </div>

            <div class="relative z-10 mt-16 grid gap-6 sm:grid-cols-3">
                <div class="pub-card gs-reveal text-center">
                    <div
                        class="mx-auto mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-500/20 to-brand-400/5 ring-1 ring-brand-500/20">
                        <svg class="h-7 w-7 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Pahami Dulu, Bangun Tepat</h3>
                    <p class="text-slate-400 leading-relaxed text-sm sm:text-base">
                        Kami mulai dari memahami masalah dan proses bisnis Anda, bukan langsung menawarkan fitur.
                    </p>
                </div>
                <div class="pub-card gs-reveal text-center">
                    <div
                        class="mx-auto mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-[#238DCA]/20 to-[#238DCA]/5 ring-1 ring-[#238DCA]/20">
                        <svg class="h-7 w-7 text-[#238DCA]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Rapi & Mudah Dikelola</h3>
                    <p class="text-slate-400 leading-relaxed text-sm sm:text-base">
                        Sistem yang kami bangun tertata rapi, sehingga tim Anda mudah menggunakannya sehari-hari.
                    </p>
                </div>
                <div class="pub-card gs-reveal text-center">
                    <div
                        class="mx-auto mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-[#1B986C]/20 to-[#1B986C]/5 ring-1 ring-[#1B986C]/20">
                        <svg class="h-7 w-7 text-[#1B986C]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Tumbuh Sesuai Kebutuhan</h3>
                    <p class="text-slate-400 leading-relaxed text-sm sm:text-base">
                        Mulai dari yang paling dibutuhkan hari ini, lalu tambahkan fitur baru saat bisnis berkembang.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="pub-section relative">
        <div class="absolute inset-0 bg-slate-900/50 skew-y-3 transform origin-bottom-left -z-10"></div>
        <div class="pub-container relative z-10">

            <div class="mx-auto max-w-2xl text-center gs-reveal">
                <span class="pub-label">Layanan Kami</span>
                <h2 class="pub-h2 mt-4">Tiga Pilar Layanan untuk Bisnis Anda</h2>
                <p class="pub-lead mx-auto">
                    Setiap bisnis punya kebutuhan berbeda. Pilih layanan yang paling
                    relevan untuk tahap Anda saat ini.
                </p>
            </div>

            <div class="mt-16 grid gap-8 md:grid-cols-3">

                <div class="pub-card gs-reveal flex flex-col group">
                    <div
                        class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-white/5 ring-1 ring-white/10 group-hover:scale-110 transition-transform duration-500">
                        <svg class="h-8 w-8 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Kehadiran Digital</h3>
                    <p class="mb-8 text-slate-400 leading-relaxed flex-grow">
                        Website profesional yang membangun kepercayaan pelanggan dan memperjelas profil bisnis Anda.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3 text-slate-300">
                            <div class="h-1.5 w-1.5 rounded-full bg-brand-400"></div> Company Profile & Landing Page
                        </li>
                        <li class="flex items-center gap-3 text-slate-300">
                            <div class="h-1.5 w-1.5 rounded-full bg-brand-400"></div> Desain Modern & Responsif
                        </li>
                        <li class="flex items-center gap-3 text-slate-300">
                            <div class="h-1.5 w-1.5 rounded-full bg-brand-400"></div> Formulir Kontak & WhatsApp Terhubung
                        </li>
                    </ul>
                </div>

                <div class="pub-card gs-reveal flex flex-col group relative overflow-visible">
                    <!-- Highlight center card -->
                    <div
                        class="absolute -inset-0.5 bg-gradient-to-b from-brand-500 to-[#238DCA] rounded-[24px] opacity-20 blur-sm -z-10 group-hover:opacity-40 transition-opacity duration-500">
                    </div>
                    <div
                        class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-white/5 ring-1 ring-white/10 group-hover:scale-110 transition-transform duration-500">
                        <svg class="h-8 w-8 text-[#238DCA]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Sistem Operasional</h3>
                    <p class="mb-8 text-slate-400 leading-relaxed flex-grow">
                        Aplikasi yang dibuat khusus untuk mengelola transaksi, stok, karyawan, dan laporan bisnis Anda.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3 text-slate-300">
                            <div class="h-1.5 w-1.5 rounded-full bg-[#238DCA]"></div> Sistem Kasir (POS) & Penjualan
                        </li>
                        <li class="flex items-center gap-3 text-slate-300">
                            <div class="h-1.5 w-1.5 rounded-full bg-[#238DCA]"></div> Manajemen Stok & Gudang
                        </li>
                        <li class="flex items-center gap-3 text-slate-300">
                            <div class="h-1.5 w-1.5 rounded-full bg-[#238DCA]"></div> Laporan & Dashboard Bisnis
                        </li>
                    </ul>
                </div>

                <div class="pub-card gs-reveal flex flex-col group">
                    <div
                        class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-white/5 ring-1 ring-white/10 group-hover:scale-110 transition-transform duration-500">
                        <svg class="h-8 w-8 text-[#1B986C]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Integrasi & Otomasi</h3>
                    <p class="mb-8 text-slate-400 leading-relaxed flex-grow">
                        Hubungkan sistem yang sudah ada agar data mengalir otomatis, tanpa input ulang manual.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3 text-slate-300">
                            <div class="h-1.5 w-1.5 rounded-full bg-[#1B986C]"></div> Data Antar-Sistem Terhubung
                        </li>
                        <li class="flex items-center gap-3 text-slate-300">
                            <div class="h-1.5 w-1.5 rounded-full bg-[#1B986C]"></div> Notifikasi & Laporan Otomatis
                        </li>
                        <li class="flex items-center gap-3 text-slate-300">
                            <div class="h-1.5 w-1.5 rounded-full bg-[#1B986C]"></div> Sinkronisasi Stok Multi-Cabang
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="process" class="pub-section">
        <div class="pub-container">

            <div class="mx-auto max-w-2xl text-center gs-reveal">
                <span class="pub-label">Cara Kerja</span>
                <h2 class="pub-h2 mt-4">Bagaimana Kami Bekerja Bersama Anda</h2>
                <p class="pub-lead mx-auto">
                    Proses yang jelas dan transparan, agar Anda selalu tahu perkembangan proyek di setiap tahap.
                </p>
            </div>

            <div
                class="mt-20 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-white/10 before:to-transparent">
                @php
                    $steps = [
                        ['title' => 'Diskusi & Analisis Kebutuhan', 'desc' => 'Kami mendengarkan masalah dan kebutuhan bisnis Anda, lalu menyusun rencana solusi yang sesuai.'],
                        ['title' => 'Desain Tampilan & Alur', 'desc' => 'Anda melihat rancangan tampilan sebelum pengerjaan dimulai, agar hasilnya sesuai harapan.'],
                        ['title' => 'Pengerjaan Bertahap', 'desc' => 'Sistem dibangun tahap demi tahap, dengan update progres rutin yang bisa Anda pantau.'],
                        ['title' => 'Uji Coba & Penyesuaian', 'desc' => 'Kami menguji seluruh fungsi dan menyesuaikan detail berdasarkan masukan Anda.'],
                        ['title' => 'Go-Live & Pendampingan', 'desc' => 'Sistem Anda siap dipakai, dan kami tetap mendampingi untuk memastikan semuanya berjalan lancar.'],
                    ];
                @endphp

                @foreach ($steps as $i => $step)
                    <div
                        class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active gs-reveal mb-8">
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-slate-950 bg-brand-500 shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 shadow-[0_0_20px_rgba(59,130,246,0.5)] z-10 transition-transform duration-300 group-hover:scale-110 cursor-default">
                            <span class="text-white text-xs font-bold">{{ $i + 1 }}</span>
                        </div>
                        <!-- Card -->
                        <div class="w-[calc(100%-4rem)] md:w-[calc(50%-3rem)] pub-card !p-6">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $step['title'] }}</h3>
                            <p class="text-slate-400 text-sm sm:text-base leading-relaxed">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <section id="usecases" class="pub-section relative">
        <div class="absolute inset-x-0 inset-y-12 bg-slate-900/50 -z-10"></div>
        <div class="pub-container relative z-10">
            <div class="mx-auto max-w-2xl text-center gs-reveal">
                <span class="pub-label">Cocok untuk Siapa?</span>
                <h2 class="pub-h2 mt-4">Bisnis yang Kami Bantu Setiap Hari</h2>
                <p class="pub-lead mx-auto">
                    Jika bisnis Anda punya transaksi harian, stok yang perlu dikontrol,
                    atau tim yang harus dikelola — kami bisa bantu.
                </p>
            </div>

            <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="pub-card gs-reveal !p-6">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white/5 ring-1 ring-white/10">
                        <svg class="h-6 w-6 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Toko & Retail</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Sistem kasir, pencatatan penjualan harian, dan
                        kontrol stok barang secara real-time.</p>
                </div>

                <div class="pub-card gs-reveal !p-6">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white/5 ring-1 ring-white/10">
                        <svg class="h-6 w-6 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Distribusi & Gudang</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Kelola barang masuk-keluar, lacak pengiriman, dan
                        pantau stok di beberapa lokasi.</p>
                </div>

                <div class="pub-card gs-reveal !p-6">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white/5 ring-1 ring-white/10">
                        <svg class="h-6 w-6 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Jasa & Layanan</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Penjadwalan, pencatatan order, dan laporan
                        performa layanan yang terorganisir.</p>
                </div>

                <div class="pub-card gs-reveal !p-6">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white/5 ring-1 ring-white/10">
                        <svg class="h-6 w-6 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Bisnis Multi-Cabang</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">Sinkronisasi data penjualan dan stok antar cabang
                        dalam satu dashboard terpusat.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="pub-section relative">
        <div class="pub-container relative z-10">
            <div class="mx-auto max-w-2xl text-center gs-reveal">
                <span class="pub-label">FAQ</span>
                <h2 class="pub-h2 mt-4">Pertanyaan Umum</h2>
                <p class="pub-lead mx-auto">
                    Jawaban singkat untuk pertanyaan umum sebelum kita berdiskusi lebih lanjut.
                </p>
            </div>

            <div class="mx-auto mt-16 max-w-3xl space-y-4">
                @php
                    $faqs = [
                        ['q' => 'Berapa lama prosesnya dari awal sampai bisa dipakai?', 'a' => 'Tergantung kebutuhan. Website company profile biasanya selesai dalam 2–3 minggu. Sistem operasional seperti kasir atau manajemen stok membutuhkan 4–8 minggu, tergantung cakupan yang disepakati.'],
                        ['q' => 'Apakah harus langsung besar, atau bisa mulai kecil dulu?', 'a' => 'Sangat bisa dimulai dari yang paling dibutuhkan saja. Misalnya, mulai dari sistem kasir dulu — lalu nanti tambahkan modul stok, laporan, atau integrasi lain saat bisnis sudah siap.'],
                        ['q' => 'Setelah sistem jadi, apakah ada pendampingan?', 'a' => 'Ya. Kami menyediakan dukungan teknis dan maintenance agar sistem Anda tetap berjalan stabil. Jika ada kebutuhan baru, kami juga siap mengembangkannya.'],
                        ['q' => 'Langkah pertama yang harus saya lakukan apa?', 'a' => 'Cukup hubungi kami via WhatsApp atau email. Kami akan mengatur sesi diskusi 30 menit untuk memahami kebutuhan Anda — tanpa biaya dan tanpa komitmen.'],
                    ];
                @endphp

                @foreach ($faqs as $faq)
                    <div class="faq-item gs-reveal pub-card !p-0 !rounded-2xl cursor-pointer group">
                        <button type="button"
                            class="faq-btn w-full flex items-center justify-between gap-4 px-6 py-5 text-left bg-transparent border-none outline-none focus:outline-none focus:ring-2 focus:ring-brand-500/50 rounded-2xl">
                            <span
                                class="font-bold text-white text-base group-hover:text-brand-400 transition-colors">{{ $faq['q'] }}</span>
                            <div
                                class="h-8 w-8 rounded-full bg-white/5 flex items-center justify-center group-hover:bg-brand-500/20 transition-colors shrink-0">
                                <svg class="faq-chevron h-4 w-4 text-brand-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                        <div class="faq-body">
                            <div class="px-6 pb-6 pt-0 border-t border-white/5 mt-2 hidden-if-empty">
                                <p class="text-slate-400 leading-relaxed text-sm sm:text-base">{{ $faq['a'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="principles" class="pub-section relative">
        <div class="pub-container relative z-10">
            <div class="mx-auto max-w-5xl">
                <div class="flex flex-col gap-12 lg:flex-row lg:items-start lg:gap-20">
                    <div class="lg:w-80 shrink-0 gs-reveal">
                        <span class="pub-label">Prinsip Kerja</span>
                        <h2 class="pub-h2 mt-4 text-3xl">Komitmen Kami untuk Setiap Klien</h2>
                        <p class="mt-4 text-base leading-relaxed text-slate-400">
                            Bukan janji kosong — ini adalah standar kerja yang selalu kami pegang
                            dalam setiap proyek.
                        </p>
                    </div>

                    <div class="flex-1 grid gap-4 sm:grid-cols-2">
                        @php
                            $principles = [
                                ['title' => 'Proses Transparan', 'desc' => 'Anda selalu tahu status proyek dan apa yang sedang dikerjakan, tanpa perlu bertanya.'],
                                ['title' => 'Hasilnya Terukur', 'desc' => 'Setiap fitur yang dibangun punya tujuan jelas — mengurangi error, mempercepat proses, atau menghemat waktu.'],
                                ['title' => 'Bisa Bertumbuh', 'desc' => 'Sistem dirancang agar bisa ditambah fitur baru seiring bisnis berkembang, tanpa harus buat ulang.'],
                                ['title' => 'Update Rutin', 'desc' => 'Laporan progres dikirim secara rutin, termasuk demo hasil kerja yang bisa Anda coba langsung.'],
                                ['title' => 'Sesuai Kebutuhan', 'desc' => 'Kami tidak membangun fitur yang tidak Anda butuhkan — semuanya disesuaikan dengan prioritas bisnis.'],
                                ['title' => 'Data Anda Aman', 'desc' => 'Keamanan data dan akses pengguna sudah menjadi standar di setiap sistem yang kami bangun.'],
                            ];
                        @endphp

                        @foreach ($principles as $p)
                            <div class="gs-reveal pub-card !p-5 flex items-start gap-4">
                                <div
                                    class="mt-1 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-brand-500/20 text-brand-400 ring-1 ring-brand-500/30">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-base font-bold text-white">{{ $p['title'] }}</p>
                                    <p class="mt-1 text-sm leading-relaxed text-slate-400">{{ $p['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="contact" class="pub-section relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 bg-slate-950 pointer-events-none"></div>
        <div
            class="absolute top-0 right-0 w-[600px] h-[600px] bg-brand-500/10 rounded-full blur-[120px] pointer-events-none translate-x-1/2 -translate-y-1/2">
        </div>
        <div
            class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-[#1E979B]/10 rounded-full blur-[100px] pointer-events-none -translate-x-1/2 translate-y-1/2">
        </div>

        <div class="pub-container relative z-10">
            <div class="mx-auto max-w-2xl text-center gs-reveal">
                <span class="pub-label mb-3">Kontak</span>
                <h2 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-5xl mb-6">
                    Mulai dari Diskusi 30 Menit
                </h2>
                <p class="text-lg leading-relaxed text-slate-300">
                    Ceritakan tantangan operasional bisnis Anda. Kami bantu petakan
                    solusinya — gratis, tanpa komitmen.
                </p>
            </div>

            <div class="mx-auto mt-16 grid max-w-4xl gap-6 sm:grid-cols-3">

                <!-- WhatsApp Card -->
                <a href="{{ $company['whatsapp_url'] }}" target="_blank" rel="noopener noreferrer"
                    class="pub-card gs-reveal flex flex-col items-center text-center group">
                    <div
                        class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-500/20 to-brand-400/5 ring-1 ring-brand-500/20 group-hover:scale-110 transition-transform duration-500">
                        <svg class="h-7 w-7 text-brand-400" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-2">WhatsApp</h3>
                    <p class="text-lg font-bold text-white mb-2">{{ $company['whatsapp'] }}</p>
                    <p class="text-sm text-brand-400 group-hover:text-brand-300 transition-colors mt-auto">Hubungi Kami →
                    </p>
                </a>

                <!-- Email Card -->
                <a href="{{ $company['mailto_url'] }}"
                    class="pub-card gs-reveal flex flex-col items-center text-center group">
                    <div
                        class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-[#238DCA]/20 to-[#238DCA]/5 ring-1 ring-[#238DCA]/20 group-hover:scale-110 transition-transform duration-500">
                        <svg class="h-7 w-7 text-[#238DCA]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-2">Email</h3>
                    <p class="text-lg font-bold text-white mb-2 truncate" title="{{ $company['email'] }}">
                        {{ $company['email'] }}
                    </p>
                    <p class="text-sm text-[#238DCA] group-hover:text-[#52aae0] transition-colors mt-auto">Kirim Email
                        →</p>
                </a>

                <!-- Location Card -->
                <a href="{{ $company['maps_url'] }}" target="_blank" rel="noopener noreferrer"
                    class="pub-card gs-reveal flex flex-col items-center text-center group">
                    <div
                        class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-[#1B986C]/20 to-[#1B986C]/5 ring-1 ring-[#1B986C]/20 group-hover:scale-110 transition-transform duration-500">
                        <svg class="h-7 w-7 text-[#1B986C]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-2">Lokasi</h3>
                    <p class="text-lg font-bold text-white mb-2">{{ $company['city'] }}</p>
                    <p class="text-sm text-[#1B986C] group-hover:text-[#28c58f] transition-colors mt-auto">Lihat Maps →</p>
                </a>
            </div>

            <div class="mx-auto mt-16 max-w-sm text-center gs-reveal">
                <a href="{{ $company['whatsapp_url'] }}" target="_blank" rel="noopener noreferrer"
                    class="pub-btn-primary w-full justify-center">
                    Diskusi Gratis 30 Menit
                    <svg class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            // PREFETCH & CACHE CRITICAL ASSETS FIRST
            async function cacheCriticalAssets(assets) {
                if (!('caches' in window)) return;
                try {
                    const cache = await caches.open('elcodelabs-assets-v1');
                    for (const url of assets) {
                        const response = await cache.match(url);
                        if (!response) {
                            await cache.add(url).catch(e => console.warn('Cache add failed', url, e));
                        }
                    }
                } catch (e) {
                    console.warn('Cache API Error:', e);
                }
            }
            // Fetch spline code and viewer to cache locally in the browser storage
            cacheCriticalAssets(['{{ $splineSceneUrl }}', '{{ $splineViewerUrl }}']);

            // LOADER LOGIC
            let isPageLoaded = false;
            let isSplineReady = false;
            const isDesktopDevice = window.matchMedia('(min-width: 1024px)').matches;
            const isSaveData = navigator.connection && navigator.connection.saveData;
            const shouldWaitForSpline = isDesktopDevice && !isSaveData;

            function evaluateLoaderState() {
                if (isPageLoaded && (isSplineReady || !shouldWaitForSpline)) {
                    const loader = document.getElementById('page-loader');
                    if (loader) loader.classList.add('hidden');
                    document.body.classList.remove('is-page-loading');
                }
            }

            window.addEventListener('load', () => {
                isPageLoaded = true;
                evaluateLoaderState();
                // Fallback max 5 seconds wait after window load in case Spline load event doesn't fire
                setTimeout(() => {
                    if (!isSplineReady) {
                        isSplineReady = true;
                        evaluateLoaderState();
                    }
                }, 5000);
            });

            function initCompanyProfile() {
                const revealElements = document.querySelectorAll('.gs-reveal');
                const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

                if (prefersReducedMotion) {
                    revealElements.forEach((elem) => elem.classList.add('is-visible'));
                } else {
                    const revealObserver = new IntersectionObserver((entries, observer) => {
                        entries.forEach((entry) => {
                            if (!entry.isIntersecting) {
                                return;
                            }

                            entry.target.classList.add('is-visible');
                            observer.unobserve(entry.target);
                        });
                    }, {
                        rootMargin: '0px 0px -10% 0px',
                        threshold: 0.08
                    });

                    revealElements.forEach((elem) => revealObserver.observe(elem));
                }

                const faqBtns = document.querySelectorAll('.faq-btn');
                faqBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        const item = btn.closest('.faq-item');
                        document.querySelectorAll('.faq-item').forEach(other => {
                            if (other !== item) other.classList.remove('open');
                        });
                        item.classList.toggle('open');
                    });
                });

                const splineViewer = document.querySelector('spline-viewer[data-url]');
                if (splineViewer) {
                    const saveData = navigator.connection && navigator.connection.saveData;
                    const desktopMedia = window.matchMedia('(min-width: 1024px)');
                    let splineModulePromise;
                    let splineTimer;
                    let splineObserver;
                    let splineObserverStarted = false;

                    const requestIdle = window.requestIdleCallback || function (callback) {
                        return window.setTimeout(callback, 600);
                    };

                    const ensureSplineModule = () => {
                        if (splineModulePromise) {
                            return splineModulePromise;
                        }

                        splineModulePromise = new Promise((resolve, reject) => {
                            const script = document.createElement('script');
                            script.type = 'module';
                            script.src = '{{ $splineViewerUrl }}';
                            script.async = true;
                            script.onload = resolve;
                            script.onerror = reject;
                            document.body.appendChild(script);
                        });

                        return splineModulePromise;
                    };

                    const activateSpline = () => {
                        if (saveData || !desktopMedia.matches || splineViewer.dataset.loaded === 'true') {
                            return;
                        }

                        if (splineTimer) {
                            window.clearTimeout(splineTimer);
                            splineTimer = null;
                        }
                        splineViewer.dataset.loaded = 'true';
                        requestIdle(() => {
                            ensureSplineModule()
                                .then(async () => {
                                    const sceneUrl = splineViewer.dataset.url;
                                    let objectUrl = sceneUrl;

                                    if ('caches' in window) {
                                        try {
                                            const cache = await caches.open('elcodelabs-assets-v1');
                                            let response = await cache.match(sceneUrl);

                                            // Jika file tidak ada di cache, log info dan fetch
                                            if (!response) {
                                                response = await fetch(sceneUrl);
                                                if (response.ok) {
                                                    await cache.put(sceneUrl, response.clone());
                                                }
                                            }

                                            // Konversi ke blob agar tidak request network ulang
                                            if (response) {
                                                const blob = await response.blob();
                                                objectUrl = URL.createObjectURL(blob);
                                            }
                                        } catch (e) {
                                            console.warn('Cache API URL blob creation failed', e);
                                        }
                                    }

                                    // Mark spline ready when fully loaded
                                    splineViewer.addEventListener('load', () => {
                                        isSplineReady = true;
                                        evaluateLoaderState();
                                        if (objectUrl.startsWith('blob:')) {
                                            setTimeout(() => URL.revokeObjectURL(objectUrl), 10000);
                                        }
                                    });

                                    splineViewer.setAttribute('url', objectUrl);

                                    // Remove watermark from shadow DOM after viewer loads
                                    removeSplineWatermark(splineViewer);
                                })
                                .catch(() => {
                                    splineViewer.dataset.loaded = 'error';
                                });
                        });
                    };

                    const removeSplineWatermark = (viewer) => {
                        const hideLogo = (root) => {
                            const logo = root.querySelector('#logo');
                            if (logo) {
                                logo.style.display = 'none';
                                logo.style.visibility = 'hidden';
                                logo.style.opacity = '0';
                                logo.style.pointerEvents = 'none';
                                logo.style.width = '0';
                                logo.style.height = '0';
                                logo.style.overflow = 'hidden';
                                logo.style.position = 'absolute';
                                logo.remove();
                            }
                        };

                        const tryHide = () => {
                            if (viewer.shadowRoot) {
                                hideLogo(viewer.shadowRoot);
                                // Watch for re-insertion
                                const mo = new MutationObserver(() => {
                                    hideLogo(viewer.shadowRoot);
                                });
                                mo.observe(viewer.shadowRoot, { childList: true, subtree: true });
                                // Stop observing after 15 seconds to save resources
                                setTimeout(() => mo.disconnect(), 15000);
                                return true;
                            }
                            return false;
                        };

                        // Retry several times since shadow root may attach asynchronously
                        let attempts = 0;
                        const maxAttempts = 30;
                        const interval = setInterval(() => {
                            if (tryHide() || ++attempts >= maxAttempts) {
                                clearInterval(interval);
                            }
                        }, 500);
                    };

                    const scheduleSplineLoad = () => {
                        if (saveData) {
                            return;
                        }

                        if (splineTimer) {
                            window.clearTimeout(splineTimer);
                        }

                        splineTimer = window.setTimeout(activateSpline, 1200);
                    };

                    const startSplineObserver = () => {
                        if (saveData || !desktopMedia.matches || splineObserverStarted) {
                            return;
                        }

                        splineObserverStarted = true;
                        splineObserver.observe(splineViewer);
                    };

                    const stopSplineObserver = () => {
                        if (splineTimer) {
                            window.clearTimeout(splineTimer);
                            splineTimer = null;
                        }

                        if (splineObserverStarted) {
                            splineObserver.disconnect();
                            splineObserverStarted = false;
                        }
                    };

                    splineObserver = new IntersectionObserver((entries, currentObserver) => {
                        entries.forEach((entry) => {
                            if (!entry.isIntersecting) {
                                return;
                            }

                            scheduleSplineLoad();
                            currentObserver.unobserve(entry.target);
                        });
                    }, { rootMargin: '0px 0px 10% 0px' });

                    const handleDesktopModeChange = (event) => {
                        if (event.matches) {
                            startSplineObserver();
                            return;
                        }

                        stopSplineObserver();
                    };

                    if (desktopMedia.addEventListener) {
                        desktopMedia.addEventListener('change', handleDesktopModeChange);
                    } else {
                        desktopMedia.addListener(handleDesktopModeChange);
                    }

                    if (document.readyState === 'complete') {
                        startSplineObserver();
                    } else {
                        window.addEventListener('load', startSplineObserver, { once: true });
                    }
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initCompanyProfile);
            } else {
                initCompanyProfile();
            }
        </script>
    @endpush
@endsection