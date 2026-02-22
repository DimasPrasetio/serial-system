<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Serial System Admin' }}</title>
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
<div class="relative min-h-screen lg:pl-72">
    <div id="sidebar-overlay" data-sidebar-overlay class="fixed inset-0 z-30 bg-slate-900/50 backdrop-blur-sm transition lg:hidden"></div>

    <aside id="sidebar" class="app-sidebar fixed inset-y-0 left-0 z-40 flex w-72 flex-col border-r px-5 py-6 backdrop-blur transition duration-300 ease-out">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-card group flex items-center gap-3 rounded-2xl border px-4 py-3 shadow-sm">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-brand-600 text-lg font-black text-white shadow-md">S</span>
            <span>
                <span class="block text-sm font-semibold uppercase tracking-[0.2em] text-brand-700">Serial System</span>
                <span class="block text-xs text-slate-500">Panel Admin</span>
            </span>
        </a>

        <nav class="mt-6 space-y-1.5">
            @can('view-dashboard')
                <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'sidebar-link-active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M4 12.5L12 4l8 8.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6.5 10.5V20h11V10.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
            @endcan

            @can('manage-admins')
                <a class="sidebar-link {{ request()->routeIs('admin.admins.*') ? 'sidebar-link-active' : '' }}" href="{{ route('admin.admins.index') }}">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M16.5 7.5a3.5 3.5 0 11-7 0 3.5 3.5 0 017 0z" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M4.5 19c.7-3 3.2-5 7.5-5s6.8 2 7.5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    <span>Admin</span>
                </a>
            @endcan

            @can('manage-applications')
                <a class="sidebar-link {{ request()->routeIs('admin.applications.*') ? 'sidebar-link-active' : '' }}" href="{{ route('admin.applications.index') }}">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <rect x="3.5" y="3.5" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.8"/>
                        <rect x="13.5" y="3.5" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.8"/>
                        <rect x="3.5" y="13.5" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.8"/>
                        <rect x="13.5" y="13.5" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.8"/>
                    </svg>
                    <span>Aplikasi</span>
                </a>
            @endcan

            @can('manage-plans')
                <a class="sidebar-link {{ request()->routeIs('admin.plans.*') ? 'sidebar-link-active' : '' }}" href="{{ route('admin.plans.index') }}">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M6 4.5h12a1.5 1.5 0 011.5 1.5v12A1.5 1.5 0 0118 19.5H6A1.5 1.5 0 014.5 18V6A1.5 1.5 0 016 4.5z" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M8 9h8M8 13h8M8 17h5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    <span>Paket</span>
                </a>
            @endcan

            @can('manage-serials')
                <a class="sidebar-link {{ request()->routeIs('admin.serials.*') ? 'sidebar-link-active' : '' }}" href="{{ route('admin.serials.index') }}">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M7 8h9a3 3 0 010 6H7V8z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                        <path d="M7 14v2.5A2.5 2.5 0 009.5 19H12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M15 10.5v1M12.5 10.5v1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    <span>Kode Aktivasi</span>
                </a>
            @endcan

            @can('manage-licenses')
                <a class="sidebar-link {{ request()->routeIs('admin.licenses.*') ? 'sidebar-link-active' : '' }}" href="{{ route('admin.licenses.index') }}">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 3.5l7 3v5.3c0 4.2-2.7 7.9-7 8.9-4.3-1-7-4.7-7-8.9V6.5l7-3z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                        <path d="M9 11.5l2 2 4-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Lisensi</span>
                </a>
            @endcan

            @can('view-docs')
                <a class="sidebar-link {{ request()->routeIs('admin.docs') ? 'sidebar-link-active' : '' }}" href="{{ route('admin.docs') }}">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M7 4.5h10A2.5 2.5 0 0119.5 7v10A2.5 2.5 0 0117 19.5H7A2.5 2.5 0 014.5 17V7A2.5 2.5 0 017 4.5z" stroke="currentColor" stroke-width="1.8"/>
                        <path d="M8.5 9h7M8.5 12h7M8.5 15h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    <span>Docs</span>
                </a>
            @endcan
            
        </nav>
    </aside>

    <div class="relative z-10">
        <header class="app-header sticky top-0 z-20 border-b backdrop-blur">
            <div class="mx-auto flex max-w-[1440px] items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <button type="button" data-sidebar-toggle class="btn-secondary btn lg:hidden">Menu</button>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Serial System</p>
                        <h1 class="text-lg font-bold text-slate-800">{{ $title ?? 'Dashboard Admin' }}</h1>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" data-theme-toggle class="btn-secondary inline-flex h-12 w-12 items-center justify-center rounded-xl" aria-label="Ubah tema">
                        <svg data-theme-icon class="h-8 w-8" viewBox="0 0 24 24" fill="none" aria-hidden="true"></svg>
                    </button>
                    <span class="app-user-chip hidden rounded-xl border px-3 py-2 text-sm font-medium sm:inline-flex">
                        {{ auth('admin')->user()?->name }}
                    </span>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button class="btn-secondary btn" type="submit">Keluar</button>
                    </form>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-[1440px] px-4 py-6 sm:px-6 lg:px-8">
            @yield('content')
        </main>
    </div>
</div>

<script>
window.__flashStatus = @json(session('status'));
window.__flashErrors = @json($errors->all());
</script>
@stack('scripts')
</body>
</html>
