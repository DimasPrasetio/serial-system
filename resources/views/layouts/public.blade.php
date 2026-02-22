<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ElcodeLabs — Mitra Digital Bisnis Anda')</title>
    <meta name="description" content="@yield('meta_description', 'ElcodeLabs membantu bisnis membangun sistem digital yang terstruktur, efisien, dan siap berkembang.')">
    <link rel="icon" type="image/png" href="/icon/logo.png">
    <link rel="shortcut icon" href="/icon/logo.png">
    <link rel="apple-touch-icon" href="/icon/logo.png">
    @vite(['resources/css/public.css'])
</head>
<body class="bg-white text-slate-700 antialiased">

<nav id="pub-nav" class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100/80 transition-all duration-300">
    <div class="mx-auto max-w-[1100px] px-5 sm:px-8">

        <div class="relative flex h-[68px] items-center">

            <a href="{{ route('public.home') }}"
               class="group relative z-10 flex shrink-0 items-center gap-3">
                <img src="/icon/logo.png" alt="ElcodeLabs"
                     class="h-10 w-auto object-contain transition-opacity duration-200 group-hover:opacity-75">
                <span class="flex flex-col leading-none">
                    <span class="inline-flex items-baseline whitespace-nowrap text-[15px] font-extrabold tracking-tight sm:text-base">
                        <span class="text-[#313062] transition-colors duration-200 group-hover:text-[#2460A8]">Elcode</span>
                        <span class="ml-0.5 text-gradient">Labs</span>
                    </span>
                    <span class="mt-1 hidden text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-400 sm:block">
                        Digital Systems
                    </span>
                </span>
            </a>

            <div class="absolute inset-x-0 hidden items-center justify-center md:flex pointer-events-none">
                <div class="flex items-center gap-0.5 pointer-events-auto">
                    <a href="#about"    class="pub-nav-link">Tentang</a>
                    <a href="#services" class="pub-nav-link">Layanan</a>
                    <a href="#process"  class="pub-nav-link">Cara Kerja</a>
                    <a href="#faq"      class="pub-nav-link">FAQ</a>
                    <a href="#contact"  class="pub-nav-link">Kontak</a>
                </div>
            </div>

            <div class="relative z-10 ml-auto flex items-center gap-2.5">
                <a href="#contact" class="nav-cta hidden md:inline-flex">
                    Konsultasi
                    <svg class="h-3.5 w-3.5 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>

                <button id="nav-toggle" type="button"
                        class="md:hidden flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors"
                        aria-label="Buka menu" aria-expanded="false">
                    <svg id="icon-ham" class="h-[22px] w-[22px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M4 7h16M4 12h16M4 17h16"/>
                    </svg>
                    <svg id="icon-close" class="h-[22px] w-[22px] hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="mobile-nav-menu md:hidden">
            <div class="border-t border-slate-100 py-3">
                <div class="space-y-0.5">
                    <a href="#about"    class="mnav flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-[#2460A8] transition-colors">
                        <span class="h-1 w-1 rounded-full bg-slate-300"></span>Tentang
                    </a>
                    <a href="#services" class="mnav flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-[#2460A8] transition-colors">
                        <span class="h-1 w-1 rounded-full bg-slate-300"></span>Layanan
                    </a>
                    <a href="#process"  class="mnav flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-[#2460A8] transition-colors">
                        <span class="h-1 w-1 rounded-full bg-slate-300"></span>Cara Kerja
                    </a>
                    <a href="#faq"      class="mnav flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-[#2460A8] transition-colors">
                        <span class="h-1 w-1 rounded-full bg-slate-300"></span>FAQ
                    </a>
                    <a href="#contact"  class="mnav flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-[#2460A8] transition-colors">
                        <span class="h-1 w-1 rounded-full bg-slate-300"></span>Kontak
                    </a>
                </div>
                <div class="mt-3 pb-2">
                    <a href="#contact" class="mnav nav-cta w-full justify-center rounded-xl">
                        Mulai Konsultasi
                        <svg class="h-3.5 w-3.5 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<main>
    @yield('content')
</main>

<footer class="border-t border-slate-100 bg-slate-50">
    <div class="pub-container py-10">
        <div class="flex flex-col items-center gap-4 sm:flex-row sm:justify-between">
            <a href="{{ route('public.home') }}" class="flex items-center">
                <img src="/icon/logo.png" alt="ElcodeLabs" class="h-9 w-auto object-contain opacity-80 hover:opacity-100 transition-opacity duration-200">
            </a>
            <div class="flex items-center gap-6">
                <a href="#services" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">Layanan</a>
                <a href="#process"  class="text-sm text-slate-500 hover:text-slate-700 transition-colors">Cara Kerja</a>
                <a href="#contact"  class="text-sm text-slate-500 hover:text-slate-700 transition-colors">Kontak</a>
            </div>
            <p class="text-sm text-slate-500">
                &copy; {{ date('Y') }} ElcodeLabs. Seluruh hak dilindungi.
            </p>
        </div>
    </div>
</footer>

<script>
(function () {
    'use strict';

    var toggle   = document.getElementById('nav-toggle');
    var menu     = document.getElementById('mobile-menu');
    var iconHam  = document.getElementById('icon-ham');
    var iconClose= document.getElementById('icon-close');
    var isOpen   = false;

    function setNav(open) {
        isOpen = open;
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        if (open) {
            menu.style.maxHeight = menu.scrollHeight + 40 + 'px';
            iconHam.classList.add('hidden');
            iconClose.classList.remove('hidden');
        } else {
            menu.style.maxHeight = '0';
            iconHam.classList.remove('hidden');
            iconClose.classList.add('hidden');
        }
    }

    toggle.addEventListener('click', function () { setNav(!isOpen); });

    document.querySelectorAll('.mnav').forEach(function (link) {
        link.addEventListener('click', function () { setNav(false); });
    });

    var nav = document.getElementById('pub-nav');
    window.addEventListener('scroll', function () {
        if (window.scrollY > 8) {
            nav.style.boxShadow = '0 4px 24px -6px rgba(36,96,168,.18)';
        } else {
            nav.style.boxShadow = '';
        }
    }, { passive: true });

    document.querySelectorAll('.faq-item').forEach(function (item) {
        var btn = item.querySelector('.faq-btn');
        if (!btn) return;
        btn.addEventListener('click', function () {
            var wasOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item').forEach(function (i) {
                i.classList.remove('open');
            });
            if (!wasOpen) item.classList.add('open');
        });
    });

    var revealEls = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        revealEls.forEach(function (el) { observer.observe(el); });
    } else {
        revealEls.forEach(function (el) { el.classList.add('revealed'); });
    }

})();
</script>

@stack('scripts')
</body>
</html>
