<!doctype html>
<html lang="id">

<head>
    <script>
        document.documentElement.classList.add('js');
    </script>

    <!-- Preconnect hints for faster font loading -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ElcodeLabs — Mitra Digital Bisnis Anda')</title>
    <meta name="description"
        content="@yield('meta_description', 'ElcodeLabs membantu bisnis mendigitalkan operasional — dari kasir, stok, hingga laporan — agar lebih rapi, cepat, dan terkendali.')">
    <link rel="icon" type="image/png" href="/icon/logo.png">
    <link rel="shortcut icon" href="/icon/logo.png">
    <link rel="apple-touch-icon" href="/icon/logo.png">
    <!-- Fonts -->
    <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300..800&display=swap"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300..800&display=swap"
            rel="stylesheet">
    </noscript>

    @vite(['resources/css/public.css'])
</head>

<body class="bg-slate-900 text-slate-300 antialiased selection:bg-brand-500 selection:text-white">
    <nav id="pub-nav"
        class="fixed top-0 w-full z-50 bg-slate-950/50 backdrop-blur-xl border-b border-white/5 transition-all duration-300">
        <div class="mx-auto max-w-[1100px] px-5 sm:px-8">

            <div class="relative flex h-[76px] items-center">

                <a href="{{ route('public.home') }}" class="group relative z-10 flex shrink-0 items-center gap-3">
                    <div
                        class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-brand-400 to-brand-600 p-[1px]">
                        <div
                            class="h-full w-full rounded-xl bg-slate-950 flex items-center justify-center transition-colors duration-300 group-hover:bg-slate-900">
                            <img src="/icon/logo.png" alt="ElcodeLabs" width="96" height="96" decoding="async"
                                fetchpriority="high" class="h-6 w-auto object-contain">
                        </div>
                    </div>
                    <span class="flex flex-col leading-none">
                        <span
                            class="inline-flex items-baseline whitespace-nowrap text-[16px] font-extrabold tracking-tight sm:text-lg text-white">
                            Elcode<span class="text-brand-400">Labs</span>
                        </span>
                        <span
                            class="mt-1 hidden text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-400 sm:block">
                            Mitra Digital Bisnis
                        </span>
                    </span>
                </a>

                <div class="absolute inset-x-0 hidden items-center justify-center md:flex pointer-events-none">
                    <div
                        class="flex items-center gap-1 rounded-full border border-white/10 bg-white/5 p-1.5 backdrop-blur-md pointer-events-auto">
                        <a href="#about" class="pub-nav-link">Tentang</a>
                        <a href="#services" class="pub-nav-link">Layanan</a>
                        <a href="#process" class="pub-nav-link">Cara Kerja</a>
                        <a href="#faq" class="pub-nav-link">FAQ</a>
                    </div>
                </div>

                <div class="relative z-10 ml-auto flex items-center gap-3">
                    <a href="#contact" class="nav-cta hidden md:inline-flex">
                        Diskusi Kebutuhan
                        <svg class="h-3.5 w-3.5 ml-1 transition-transform group-hover:translate-x-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>

                    <button id="nav-toggle" type="button"
                        class="md:hidden flex h-10 w-10 items-center justify-center rounded-lg border border-white/10 bg-white/5 text-slate-300 hover:bg-white/10 hover:text-white transition-colors"
                        aria-label="Buka atau tutup menu navigasi" aria-expanded="false">
                        <svg id="icon-ham" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                d="M4 7h16M4 12h16M4 17h16" />
                        </svg>
                        <svg id="icon-close" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div id="mobile-menu" class="mobile-nav-menu md:hidden">
                <div class="border-t border-white/10 py-4">
                    <div class="space-y-1">
                        <a href="#about"
                            class="mnav flex items-center gap-3 rounded-xl px-4 py-3.5 text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition-colors">
                            <span class="h-1.5 w-1.5 rounded-full bg-brand-500"></span>Tentang
                        </a>
                        <a href="#services"
                            class="mnav flex items-center gap-3 rounded-xl px-4 py-3.5 text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition-colors">
                            <span class="h-1.5 w-1.5 rounded-full bg-brand-500"></span>Layanan
                        </a>
                        <a href="#process"
                            class="mnav flex items-center gap-3 rounded-xl px-4 py-3.5 text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition-colors">
                            <span class="h-1.5 w-1.5 rounded-full bg-brand-500"></span>Cara Kerja
                        </a>
                        <a href="#faq"
                            class="mnav flex items-center gap-3 rounded-xl px-4 py-3.5 text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition-colors">
                            <span class="h-1.5 w-1.5 rounded-full bg-brand-500"></span>FAQ
                        </a>
                    </div>
                    <div class="mt-4 pb-2">
                        <a href="#contact" class="mnav nav-cta w-full justify-center rounded-xl py-3.5">
                            Diskusi Kebutuhan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="relative">
        @yield('content')
    </main>

    <footer class="relative z-10 border-t border-white/10 bg-slate-950 mt-20">
        <div class="mx-auto max-w-[1100px] px-5 sm:px-8 py-12">
            <div class="flex flex-col items-center gap-6 sm:flex-row sm:justify-between">
                <a href="{{ route('public.home') }}" class="flex items-center gap-3 group">
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-brand-400 to-brand-600 p-[1px]">
                        <div
                            class="h-full w-full rounded-lg bg-slate-950 flex items-center justify-center transition-colors duration-300 group-hover:bg-slate-900">
                            <img src="/icon/logo.png" alt="ElcodeLabs" width="64" height="64" loading="lazy"
                                decoding="async"
                                class="h-4 w-auto object-contain opacity-80 group-hover:opacity-100 transition-opacity">
                        </div>
                    </div>
                    <span
                        class="text-sm font-bold text-slate-300 group-hover:text-white transition-colors">ElcodeLabs</span>
                </a>
                <div class="flex flex-wrap justify-center items-center gap-x-8 gap-y-4">
                    <a href="#services"
                        class="text-sm font-medium text-slate-500 hover:text-brand-400 transition-colors">Layanan</a>
                    <a href="#process"
                        class="text-sm font-medium text-slate-500 hover:text-brand-400 transition-colors">Cara Kerja</a>
                    <a href="#contact"
                        class="text-sm font-medium text-slate-500 hover:text-brand-400 transition-colors">Kontak</a>
                </div>
                <p class="text-sm text-slate-600">
                    &copy; {{ date('Y') }} ElcodeLabs.
                </p>
            </div>
        </div>
    </footer>

    <script>
        function initPublicLayout() {
            const toggle = document.getElementById('nav-toggle');
            const menu = document.getElementById('mobile-menu');
            const iconHam = document.getElementById('icon-ham');
            const iconClose = document.getElementById('icon-close');
            const nav = document.getElementById('pub-nav');
            let isOpen = false;

            function setNav(open) {
                isOpen = open;
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                if (open) {
                    menu.style.maxHeight = menu.scrollHeight + 'px';
                    iconHam.classList.add('hidden');
                    iconClose.classList.remove('hidden');
                } else {
                    menu.style.maxHeight = '0';
                    iconHam.classList.remove('hidden');
                    iconClose.classList.add('hidden');
                }
            }

            toggle.addEventListener('click', () => setNav(!isOpen));
            document.querySelectorAll('.mnav').forEach(link => {
                link.addEventListener('click', () => setNav(false));
            });

            const syncNavState = () => {
                const active = window.scrollY > 24;
                nav.classList.toggle('bg-slate-950/80', active);
                nav.classList.toggle('border-white/10', active);
                nav.classList.toggle('border-white/5', !active);
            };

            let ticking = false;
            window.addEventListener('scroll', () => {
                if (!ticking) {
                    window.requestAnimationFrame(() => {
                        syncNavState();
                        ticking = false;
                    });
                    ticking = true;
                }
            }, { passive: true });

            syncNavState();
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initPublicLayout);
        } else {
            initPublicLayout();
        }
    </script>

    @stack('scripts')
</body>

</html>
