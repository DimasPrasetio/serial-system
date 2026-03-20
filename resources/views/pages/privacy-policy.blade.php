@extends('layouts.public')

@section('title', 'Kebijakan Privasi — ElcodeLabs')
@section('meta_description', 'Kebijakan privasi ElcodeLabs menjelaskan data apa yang kami kumpulkan dan bagaimana kami menggunakannya.')

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
        <h1 class="text-3xl font-extrabold text-white tracking-tight sm:text-4xl">Kebijakan Privasi</h1>
        <p class="mt-3 text-slate-400">Berlaku sejak: 1 Januari 2025 &mdash; Terakhir diperbarui: {{ date('d F Y') }}</p>
    </div>

    <div class="prose-policy space-y-8 text-slate-400 leading-relaxed">

        <section>
            <p>
                ElcodeLabs, yang dioperasikan oleh <strong class="text-slate-200">PT. Prayora Karya Pratama</strong>,
                berkomitmen untuk melindungi privasi pengguna layanan kami. Kebijakan ini menjelaskan data apa yang
                kami kumpulkan, bagaimana kami menggunakannya, dan hak Anda sebagai pengguna.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-white mb-3">1. Data yang Kami Kumpulkan</h2>
            <p class="mb-3">Kami mengumpulkan data berikut ketika Anda menggunakan layanan atau produk kami:</p>
            <ul class="space-y-2 pl-4">
                <li class="flex gap-3">
                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                    <span><strong class="text-slate-300">Alamat email</strong> — digunakan untuk membuat dan mengelola akun lisensi Anda.</span>
                </li>
                <li class="flex gap-3">
                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                    <span><strong class="text-slate-300">Informasi perangkat</strong> — meliputi fingerprint perangkat (hash anonim), label, dan platform sistem operasi, untuk keperluan aktivasi dan manajemen lisensi.</span>
                </li>
                <li class="flex gap-3">
                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                    <span><strong class="text-slate-300">Data lisensi</strong> — termasuk jenis paket, tanggal aktivasi, dan masa berlaku lisensi.</span>
                </li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-bold text-white mb-3">2. Cara Kami Menggunakan Data</h2>
            <ul class="space-y-2 pl-4">
                <li class="flex gap-3">
                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                    <span>Memvalidasi dan mengaktifkan lisensi perangkat lunak yang Anda miliki.</span>
                </li>
                <li class="flex gap-3">
                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                    <span>Mencegah penyalahgunaan lisensi, termasuk penggunaan di lebih dari jumlah perangkat yang diizinkan.</span>
                </li>
                <li class="flex gap-3">
                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                    <span>Mengirimkan informasi teknis atau pembaruan terkait layanan yang Anda gunakan.</span>
                </li>
                <li class="flex gap-3">
                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                    <span>Memberikan dukungan pelanggan apabila diperlukan.</span>
                </li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-bold text-white mb-3">3. Penyimpanan & Keamanan Data</h2>
            <p>
                Data Anda disimpan di server yang berlokasi di Indonesia. Kami menerapkan langkah-langkah keamanan
                teknis yang wajar, termasuk enkripsi pada data sensitif seperti token autentikasi dan hash identitas
                perangkat. Kami tidak menyimpan kata sandi dalam bentuk teks biasa.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-white mb-3">4. Berbagi Data dengan Pihak Ketiga</h2>
            <p>
                Kami <strong class="text-slate-200">tidak menjual</strong> data pribadi Anda kepada pihak ketiga.
                Data hanya dapat dibagikan apabila diwajibkan oleh hukum yang berlaku di Indonesia.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-white mb-3">5. Hak Anda</h2>
            <p class="mb-3">Anda berhak untuk:</p>
            <ul class="space-y-2 pl-4">
                <li class="flex gap-3">
                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                    <span>Meminta akses terhadap data pribadi yang kami simpan atas nama Anda.</span>
                </li>
                <li class="flex gap-3">
                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                    <span>Meminta penghapusan data Anda, selama tidak bertentangan dengan kewajiban hukum.</span>
                </li>
            </ul>
            <p class="mt-3">
                Untuk mengajukan permintaan, hubungi kami melalui
                <a href="mailto:{{ $company['email'] }}" class="text-brand-400 hover:underline">{{ $company['email'] }}</a>.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-white mb-3">6. Perubahan Kebijakan</h2>
            <p>
                Kami dapat memperbarui kebijakan ini sewaktu-waktu. Perubahan signifikan akan kami informasikan
                melalui saluran komunikasi resmi kami. Penggunaan layanan secara berkelanjutan setelah perubahan
                dianggap sebagai penerimaan terhadap kebijakan yang diperbarui.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-white mb-3">7. Hubungi Kami</h2>
            <p>Jika Anda memiliki pertanyaan terkait kebijakan privasi ini, silakan hubungi:</p>
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
