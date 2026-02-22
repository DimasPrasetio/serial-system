@extends('admin.layouts.app')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Overview</p>
        <h2 class="mt-1 text-3xl font-bold text-slate-800">Ringkasan Utama</h2>
        <p class="mt-2 text-sm text-slate-500">Pantau aktivitas lisensi dan aplikasi Anda dari satu tempat.</p>
    </div>
</div>

<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <article class="metric-card">
        <p class="metric-label">Total Aplikasi</p>
        <p class="metric-value">{{ $totalApplications }}</p>
        <p class="metric-note">Jumlah aplikasi yang terdaftar.</p>
    </article>
    <article class="metric-card">
        <p class="metric-label">Lisensi Aktif</p>
        <p class="metric-value text-emerald-700">{{ $activeLicenses }}</p>
        <p class="metric-note">Lisensi saat ini valid.</p>
    </article>
    <article class="metric-card">
        <p class="metric-label">Lisensi Kedaluwarsa</p>
        <p class="metric-value text-amber-700">{{ $expiredLicenses }}</p>
        <p class="metric-note">Perlu perpanjangan untuk aktif kembali.</p>
    </article>
    <article class="metric-card">
        <p class="metric-label">Lisensi Dinonaktifkan</p>
        <p class="metric-value text-rose-700">{{ $revokedLicenses }}</p>
        <p class="metric-note">Akses dihentikan oleh admin.</p>
    </article>
</div>

<div class="mt-4 grid gap-4 lg:grid-cols-3">
    <article class="panel panel-body">
        <p class="metric-label">Aktivasi Hari Ini</p>
        <p class="mt-3 text-4xl font-extrabold text-brand-700">{{ $dailyActivations }}</p>
    </article>
    <article class="panel panel-body">
        <p class="metric-label">Trial Hari Ini</p>
        <p class="mt-3 text-4xl font-extrabold text-brand-700">{{ $dailyTrials }}</p>
    </article>
    <article class="panel panel-body">
        <p class="metric-label">Renew Hari Ini</p>
        <p class="mt-3 text-4xl font-extrabold text-indigo-700">{{ $dailyRenews }}</p>
    </article>
</div>
@endsection
