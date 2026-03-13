@extends('admin.layouts.app')

@section('content')
<div class="mb-6 flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Landing BLASKU</p>
        <h2 class="mt-1 text-3xl font-bold text-slate-800">Pricing</h2>
        <p class="mt-3 max-w-3xl text-sm leading-relaxed text-slate-500">
            Kelola paket harga yang akan tampil pada section pricing landing page BLASKU.
        </p>
    </div>

    <div class="flex items-center gap-3">
        <span class="status-active">{{ $pricingPlans->where('is_active', true)->count() }} aktif</span>
        <button type="button" data-dialog-open="createPricingPlanDialog" class="btn-primary">Tambah Paket Landing</button>
    </div>
</div>

@include('admin.blasku-landing.partials.subnav')

<section class="panel overflow-hidden">
    <header class="panel-header">
        <div>
            <h3 class="panel-title">Daftar Paket</h3>
            <p class="mt-2 text-sm text-slate-500">Urutkan paket sesuai tampilan landing dan gunakan highlight untuk paket utama.</p>
        </div>
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
                        <div class="mt-1 text-xs text-slate-400">{{ $plan->slug }} / {{ $plan->period }}</div>
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
