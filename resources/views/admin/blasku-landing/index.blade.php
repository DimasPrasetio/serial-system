@extends('admin.layouts.app')

@section('content')
<div class="mb-6 flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Content Management</p>
        <h2 class="mt-1 text-3xl font-bold text-slate-800">Landing BLASKU</h2>
        <p class="mt-3 max-w-3xl text-sm leading-relaxed text-slate-500">
            Kelola data public API untuk landing page <span class="font-semibold text-slate-300">blasku-reach-grow</span>.
            Semua perubahan di halaman ini akan dipakai oleh endpoint public yang dikonsumsi frontend landing.
        </p>
    </div>

    <div class="panel w-full max-w-xl">
        <div class="panel-body grid gap-3 text-sm text-slate-400">
            <div class="flex items-center justify-between gap-3">
                <span class="font-semibold uppercase tracking-[0.18em] text-slate-500">Public API</span>
                <span class="status-active">BLASKU</span>
            </div>
            <div class="space-y-2">
                <div class="flex items-center justify-between gap-3 rounded-xl border border-slate-700/70 px-3 py-2">
                    <span class="code-text">GET /api/v1/public/pricing-plans</span>
                    <a href="{{ url('/api/v1/public/pricing-plans') }}" target="_blank" rel="noreferrer" class="btn-table-brand">Buka</a>
                </div>
                <div class="flex items-center justify-between gap-3 rounded-xl border border-slate-700/70 px-3 py-2">
                    <span class="code-text">GET /api/v1/public/installer</span>
                    <a href="{{ url('/api/v1/public/installer') }}" target="_blank" rel="noreferrer" class="btn-table-brand">Buka</a>
                </div>
                <div class="flex items-center justify-between gap-3 rounded-xl border border-slate-700/70 px-3 py-2">
                    <span class="code-text">GET /api/v1/public/trial</span>
                    <a href="{{ url('/api/v1/public/trial') }}" target="_blank" rel="noreferrer" class="btn-table-brand">Buka</a>
                </div>
                <div class="flex items-center justify-between gap-3 rounded-xl border border-slate-700/70 px-3 py-2">
                    <span class="code-text">GET /api/v1/public/contact</span>
                    <a href="{{ url('/api/v1/public/contact') }}" target="_blank" rel="noreferrer" class="btn-table-brand">Buka</a>
                </div>
            </div>
        </div>
    </div>
</div>

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

<section class="panel mb-6 overflow-hidden">
    <header class="panel-header">
        <div>
            <h3 class="panel-title">Pricing Landing</h3>
            <p class="mt-2 text-sm text-slate-500">Kelola paket harga yang akan tampil di section pricing landing page.</p>
        </div>
        <button type="button" data-dialog-open="createPricingPlanDialog" class="btn-primary">Tambah Paket Landing</button>
    </header>

    <div class="table-shell">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Urutan</th>
                    <th>Paket</th>
                    <th>Harga</th>
                    <th>Badge</th>
                    <th>Highlight</th>
                    <th>Status</th>
                    <th>CTA</th>
                    <th class="w-[180px]">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($pricingPlans as $plan)
                <tr>
                    <td>{{ $plan->sort_order }}</td>
                    <td>
                        <div class="font-semibold text-slate-100">{{ $plan->name }}</div>
                        <div class="mt-1 text-xs text-slate-400">{{ $plan->slug }} • {{ $plan->period }}</div>
                    </td>
                    <td>
                        <div class="font-semibold text-slate-100">Rp{{ number_format($plan->price, 0, ',', '.') }}</div>
                        <div class="mt-1 text-xs text-slate-400">
                            @if($plan->original_price)
                                Coret Rp{{ number_format($plan->original_price, 0, ',', '.') }}
                            @else
                                Tanpa harga coret
                            @endif
                        </div>
                    </td>
                    <td>{{ $plan->badge ?: '-' }}</td>
                    <td>
                        <span class="{{ $plan->is_highlighted ? 'status-warning' : 'status-inactive' }}">
                            {{ $plan->is_highlighted ? 'highlighted' : 'normal' }}
                        </span>
                    </td>
                    <td>
                        <span class="{{ $plan->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $plan->is_active ? 'active' : 'inactive' }}
                        </span>
                    </td>
                    <td>{{ $plan->cta_text }}</td>
                    <td>
                        <div class="table-action-group">
                            <button type="button" data-dialog-open="editPricingPlanDialog{{ $plan->id }}" class="btn-table-brand">Edit</button>
                            <form method="POST" action="{{ route('admin.blasku-landing.pricing-plans.delete', $plan) }}" class="js-confirm" data-confirm-title="Hapus paket ini?" data-confirm-text="Data pricing plan yang dihapus tidak akan tampil lagi di landing." data-confirm-button="menghapus paket">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-table-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="table-empty">Belum ada data pricing landing.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>

<div class="grid gap-6 xl:grid-cols-2">
    <section class="panel">
        <header class="panel-header">
            <div>
                <h3 class="panel-title">Installer</h3>
                <p class="mt-2 text-sm text-slate-500">Kontrol versi, link download, dan status ketersediaan installer.</p>
            </div>
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

    <section class="panel">
        <header class="panel-header">
            <div>
                <h3 class="panel-title">Trial</h3>
                <p class="mt-2 text-sm text-slate-500">Atur durasi trial, CTA, dan status tampilnya tombol trial di landing page.</p>
            </div>
        </header>
        <div class="panel-body">
            <form method="POST" action="{{ route('admin.blasku-landing.trial.update') }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="field-label" for="trial_duration_days">Durasi Trial (hari)</label>
                        <input id="trial_duration_days" class="field-input" type="number" min="1" name="duration_days" value="{{ old('duration_days', $trialSetting->duration_days) }}" required>
                    </div>
                    <div>
                        <label class="field-label" for="trial_features_included">Fitur</label>
                        <select id="trial_features_included" class="field-select" name="features_included" required>
                            <option value="full" @selected(old('features_included', $trialSetting->features_included) === 'full')>full</option>
                            <option value="limited" @selected(old('features_included', $trialSetting->features_included) === 'limited')>limited</option>
                        </select>
                    </div>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="field-label" for="trial_cta_text">CTA Text</label>
                        <input id="trial_cta_text" class="field-input" name="cta_text" value="{{ old('cta_text', $trialSetting->cta_text) }}" required>
                    </div>
                    <div>
                        <label class="field-label" for="trial_is_active">Status Trial CTA</label>
                        <select id="trial_is_active" class="field-select" name="is_active" required>
                            <option value="1" @selected((string) old('is_active', (int) $trialSetting->is_active) === '1')>active</option>
                            <option value="0" @selected((string) old('is_active', (int) $trialSetting->is_active) === '0')>inactive</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="field-label" for="trial_cta_subtext">CTA Subtext</label>
                    <input id="trial_cta_subtext" class="field-input" name="cta_subtext" value="{{ old('cta_subtext', $trialSetting->cta_subtext) }}" required>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn-primary">Simpan Trial</button>
                </div>
            </form>
        </div>
    </section>
</div>

<section class="panel mt-6">
    <header class="panel-header">
        <div>
            <h3 class="panel-title">Kontak & CTA WhatsApp</h3>
            <p class="mt-2 text-sm text-slate-500">Data ini dipakai oleh CTA order/tanya di landing page BLASKU.</p>
        </div>
    </header>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.blasku-landing.contact.update') }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="field-label" for="contact_whatsapp_number">WhatsApp Number</label>
                    <input id="contact_whatsapp_number" class="field-input" name="whatsapp_number" value="{{ old('whatsapp_number', $contactSetting->whatsapp_number) }}" required>
                </div>
                <div>
                    <label class="field-label" for="contact_whatsapp_display">WhatsApp Display</label>
                    <input id="contact_whatsapp_display" class="field-input" name="whatsapp_display" value="{{ old('whatsapp_display', $contactSetting->whatsapp_display) }}" required>
                </div>
                <div>
                    <label class="field-label" for="contact_whatsapp_cta_text">CTA Text</label>
                    <input id="contact_whatsapp_cta_text" class="field-input" name="whatsapp_cta_text" value="{{ old('whatsapp_cta_text', $contactSetting->whatsapp_cta_text) }}" required>
                </div>
            </div>
            <div>
                <label class="field-label" for="contact_whatsapp_message_template">WhatsApp Message Template</label>
                <textarea id="contact_whatsapp_message_template" class="field-input min-h-[120px]" name="whatsapp_message_template" required>{{ old('whatsapp_message_template', $contactSetting->whatsapp_message_template) }}</textarea>
            </div>
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div>
                    <label class="field-label" for="contact_email">Email</label>
                    <input id="contact_email" class="field-input" name="email" value="{{ old('email', $contactSetting->email) }}">
                </div>
                <div>
                    <label class="field-label" for="contact_instagram_url">Instagram URL</label>
                    <input id="contact_instagram_url" class="field-input" name="instagram_url" value="{{ old('instagram_url', $contactSetting->instagram_url) }}">
                </div>
                <div>
                    <label class="field-label" for="contact_youtube_url">YouTube URL</label>
                    <input id="contact_youtube_url" class="field-input" name="youtube_url" value="{{ old('youtube_url', $contactSetting->youtube_url) }}">
                </div>
                <div>
                    <label class="field-label" for="contact_tiktok_url">TikTok URL</label>
                    <input id="contact_tiktok_url" class="field-input" name="tiktok_url" value="{{ old('tiktok_url', $contactSetting->tiktok_url) }}">
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="btn-primary">Simpan Kontak</button>
            </div>
        </form>
    </div>
</section>

<dialog id="createPricingPlanDialog" class="dialog-box">
    <form method="POST" action="{{ route('admin.blasku-landing.pricing-plans.store') }}">
        @csrf
        <div class="dialog-head">
            <h3 class="text-lg font-semibold text-slate-800">Tambah Paket Pricing Landing</h3>
            <button type="button" class="btn-secondary" data-dialog-close>Tutup</button>
        </div>
        <div class="dialog-body space-y-4">
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="field-label">Nama Paket</label>
                    <input class="field-input" name="name" required>
                </div>
                <div>
                    <label class="field-label">Slug</label>
                    <input class="field-input" name="slug" placeholder="misal: 3-bulan" required>
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-4">
                <div>
                    <label class="field-label">Harga Coret</label>
                    <input class="field-input" type="number" min="0" name="original_price">
                </div>
                <div>
                    <label class="field-label">Harga Jual</label>
                    <input class="field-input" type="number" min="0" name="price" required>
                </div>
                <div>
                    <label class="field-label">Period</label>
                    <input class="field-input" name="period" placeholder="bulan" required>
                </div>
                <div>
                    <label class="field-label">Period Months</label>
                    <input class="field-input" type="number" min="1" name="period_months" required>
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-4">
                <div class="md:col-span-2">
                    <label class="field-label">Badge</label>
                    <input class="field-input" name="badge" placeholder="opsional">
                </div>
                <div>
                    <label class="field-label">CTA Text</label>
                    <input class="field-input" name="cta_text" value="Tanya & Order" required>
                </div>
                <div>
                    <label class="field-label">Sort Order</label>
                    <input class="field-input" type="number" min="1" name="sort_order" value="{{ max(1, $pricingPlans->count() + 1) }}" required>
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="field-label">Highlight</label>
                    <select class="field-select" name="is_highlighted" required>
                        <option value="0">normal</option>
                        <option value="1">highlighted</option>
                    </select>
                </div>
                <div>
                    <label class="field-label">Status</label>
                    <select class="field-select" name="is_active" required>
                        <option value="1">active</option>
                        <option value="0">inactive</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="field-label">Daftar Fitur</label>
                <textarea class="field-input min-h-[150px]" name="features_text" placeholder="Satu fitur per baris" required>Semua fitur inti
Lead scraping lokal
Database & segmentasi
Campaign adaptive</textarea>
            </div>
        </div>
        <div class="dialog-foot">
            <button type="button" class="btn-secondary" data-dialog-close>Batal</button>
            <button type="submit" class="btn-primary">Simpan Paket</button>
        </div>
    </form>
</dialog>

@foreach($pricingPlans as $plan)
    <dialog id="editPricingPlanDialog{{ $plan->id }}" class="dialog-box">
        <form method="POST" action="{{ route('admin.blasku-landing.pricing-plans.update', $plan) }}">
            @csrf
            @method('PUT')
            <div class="dialog-head">
                <h3 class="text-lg font-semibold text-slate-800">Edit Paket {{ $plan->name }}</h3>
                <button type="button" class="btn-secondary" data-dialog-close>Tutup</button>
            </div>
            <div class="dialog-body space-y-4">
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="field-label">Nama Paket</label>
                        <input class="field-input" name="name" value="{{ $plan->name }}" required>
                    </div>
                    <div>
                        <label class="field-label">Slug</label>
                        <input class="field-input" name="slug" value="{{ $plan->slug }}" required>
                    </div>
                </div>
                <div class="grid gap-4 md:grid-cols-4">
                    <div>
                        <label class="field-label">Harga Coret</label>
                        <input class="field-input" type="number" min="0" name="original_price" value="{{ $plan->original_price }}">
                    </div>
                    <div>
                        <label class="field-label">Harga Jual</label>
                        <input class="field-input" type="number" min="0" name="price" value="{{ $plan->price }}" required>
                    </div>
                    <div>
                        <label class="field-label">Period</label>
                        <input class="field-input" name="period" value="{{ $plan->period }}" required>
                    </div>
                    <div>
                        <label class="field-label">Period Months</label>
                        <input class="field-input" type="number" min="1" name="period_months" value="{{ $plan->period_months }}" required>
                    </div>
                </div>
                <div class="grid gap-4 md:grid-cols-4">
                    <div class="md:col-span-2">
                        <label class="field-label">Badge</label>
                        <input class="field-input" name="badge" value="{{ $plan->badge }}">
                    </div>
                    <div>
                        <label class="field-label">CTA Text</label>
                        <input class="field-input" name="cta_text" value="{{ $plan->cta_text }}" required>
                    </div>
                    <div>
                        <label class="field-label">Sort Order</label>
                        <input class="field-input" type="number" min="1" name="sort_order" value="{{ $plan->sort_order }}" required>
                    </div>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="field-label">Highlight</label>
                        <select class="field-select" name="is_highlighted" required>
                            <option value="0" @selected(!$plan->is_highlighted)>normal</option>
                            <option value="1" @selected($plan->is_highlighted)>highlighted</option>
                        </select>
                    </div>
                    <div>
                        <label class="field-label">Status</label>
                        <select class="field-select" name="is_active" required>
                            <option value="1" @selected($plan->is_active)>active</option>
                            <option value="0" @selected(!$plan->is_active)>inactive</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="field-label">Daftar Fitur</label>
                    <textarea class="field-input min-h-[150px]" name="features_text" required>{{ implode(PHP_EOL, $plan->features ?? []) }}</textarea>
                </div>
            </div>
            <div class="dialog-foot">
                <button type="button" class="btn-secondary" data-dialog-close>Batal</button>
                <button type="submit" class="btn-primary">Update Paket</button>
            </div>
        </form>
    </dialog>
@endforeach
@endsection
