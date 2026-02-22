<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Authentication' }}</title>
    <script>
    (function () {
        try {
            var savedTheme = localStorage.getItem('serial-system-theme');
            var theme = savedTheme === 'light' ? 'light' : 'dark';
            document.documentElement.classList.remove('light', 'dark');
            document.documentElement.classList.add(theme);
        } catch (error) {
            document.documentElement.classList.add('dark');
        }
    })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="grid min-h-screen lg:grid-cols-2">
    <div class="fixed right-4 top-4 z-40">
        <button type="button" data-theme-toggle class="btn-secondary inline-flex h-12 w-12 items-center justify-center rounded-xl" aria-label="Ubah tema">
            <svg data-theme-icon class="h-8 w-8" viewBox="0 0 24 24" fill="none" aria-hidden="true"></svg>
        </button>
    </div>

    <section class="relative hidden overflow-hidden bg-gradient-to-br from-brand-700 via-brand-800 to-slate-900 px-12 py-14 text-white lg:flex lg:flex-col lg:justify-between">
        <div class="absolute -left-20 top-20 h-56 w-56 animate-float rounded-full bg-brand-400/25 blur-2xl"></div>
        <div class="absolute -right-14 bottom-20 h-72 w-72 rounded-full bg-white/10 blur-3xl"></div>

        <div class="relative z-10">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-brand-200">Serial System</p>
            <h1 class="mt-5 max-w-md text-4xl font-extrabold leading-tight">Kelola lisensi pelanggan dengan cepat dan rapi.</h1>
            <p class="mt-4 max-w-md text-sm text-brand-100/90">Satu dashboard untuk memantau status lisensi, membuat kode aktivasi, dan mengelola data admin.</p>
        </div>

        <div class="relative z-10 grid grid-cols-2 gap-4 text-sm">
            <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur">
                <p class="text-brand-200">Lebih Praktis</p>
                <p class="mt-1 font-semibold">Semua menu dalam satu layar.</p>
            </div>
            <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur">
                <p class="text-brand-200">Lebih Terkontrol</p>
                <p class="mt-1 font-semibold">Status lisensi selalu terpantau.</p>
            </div>
        </div>
    </section>

    <section class="flex items-center justify-center px-4 py-10 sm:px-6 lg:px-10">
        <div class="app-auth-card w-full max-w-lg rounded-3xl border p-7 shadow-glow backdrop-blur sm:p-8">
            @yield('content')
        </div>
    </section>
</div>

<script>
window.__flashStatus = @json(session('status'));
window.__flashErrors = @json($errors->all());
</script>
</body>
</html>
