@extends('admin.layouts.app')

@section('content')
<div class="mb-6">
    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Content Management</p>
    <h2 class="mt-1 text-3xl font-bold text-slate-800">Landing BLASKU</h2>
    <p class="mt-3 max-w-3xl text-sm leading-relaxed text-slate-500">
        Kelola data public API untuk landing page <span class="font-semibold text-slate-300">blasku-reach-grow</span>.
        Struktur menu dipisah per area agar pricing, installer, trial, dan contact dapat diatur dari halaman masing-masing.
    </p>
</div>

@include('admin.blasku-landing.partials.subnav')

<section class="mb-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
    <div class="metric-card">
        <p class="metric-label">Pricing Aktif</p>
        <p class="metric-value">{{ $pricingPlans->where('is_active', true)->count() }}</p>
        <p class="metric-note">Total {{ $pricingPlans->count() }} paket landing</p>
    </div>
    <div class="metric-card">
        <p class="metric-label">Installer</p>
        <p class="metric-value">{{ $installer->is_available ? 'Ready' : 'Off' }}</p>
        <p class="metric-note">{{ $installer->version ? 'Versi '.$installer->version : 'Belum dikonfigurasi' }}</p>
    </div>
    <div class="metric-card">
        <p class="metric-label">Trial</p>
        <p class="metric-value">{{ $trialSetting->duration_days ?? 0 }} Hari</p>
        <p class="metric-note">{{ $trialSetting->is_active ? 'CTA aktif' : 'CTA nonaktif' }}</p>
    </div>
    <div class="metric-card">
        <p class="metric-label">WhatsApp</p>
        <p class="metric-value text-xl">{{ $contactSetting->whatsapp_display ?: '-' }}</p>
        <p class="metric-note">{{ $contactSetting->whatsapp_cta_text ?: 'Belum diatur' }}</p>
    </div>
</section>

<div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
    <section class="panel">
        <header class="panel-header">
            <div>
                <h3 class="panel-title">Area Pengelolaan</h3>
                <p class="mt-2 text-sm text-slate-500">Masuk ke submenu yang relevan untuk mengubah konten landing BLASKU.</p>
            </div>
        </header>

        <div class="panel-body grid gap-4 md:grid-cols-2">
            <a href="{{ route('admin.blasku-landing.pricing.index') }}" class="docs-item transition hover:border-brand-500/30 hover:bg-brand-500/10">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-slate-100">Pricing</p>
                        <p class="mt-1 text-sm text-slate-400">Kelola paket, urutan, highlight, dan CTA.</p>
                    </div>
                    <span class="status-active">{{ $pricingPlans->count() }} item</span>
                </div>
            </a>

            <a href="{{ route('admin.blasku-landing.installer.index') }}" class="docs-item transition hover:border-brand-500/30 hover:bg-brand-500/10">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-slate-100">Installer</p>
                        <p class="mt-1 text-sm text-slate-400">Atur versi, URL download, dan availability.</p>
                    </div>
                    <span class="{{ $installer->is_available ? 'status-active' : 'status-inactive' }}">
                        {{ $installer->is_available ? 'ready' : 'off' }}
                    </span>
                </div>
            </a>

            <a href="{{ route('admin.blasku-landing.trial.index') }}" class="docs-item transition hover:border-brand-500/30 hover:bg-brand-500/10">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-slate-100">Trial</p>
                        <p class="mt-1 text-sm text-slate-400">Atur durasi trial, CTA, dan status tampil.</p>
                    </div>
                    <span class="{{ $trialSetting->is_active ? 'status-active' : 'status-inactive' }}">
                        {{ $trialSetting->duration_days }} hari
                    </span>
                </div>
            </a>

            <a href="{{ route('admin.blasku-landing.contact.index') }}" class="docs-item transition hover:border-brand-500/30 hover:bg-brand-500/10">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-slate-100">Contact</p>
                        <p class="mt-1 text-sm text-slate-400">Atur WhatsApp CTA dan tautan kontak sosial.</p>
                    </div>
                    <span class="status-warning">CTA</span>
                </div>
            </a>
        </div>
    </section>

    <section class="panel">
        <header class="panel-header">
            <div>
                <h3 class="panel-title">Public API</h3>
                <p class="mt-2 text-sm text-slate-500">Endpoint yang dikonsumsi landing page BLASKU.</p>
            </div>
        </header>

        <div class="panel-body space-y-3 text-sm text-slate-400">
            @foreach($publicApiEndpoints as $endpoint)
                <div class="flex items-center justify-between gap-3 rounded-xl border border-slate-700/70 px-3 py-3">
                    <div>
                        <p class="font-semibold text-slate-100">{{ $endpoint['label'] }}</p>
                        <p class="code-text mt-1">GET {{ $endpoint['path'] }}</p>
                    </div>
                    <a href="{{ url($endpoint['path']) }}" target="_blank" rel="noreferrer" class="btn-table-brand">Buka</a>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
