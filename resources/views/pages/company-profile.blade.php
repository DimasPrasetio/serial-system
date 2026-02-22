@extends('layouts.public')

@section('title', 'ElcodeLabs — Mitra Digital untuk Bisnis Terstruktur')
@section('meta_description', 'ElcodeLabs membantu bisnis merancang dan membangun sistem digital yang terstruktur, efisien, dan mudah dikembangkan.')

@section('content')

<section id="hero" class="relative flex min-h-screen items-center overflow-hidden">
    <div class="absolute inset-0" style="background: linear-gradient(140deg, #313062 0%, #2460A8 48%, #1E979B 100%)"></div>

    <div class="absolute inset-0 opacity-[0.06]"
         style="background-image: linear-gradient(rgba(255,255,255,.7) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.7) 1px, transparent 1px);
                background-size: 44px 44px;"></div>

    <div class="absolute -right-32 -top-32 h-[500px] w-[500px] rounded-full opacity-20 blur-3xl pointer-events-none"
         style="background: #238DCA"></div>
    <div class="absolute -bottom-24 -left-20 h-96 w-96 rounded-full opacity-15 blur-3xl pointer-events-none"
         style="background: #1B986C"></div>
    <div class="absolute bottom-1/3 right-1/4 h-72 w-72 rounded-full opacity-10 blur-3xl pointer-events-none"
         style="background: #2C378C"></div>

    <div class="pub-container relative z-10 py-28 text-left lg:py-36">
        <div class="max-w-3xl">
            <span class="mb-8 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-white/80 backdrop-blur-sm">
                <span class="h-1.5 w-1.5 animate-pulse rounded-full" style="background: #1B986C"></span>
                Mitra Digital untuk Bisnis Terstruktur
            </span>

            <h1 class="text-4xl font-extrabold leading-[1.15] tracking-tight text-white sm:text-5xl lg:text-[3.5rem]">
                Sistem Digital yang<br>
                <span style="color: #83d9f8">Dirancang untuk Berkembang</span><br>
                Bersama Bisnis Anda
            </h1>

            <p class="mt-6 max-w-xl text-base leading-relaxed text-blue-100/75 sm:text-lg">
                ElcodeLabs membantu bisnis membangun sistem digital yang terstruktur —
                mulai dari kehadiran online, aplikasi web kustom, hingga otomatisasi
                proses operasional. Efisien sejak hari pertama, mudah dikembangkan ke depannya.
            </p>

            <div class="mt-10 flex flex-wrap gap-4">
                <a href="{{ $company['whatsapp_url'] }}" target="_blank" rel="noopener noreferrer" class="pub-btn-primary px-7 py-3.5">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Konsultasi 15 Menit
                </a>
                <a href="#services" class="pub-btn-ghost px-7 py-3.5">
                    Lihat Layanan
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </a>
            </div>

            <div class="mt-16 flex flex-wrap gap-8 border-t border-white/10 pt-8">
                <div>
                    <p class="text-2xl font-bold text-white">Discovery First</p>
                    <p class="mt-0.5 text-xs sm:text-sm text-white/65 uppercase tracking-wide leading-relaxed">Pahami dulu, baru bangun</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-white">Modular</p>
                    <p class="mt-0.5 text-xs sm:text-sm text-white/65 uppercase tracking-wide leading-relaxed">Mudah dikembangkan bertahap</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-white">Terdokumentasi</p>
                    <p class="mt-0.5 text-xs sm:text-sm text-white/65 uppercase tracking-wide leading-relaxed">Setiap tahap tercatat jelas</p>
                </div>
            </div>
        </div>
    </div>

    <div class="pointer-events-none absolute inset-x-0 bottom-0 leading-none" aria-hidden="true">
        <svg class="block h-16 w-full fill-white sm:h-24 lg:h-28" viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64C149,111,297,111,432,85C567,59,693,5,833,11C973,16,1127,80,1268,91C1337,96,1388,91,1440,76V120H0Z"></path>
        </svg>
    </div>

    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1.5 text-white/35 select-none pointer-events-none">
        <span class="text-[10px] uppercase tracking-[0.2em]">Scroll</span>
        <svg class="h-4 w-4 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>
</section>


<section id="about" class="pub-section">
    <div class="pub-container">

        <div class="mx-auto max-w-2xl text-center reveal">
            <span class="pub-label">Tentang ElcodeLabs</span>
            <h2 class="pub-h2 mt-2">Lebih dari Sekadar Pembuatan Website</h2>
            <p class="pub-lead mx-auto">
                Kami bekerja dengan bisnis yang ingin memiliki fondasi digital yang terstruktur —
                bukan hanya tampilan, tapi sistem yang benar-benar bisa dikelola dan dikembangkan.
            </p>
        </div>

        <div class="mt-14 grid gap-6 sm:grid-cols-3">
            <div class="pub-card reveal d1 text-center">
                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl"
                     style="background: rgba(36,96,168,.1)">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="#2460A8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-[#313062]">Kebutuhan Bisnis Dulu</h3>
                <p class="mt-2 text-sm sm:text-base leading-relaxed text-slate-500">
                    Setiap solusi dirancang berdasarkan kebutuhan nyata, bukan template generik.
                </p>
            </div>
            <div class="pub-card reveal d2 text-center">
                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl"
                     style="background: rgba(35,141,202,.1)">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="#238DCA" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-[#313062]">Terstruktur & Terdokumentasi</h3>
                <p class="mt-2 text-sm sm:text-base leading-relaxed text-slate-500">
                    Sistem yang dibangun dengan dokumentasi jelas agar mudah dipahami dan dikelola.
                </p>
            </div>
            <div class="pub-card reveal d3 text-center">
                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl"
                     style="background: rgba(27,152,108,.1)">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="#1B986C" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-[#313062]">Siap Dikembangkan</h3>
                <p class="mt-2 text-sm sm:text-base leading-relaxed text-slate-500">
                    Arsitektur yang dirancang agar mudah ditambahkan fitur baru seiring pertumbuhan bisnis.
                </p>
            </div>
        </div>

        <div class="mt-16 mx-auto max-w-3xl space-y-5 reveal">
            <p class="text-slate-600 leading-relaxed">
                ElcodeLabs adalah mitra digital yang berfokus pada pembangunan sistem —
                bukan sekadar tampilan. Kami bekerja dengan bisnis yang ingin memiliki
                fondasi digital yang terstruktur, mudah dikelola, dan siap tumbuh
                sesuai arah bisnis mereka.
            </p>
            <p class="text-slate-600 leading-relaxed">
                Setiap proyek dimulai dari pemahaman mendalam tentang konteks bisnis.
                Baru setelah itu kami merancang solusi — apakah itu website company
                profile, aplikasi manajemen internal, atau sistem yang mengotomatisasi
                proses operasional harian. Tidak ada asumsi, semua berdasarkan data
                dan diskusi langsung.
            </p>
            <p class="text-slate-600 leading-relaxed">
                Kami percaya sistem yang baik bukan hanya yang selesai dibuat —
                melainkan yang mudah digunakan, mudah dipelihara, dan bisa
                berkembang bersama bisnis Anda dari waktu ke waktu.
            </p>
        </div>
    </div>
</section>


<section id="services" class="pub-section-alt">
    <div class="pub-container">

        <div class="mx-auto max-w-2xl text-center reveal">
            <span class="pub-label">Layanan</span>
            <h2 class="pub-h2 mt-2">Apa yang Kami Kerjakan</h2>
            <p class="pub-lead mx-auto">
                Tiga kategori utama layanan kami, dirancang untuk menjawab
                kebutuhan bisnis di berbagai tahap pertumbuhan digital.
            </p>
        </div>

        <div class="mt-14 grid gap-6 md:grid-cols-3">

            <div class="pub-card reveal d1 flex flex-col">
                <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl"
                     style="background: rgba(36,96,168,.1)">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="#2460A8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="mb-1 text-xs font-semibold uppercase tracking-wider text-[#2460A8]">01</span>
                <h3 class="text-lg font-bold text-[#313062]">Digital Presence</h3>
                <p class="mt-2 mb-5 text-sm sm:text-base text-slate-500 leading-relaxed">
                    Kehadiran digital yang profesional sebagai wajah bisnis Anda di internet.
                </p>
                <ul class="mt-auto space-y-3">
                    <li class="flex items-start gap-2.5 text-sm sm:text-base text-slate-600">
                        <span class="mt-0.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full text-white text-[9px] font-bold"
                              style="background: #2460A8">✓</span>
                        Website Company Profile
                    </li>
                    <li class="flex items-start gap-2.5 text-sm sm:text-base text-slate-600">
                        <span class="mt-0.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full text-white text-[9px] font-bold"
                              style="background: #2460A8">✓</span>
                        Landing Page
                    </li>
                    <li class="flex items-start gap-2.5 text-sm sm:text-base text-slate-600">
                        <span class="mt-0.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full text-white text-[9px] font-bold"
                              style="background: #2460A8">✓</span>
                        Integrasi dasar (form, email, tracking)
                    </li>
                </ul>
            </div>

            <div class="pub-card reveal d2 flex flex-col border-[#238DCA]/20"
                 style="border-color: rgba(35,141,202,.25); box-shadow: 0 0 0 1px rgba(35,141,202,.15), 0 4px 16px -4px rgba(35,141,202,.12);">
                <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl"
                     style="background: rgba(35,141,202,.1)">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="#238DCA" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                    </svg>
                </div>
                <span class="mb-1 text-xs font-semibold uppercase tracking-wider text-[#238DCA]">02</span>
                <h3 class="text-lg font-bold text-[#313062]">Business Systems</h3>
                <p class="mt-2 mb-5 text-sm sm:text-base text-slate-500 leading-relaxed">
                    Aplikasi dan sistem web kustom untuk mendukung operasional bisnis secara langsung.
                </p>
                <ul class="mt-auto space-y-3">
                    <li class="flex items-start gap-2.5 text-sm sm:text-base text-slate-600">
                        <span class="mt-0.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full text-white text-[9px] font-bold"
                              style="background: #238DCA">✓</span>
                        Custom Web Application
                    </li>
                    <li class="flex items-start gap-2.5 text-sm sm:text-base text-slate-600">
                        <span class="mt-0.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full text-white text-[9px] font-bold"
                              style="background: #238DCA">✓</span>
                        Dashboard & Reporting
                    </li>
                    <li class="flex items-start gap-2.5 text-sm sm:text-base text-slate-600">
                        <span class="mt-0.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full text-white text-[9px] font-bold"
                              style="background: #238DCA">✓</span>
                        Sistem Manajemen Internal
                    </li>
                </ul>
            </div>

            <div class="pub-card reveal d3 flex flex-col">
                <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl"
                     style="background: rgba(27,152,108,.1)">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="#1B986C" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
                <span class="mb-1 text-xs font-semibold uppercase tracking-wider text-[#1B986C]">03</span>
                <h3 class="text-lg font-bold text-[#313062]">Automation & Digitalisasi</h3>
                <p class="mt-2 mb-5 text-sm sm:text-base text-slate-500 leading-relaxed">
                    Otomatisasi alur kerja dan sentralisasi data untuk efisiensi operasional.
                </p>
                <ul class="mt-auto space-y-3">
                    <li class="flex items-start gap-2.5 text-sm sm:text-base text-slate-600">
                        <span class="mt-0.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full text-white text-[9px] font-bold"
                              style="background: #1B986C">✓</span>
                        Workflow Automation
                    </li>
                    <li class="flex items-start gap-2.5 text-sm sm:text-base text-slate-600">
                        <span class="mt-0.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full text-white text-[9px] font-bold"
                              style="background: #1B986C">✓</span>
                        Integrasi antar tools
                    </li>
                    <li class="flex items-start gap-2.5 text-sm sm:text-base text-slate-600">
                        <span class="mt-0.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full text-white text-[9px] font-bold"
                              style="background: #1B986C">✓</span>
                        Sentralisasi data
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>


<section id="process" class="pub-section">
    <div class="pub-container">

        <div class="mx-auto max-w-2xl text-center reveal">
            <span class="pub-label">Cara Kerja</span>
            <h2 class="pub-h2 mt-2">Dari Ide Menjadi Sistem yang Berjalan</h2>
            <p class="pub-lead mx-auto">
                Lima tahap terstruktur yang memastikan setiap proyek dikerjakan
                dengan arah yang jelas dan hasil yang terukur.
            </p>
        </div>

        <div class="mt-14">
            <div class="hidden lg:grid lg:grid-cols-5 lg:gap-4">
                @php
                    $steps = [
                        ['num' => '01', 'title' => 'Discovery',       'color' => '#2460A8',
                         'desc' => 'Kami mulai dengan memahami bisnis, tujuan, dan tantangan yang dihadapi secara mendalam.'],
                        ['num' => '02', 'title' => 'Perancangan',     'color' => '#238DCA',
                         'desc' => 'Alur sistem, struktur data, dan tampilan dirancang sebelum satu baris kode pun ditulis.'],
                        ['num' => '03', 'title' => 'Pengembangan',    'color' => '#1E979B',
                         'desc' => 'Sistem dibangun bertahap dengan komunikasi progres secara berkala kepada klien.'],
                        ['num' => '04', 'title' => 'Uji & Rilis',     'color' => '#1B986C',
                         'desc' => 'Pengujian menyeluruh dilakukan sebelum sistem diserahkan dan diaktifkan secara resmi.'],
                        ['num' => '05', 'title' => 'Pemeliharaan',    'color' => '#313062',
                         'desc' => 'Kami tetap siap membantu setelah sistem berjalan dan mendukung pengembangan lanjutan.'],
                    ];
                @endphp

                @foreach ($steps as $i => $step)
                <div class="reveal d{{ $i + 1 }} relative flex flex-col items-center text-center">
                    @if ($i < 4)
                    <div class="absolute top-5 left-[calc(50%+24px)] right-0 h-px opacity-20"
                         style="background: linear-gradient(90deg, {{ $step['color'] }}, #ccc)"></div>
                    @endif
                    <div class="relative z-10 flex h-10 w-10 items-center justify-center rounded-full text-sm font-bold text-white shadow-md"
                         style="background: {{ $step['color'] }}">{{ $step['num'] }}</div>
                    <h3 class="mt-4 text-base font-semibold text-[#313062]">{{ $step['title'] }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>

            <div class="lg:hidden space-y-0">
                @foreach ($steps as $i => $step)
                <div class="reveal d{{ $i + 1 }} flex gap-5">
                    <div class="flex flex-col items-center">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-sm font-bold text-white shadow-md"
                             style="background: {{ $step['color'] }}">{{ $step['num'] }}</div>
                        @if ($i < 4)
                        <div class="mt-1 w-px flex-1 opacity-20" style="background: {{ $step['color'] }}; min-height: 2.5rem;"></div>
                        @endif
                    </div>
                    <div class="pb-8 pt-1.5">
                        <h3 class="text-base font-semibold text-[#313062]">{{ $step['title'] }}</h3>
                        <p class="mt-1.5 text-sm sm:text-base leading-relaxed text-slate-500">{{ $step['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>


<section id="usecases" class="pub-section-alt">
    <div class="pub-container">

        <div class="mx-auto max-w-2xl text-center reveal">
            <span class="pub-label">Contoh Kebutuhan</span>
            <h2 class="pub-h2 mt-2">Sistem Seperti Apa yang Bisa Kami Bantu?</h2>
            <p class="pub-lead mx-auto">
                Beberapa contoh kebutuhan yang sering kami tangani.
                Jika kebutuhan Anda belum ada di sini, konsultasikan langsung.
            </p>
        </div>

        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

            @php
                $usecases = [
                    ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
                      'title' => 'CRM & Manajemen Klien',
                      'desc'  => 'Kelola data klien, riwayat interaksi, dan progres deal dalam satu sistem terstruktur.',
                      'color' => '#2460A8'],
                    ['icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
                      'title' => 'Sistem Order & Tracking',
                      'desc'  => 'Pantau status pesanan, pengiriman, dan riwayat transaksi secara real-time.',
                      'color' => '#238DCA'],
                    ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                      'title' => 'Dashboard Laporan',
                      'desc'  => 'Visualisasi data bisnis yang relevan untuk pengambilan keputusan yang lebih cepat.',
                      'color' => '#1E979B'],
                    ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                      'title' => 'Form & Approval Workflow',
                      'desc'  => 'Digitalisasi proses pengajuan dan persetujuan internal dengan notifikasi otomatis.',
                      'color' => '#1B986C'],
                    ['icon' => 'M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z',
                      'title' => 'Landing Page + Tracking',
                      'desc'  => 'Halaman kampanye yang terkonversi dengan integrasi analytics dan form capture.',
                      'color' => '#2C378C'],
                    ['icon' => 'M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                      'title' => 'Integrasi Data Antar Tools',
                      'desc'  => 'Hubungkan tools yang sudah Anda gunakan agar data mengalir otomatis tanpa input manual.',
                      'color' => '#313062'],
                ];
            @endphp

            @foreach ($usecases as $i => $uc)
            <div class="pub-card reveal d{{ ($i % 3) + 1 }} group flex gap-4">
                <div class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl transition-colors duration-300"
                     style="background: {{ $uc['color'] }}1a">
                    <svg class="h-5 w-5 transition-colors duration-300" fill="none" viewBox="0 0 24 24"
                         stroke="{{ $uc['color'] }}" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $uc['icon'] }}"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-semibold text-[#313062] group-hover:text-[#2460A8] transition-colors duration-200">{{ $uc['title'] }}</h3>
                    <p class="mt-1.5 text-sm sm:text-base leading-relaxed text-slate-500">{{ $uc['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<section id="principles" class="pub-section">
    <div class="pub-container">
        <div class="mx-auto max-w-5xl">
            <div class="flex flex-col gap-12 lg:flex-row lg:items-start lg:gap-20">

                <div class="lg:w-80 shrink-0 reveal">
                    <span class="pub-label">Prinsip Kerja</span>
                    <h2 class="pub-h2 mt-2">Standar yang Kami Pegang di Setiap Proyek</h2>
                    <p class="mt-4 text-base leading-relaxed text-slate-500">
                        Bukan klaim. Ini adalah hal-hal konkret yang selalu kami terapkan
                        dalam setiap pengerjaan, dari proyek kecil hingga sistem yang kompleks.
                    </p>
                </div>

                <div class="flex-1 grid gap-4 sm:grid-cols-2">
                    @php
                        $principles = [
                            ['title' => 'Dokumentasi Jelas',         'desc' => 'Setiap tahap pengerjaan terdokumentasi agar mudah dipahami dan dilanjutkan.'],
                            ['title' => 'Struktur Sistem Rapi',       'desc' => 'Kode dan arsitektur ditata dengan pola yang konsisten dan mudah diikuti.'],
                            ['title' => 'Mudah Dikembangkan',         'desc' => 'Sistem dirancang modular agar fitur baru bisa ditambahkan tanpa merusak yang ada.'],
                            ['title' => 'Komunikasi Progres',         'desc' => 'Update perkembangan disampaikan secara berkala tanpa perlu diminta.'],
                            ['title' => 'Fokus Kebutuhan Bisnis',     'desc' => 'Setiap keputusan teknis dikaitkan pada dampak nyata untuk operasional bisnis.'],
                            ['title' => 'Keamanan Dasar Terstandar',  'desc' => 'Praktik keamanan dasar diterapkan sesuai kebutuhan, tanpa klaim yang berlebihan.'],
                        ];
                    @endphp

                    @foreach ($principles as $i => $p)
                    <div class="reveal d{{ ($i % 3) + 1 }} flex items-start gap-3 rounded-xl border border-slate-100 bg-slate-50 p-4">
                        <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full text-white text-[10px] font-bold shadow-sm"
                              style="background: linear-gradient(135deg, #2460A8, #1B986C)">✓</span>
                        <div>
                            <p class="text-base font-semibold text-[#313062]">{{ $p['title'] }}</p>
                            <p class="mt-0.5 text-sm leading-relaxed text-slate-500">{{ $p['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>


<section id="faq" class="pub-section-alt">
    <div class="pub-container">

        <div class="mx-auto max-w-2xl text-center reveal">
            <span class="pub-label">FAQ</span>
            <h2 class="pub-h2 mt-2">Pertanyaan yang Sering Diajukan</h2>
            <p class="pub-lead mx-auto">
                Jawaban singkat untuk pertanyaan umum sebelum kita berdiskusi lebih lanjut.
            </p>
        </div>

        <div class="mx-auto mt-12 max-w-3xl space-y-3">
            @php
                $faqs = [
                    [
                        'q' => 'Berapa estimasi waktu pengerjaan?',
                        'a' => 'Bergantung pada kompleksitas. Website company profile biasanya selesai dalam 1–2 minggu. Aplikasi web kustom membutuhkan 4–12 minggu tergantung cakupan fitur yang disepakati. Estimasi lebih akurat diberikan setelah sesi discovery.'
                    ],
                    [
                        'q' => 'Bisa mulai dari website dulu, lalu lanjut ke sistem yang lebih kompleks?',
                        'a' => 'Bisa. Banyak klien kami memulai dari digital presence, lalu mengembangkan ke aplikasi bisnis seiring kebutuhan yang berkembang. Sistem dirancang agar setiap penambahan tidak merusak yang sudah ada.'
                    ],
                    [
                        'q' => 'Apakah ada support setelah sistem rilis?',
                        'a' => 'Ya. Kami menyediakan masa pemeliharaan setelah rilis dan bisa melanjutkan pengembangan fitur tambahan. Detail support diatur sesuai kesepakatan di awal proyek.'
                    ],
                    [
                        'q' => 'Bisa integrasi dengan tools yang sudah ada (Google Sheets, Email, WhatsApp API, dsb)?',
                        'a' => 'Bisa, selama tools tersebut memiliki API yang tersedia dan terbuka. Kami akan melakukan evaluasi teknis terlebih dahulu sebelum memberikan konfirmasi integrasi yang memungkinkan.'
                    ],
                    [
                        'q' => 'Bisa dikerjakan bertahap sesuai budget?',
                        'a' => 'Bisa. Kami membantu menyusun prioritas fitur sehingga sistem tetap bisa berjalan dengan cakupan yang sesuai kondisi saat ini, lalu dikembangkan bertahap sesuai kebutuhan dan kemampuan.'
                    ],
                    [
                        'q' => 'Apa saja yang dibutuhkan dari klien untuk mulai?',
                        'a' => 'Gambaran kebutuhan bisnis, referensi tampilan jika ada, serta konten seperti teks, logo, atau data yang diperlukan. Kami akan memandu prosesnya jika belum semua siap — tidak perlu dokumen teknis yang rumit untuk memulai diskusi.'
                    ],
                ];
            @endphp

            @foreach ($faqs as $i => $faq)
            <div class="faq-item reveal d{{ ($i % 3) + 1 }} rounded-2xl border border-slate-100 bg-white overflow-hidden shadow-sm">
                <button type="button"
                        class="faq-btn w-full flex items-start justify-between gap-4 px-6 py-5 text-left hover:bg-slate-50 transition-colors duration-150">
                    <span class="font-semibold text-[#313062] text-sm sm:text-base leading-snug">{{ $faq['q'] }}</span>
                    <svg class="faq-chevron mt-0.5 h-5 w-5 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="faq-body">
                    <div class="border-t border-slate-100 px-6 py-4">
                        <p class="text-base leading-relaxed text-slate-500">{{ $faq['a'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<section id="contact" class="relative overflow-hidden py-20 sm:py-28">
    <div class="absolute inset-0" style="background: linear-gradient(140deg, #2C378C 0%, #2460A8 45%, #1E979B 100%)"></div>
    <div class="absolute inset-0 opacity-[0.05]"
         style="background-image: linear-gradient(rgba(255,255,255,.6) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.6) 1px, transparent 1px);
                background-size: 40px 40px;"></div>
    <div class="absolute -right-20 top-0 h-80 w-80 rounded-full opacity-15 blur-3xl pointer-events-none"
         style="background: #238DCA"></div>

    <div class="pub-container relative z-10">
        <div class="mx-auto max-w-2xl text-center reveal">
            <span class="inline-block text-xs font-semibold uppercase tracking-[0.2em] text-white/60 mb-3">Kontak</span>
            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                Mulai dengan Diskusi Singkat
            </h2>
            <p class="mt-4 text-base leading-relaxed text-blue-100/70">
                Ceritakan kebutuhan bisnis Anda. Kami akan membantu memetakan
                solusi yang tepat dan terukur — tanpa komitmen di awal.
            </p>
            <p class="mt-2 text-base text-white/70">
                Jadwalkan diskusi singkat 15 menit untuk mapping kebutuhan.
            </p>
        </div>

        <div class="mx-auto mt-12 grid max-w-3xl gap-4 sm:grid-cols-3">

            <a href="{{ $company['whatsapp_url'] }}"
               target="_blank" rel="noopener noreferrer"
               class="reveal d1 group block rounded-2xl border border-white/15 bg-white/10 p-5 text-center
                      backdrop-blur-sm hover:bg-white/20 hover:border-white/30
                      hover:-translate-y-1 transition-all duration-200">
                <div class="mx-auto mb-3 flex h-11 w-11 items-center justify-center rounded-xl bg-white/15 group-hover:bg-white/25 transition-colors duration-200">
                    <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </div>
                <p class="text-xs font-semibold uppercase tracking-wider text-white/70 mb-1.5">WhatsApp</p>
                <p class="text-base font-semibold text-white">{{ $company['whatsapp'] }}</p>
                <p class="mt-1 text-sm text-white/65 group-hover:text-white/80 transition-colors">Klik untuk chat langsung →</p>
            </a>

            <a href="{{ $company['mailto_url'] }}"
               class="reveal d2 group block rounded-2xl border border-white/15 bg-white/10 p-5 text-center
                      backdrop-blur-sm hover:bg-white/20 hover:border-white/30
                      hover:-translate-y-1 transition-all duration-200">
                <div class="mx-auto mb-3 flex h-11 w-11 items-center justify-center rounded-xl bg-white/15 group-hover:bg-white/25 transition-colors duration-200">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-xs font-semibold uppercase tracking-wider text-white/70 mb-1.5">Email</p>
                <p class="text-base font-semibold text-white break-all">{{ $company['email'] }}</p>
                <p class="mt-1 text-sm text-white/65 group-hover:text-white/80 transition-colors">Klik untuk kirim email →</p>
            </a>

            <a href="{{ $company['maps_url'] }}"
               target="_blank" rel="noopener noreferrer"
               class="reveal d3 group block rounded-2xl border border-white/15 bg-white/10 p-5 text-center
                      backdrop-blur-sm hover:bg-white/20 hover:border-white/30
                      hover:-translate-y-1 transition-all duration-200">
                <div class="mx-auto mb-3 flex h-11 w-11 items-center justify-center rounded-xl bg-white/15 group-hover:bg-white/25 transition-colors duration-200">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="text-xs font-semibold uppercase tracking-wider text-white/70 mb-1.5">Lokasi</p>
                <p class="text-base font-semibold text-white">{{ $company['city'] }}</p>
                <p class="mt-1 text-sm text-white/65 group-hover:text-white/80 transition-colors">Buka di Google Maps →</p>
            </a>
        </div>

        <div class="mx-auto mt-10 max-w-xs text-center reveal">
            <a href="{{ $company['whatsapp_url'] }}" target="_blank" rel="noopener noreferrer"
               class="pub-btn-ghost w-full justify-center py-3.5 text-sm">
                Mulai Konsultasi Sekarang
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

@endsection
