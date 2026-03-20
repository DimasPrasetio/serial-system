@extends('layouts.public')

@section('title', 'Ketentuan Layanan — ElcodeLabs')
@section('meta_description', 'Ketentuan layanan ElcodeLabs mengatur penggunaan produk dan jasa yang kami sediakan.')

@section('content')
<div class="mx-auto max-w-[780px] px-5 sm:px-8 pt-32 pb-20">

    <div class="mb-10">
        <a href="{{ route('public.home') }}"
            class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-brand-400 transition-colors mb-6">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Beranda
        </a>
        <p class="text-xs font-semibold uppercase tracking-widest text-brand-400 mb-3">Legal</p>
        <h1 class="text-3xl font-extrabold text-white tracking-tight sm:text-4xl">Ketentuan Layanan</h1>
        <p class="mt-3 text-slate-400">Berlaku sejak: 1 Januari 2025 &mdash; Terakhir diperbarui: {{ date('d F Y') }}</p>
    </div>

    <div class="prose-policy space-y-8 text-slate-400 leading-relaxed">

        <section>
            <p>
                Dengan menggunakan produk atau layanan yang disediakan oleh
                <strong class="text-slate-200">ElcodeLabs</strong> (dioperasikan oleh
                <strong class="text-slate-200">PT. Prayora Karya Pratama</strong>), Anda menyetujui
                ketentuan-ketentuan berikut ini. Harap baca dengan seksama sebelum menggunakan layanan kami.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-white mb-3">1. Penggunaan Lisensi Perangkat Lunak</h2>
            <ul class="space-y-2 pl-4">
                <li class="flex gap-3">
                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                    <span>Lisensi yang Anda aktifkan bersifat <strong class="text-slate-300">non-eksklusif</strong> dan hanya berlaku untuk jumlah perangkat sesuai paket yang dipilih.</span>
                </li>
                <li class="flex gap-3">
                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                    <span>Lisensi <strong class="text-slate-300">tidak dapat dipindahkan</strong> ke pihak lain tanpa persetujuan tertulis dari kami.</span>
                </li>
                <li class="flex gap-3">
                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                    <span>Dilarang menduplikasi, mendistribusikan ulang, merekayasa balik, atau memodifikasi perangkat lunak tanpa izin.</span>
                </li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-bold text-white mb-3">2. Lisensi Trial</h2>
            <ul class="space-y-2 pl-4">
                <li class="flex gap-3">
                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                    <span>Setiap perangkat hanya berhak mendapatkan <strong class="text-slate-300">satu kali</strong> lisensi trial.</span>
                </li>
                <li class="flex gap-3">
                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                    <span>Lisensi trial berlaku selama periode yang tercantum dan akan berakhir secara otomatis setelah masa trial habis.</span>
                </li>
                <li class="flex gap-3">
                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                    <span>Penyalahgunaan fasilitas trial dapat mengakibatkan pemblokiran akses.</span>
                </li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-bold text-white mb-3">3. Pembayaran & Pembaruan Lisensi</h2>
            <ul class="space-y-2 pl-4">
                <li class="flex gap-3">
                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                    <span>Pembayaran dilakukan di muka sesuai paket dan periode yang dipilih.</span>
                </li>
                <li class="flex gap-3">
                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                    <span>Kami tidak memberikan refund untuk lisensi yang sudah diaktifkan kecuali terdapat kerusakan kritis dari sisi kami.</span>
                </li>
                <li class="flex gap-3">
                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                    <span>Perpanjangan lisensi dapat dilakukan sebelum atau sesudah masa berlaku habis melalui saluran resmi kami.</span>
                </li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-bold text-white mb-3">4. Pembekuan & Pencabutan Lisensi</h2>
            <p>
                Kami berhak membekukan atau mencabut lisensi tanpa pemberitahuan sebelumnya apabila ditemukan
                pelanggaran terhadap ketentuan ini, termasuk namun tidak terbatas pada penggunaan di luar jumlah
                perangkat yang diizinkan atau aktivitas yang merugikan sistem kami.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-white mb-3">5. Layanan & Dukungan</h2>
            <ul class="space-y-2 pl-4">
                <li class="flex gap-3">
                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                    <span>Dukungan teknis diberikan melalui WhatsApp atau email selama jam operasional kami.</span>
                </li>
                <li class="flex gap-3">
                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                    <span>Kami berhak melakukan pemeliharaan sistem yang dapat menyebabkan gangguan layanan sementara, dan akan berupaya memberitahukan terlebih dahulu apabila memungkinkan.</span>
                </li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-bold text-white mb-3">6. Batasan Tanggung Jawab</h2>
            <p>
                ElcodeLabs tidak bertanggung jawab atas kerugian tidak langsung, kehilangan data, atau gangguan
                operasional yang timbul dari penggunaan atau ketidakmampuan menggunakan layanan kami, di luar
                kelalaian langsung dari pihak kami.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-white mb-3">7. Hukum yang Berlaku</h2>
            <p>
                Ketentuan ini diatur dan ditafsirkan berdasarkan hukum yang berlaku di
                <strong class="text-slate-200">Republik Indonesia</strong>. Sengketa yang timbul akan diselesaikan
                secara musyawarah, dan apabila tidak tercapai kesepakatan, diselesaikan melalui jalur hukum yang
                berlaku di Bandung, Jawa Barat.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-white mb-3">8. Perubahan Ketentuan</h2>
            <p>
                Kami berhak memperbarui ketentuan ini sewaktu-waktu. Versi terbaru selalu tersedia di halaman ini.
                Penggunaan layanan secara berkelanjutan setelah perubahan berlaku dianggap sebagai penerimaan
                terhadap ketentuan yang diperbarui.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-white mb-3">9. Hubungi Kami</h2>
            <p>Pertanyaan seputar ketentuan layanan ini dapat disampaikan kepada:</p>
            <div class="mt-4 rounded-xl border border-white/10 bg-white/5 p-5 space-y-2 text-sm">
                <p class="font-semibold text-slate-200">PT. Prayora Karya Pratama</p>
                <p>Beroperasi sebagai <span class="text-brand-400">ElcodeLabs</span></p>
                <p>{{ $company['city'] }}, {{ $company['country'] }}</p>
                <p>
                    Email:
                    <a href="{{ $company['mailto_url'] }}" class="text-brand-400 hover:underline">{{ $company['email'] }}</a>
                </p>
                <p>
                    WhatsApp:
                    <a href="{{ $company['whatsapp_url'] }}" target="_blank" rel="noopener noreferrer"
                        class="text-brand-400 hover:underline">{{ $company['whatsapp'] }}</a>
                </p>
            </div>
        </section>

    </div>
</div>
@endsection
