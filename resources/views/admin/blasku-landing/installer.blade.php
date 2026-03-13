@extends('admin.layouts.app')

@section('content')
<div class="mb-6 flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Landing BLASKU</p>
        <h2 class="mt-1 text-3xl font-bold text-slate-800">Installer</h2>
        <p class="mt-3 max-w-3xl text-sm leading-relaxed text-slate-500">
            Atur versi installer, link download, release notes, dan status availability untuk landing BLASKU.
        </p>
    </div>

    <span class="{{ $installer->is_available ? 'status-active' : 'status-inactive' }}">
        {{ $installer->is_available ? 'available' : 'unavailable' }}
    </span>
</div>

@include('admin.blasku-landing.partials.subnav')

<section class="panel">
    <header class="panel-header">
        <div>
            <h3 class="panel-title">Konfigurasi Installer</h3>
            <p class="mt-2 text-sm text-slate-500">Perubahan di sini langsung mempengaruhi endpoint public installer.</p>
        </div>
        @if($installer->download_url)
            <a href="{{ $installer->download_url }}" target="_blank" rel="noreferrer" class="btn-table-brand">Buka File</a>
        @endif
    </header>

    <div class="panel-body">
        <form method="POST" action="{{ route('admin.blasku-landing.installer.update') }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="field-label" for="installer_version">Versi</label>
                    <input id="installer_version" class="field-input" name="version" value="{{ old('version', $installer->version) }}" required>
                </div>
                <div>
                    <label class="field-label" for="installer_platform">Platform</label>
                    <input id="installer_platform" class="field-input" name="platform" value="{{ old('platform', $installer->platform ?: 'windows') }}" required>
                </div>
            </div>
            <div>
                <label class="field-label" for="installer_download_url">Direct Download URL</label>
                <input id="installer_download_url" class="field-input" name="download_url" value="{{ old('download_url', $installer->download_url) }}" required>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="field-label" for="installer_file_size_mb">Ukuran File (MB)</label>
                    <input id="installer_file_size_mb" class="field-input" type="number" step="0.1" min="0" name="file_size_mb" value="{{ old('file_size_mb', $installer->file_size_mb) }}">
                </div>
                <div>
                    <label class="field-label" for="installer_released_at">Release Date</label>
                    <input id="installer_released_at" class="field-input" type="datetime-local" name="released_at" value="{{ old('released_at', optional($installer->released_at)->format('Y-m-d\\TH:i')) }}">
                </div>
            </div>
            <div>
                <label class="field-label" for="installer_release_notes">Release Notes</label>
                <textarea id="installer_release_notes" class="field-input min-h-[120px]" name="release_notes">{{ old('release_notes', $installer->release_notes) }}</textarea>
            </div>
            <div>
                <label class="field-label" for="installer_is_available">Status Availability</label>
                <select id="installer_is_available" class="field-select" name="is_available" required>
                    <option value="1" @selected((string) old('is_available', (int) $installer->is_available) === '1')>available</option>
                    <option value="0" @selected((string) old('is_available', (int) $installer->is_available) === '0')>unavailable</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="btn-primary">Simpan Installer</button>
            </div>
        </form>
    </div>
</section>
@endsection
