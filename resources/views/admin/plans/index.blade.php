@extends('admin.layouts.app')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Management</p>
        <h2 class="mt-1 text-3xl font-bold text-slate-800">Paket Lisensi</h2>
    </div>
    <button type="button" data-dialog-open="createPlanDialog" class="btn-primary">Tambah Paket</button>
</div>

<section class="panel mb-5">
    <div class="panel-body">
        <form method="GET" class="grid gap-3 sm:grid-cols-[1fr_auto_auto] sm:items-end">
            <div>
                <label class="field-label" for="application_id">Application</label>
                <select class="field-select" id="application_id" name="application_id">
                    <option value="">Semua Application</option>
                    @foreach($applications as $application)
                        <option value="{{ $application->id }}" @selected($selectedApplicationId === $application->id)>{{ $application->code }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn-primary" type="submit">Terapkan</button>
            <a href="{{ route('admin.plans.index') }}" class="btn-secondary">Reset</a>
        </form>
    </div>
</section>

<section class="panel overflow-hidden">
    <header class="panel-header">
        <h3 class="panel-title">Daftar Paket</h3>
        <span class="text-sm text-slate-500">{{ $plans->total() }} data</span>
    </header>

    <div class="table-shell">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Aplikasi</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Durasi</th>
                    <th>Batas Perangkat</th>
                    <th>Uji Coba</th>
                    <th>Status</th>
                    <th class="w-[140px]">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($plans as $plan)
                <tr>
                    <td>{{ $plan->application->code }}</td>
                    <td><span class="code-text">{{ $plan->code }}</span></td>
                    <td>{{ $plan->name }}</td>
                    <td>{{ $plan->term_days }} hari</td>
                    <td>{{ $plan->seat_limit }}</td>
                    <td>
                        <span class="{{ $plan->is_trial ? 'status-warning' : 'status-inactive' }}">{{ $plan->is_trial ? 'yes' : 'no' }}</span>
                    </td>
                    <td>
                        <span class="{{ $plan->is_active ? 'status-active' : 'status-inactive' }}">{{ $plan->is_active ? 'active' : 'inactive' }}</span>
                    </td>
                    <td>
                        <button type="button" data-dialog-open="editPlanDialog{{ $plan->id }}" class="btn-table-brand">Edit</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="table-empty">Belum ada data plan.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="border-t border-slate-200 px-6 py-4">{{ $plans->links() }}</div>
</section>

<dialog id="createPlanDialog" class="dialog-box">
    <form method="POST" action="{{ route('admin.plans.store') }}">
        @csrf
        <div class="dialog-head">
            <h3 class="text-lg font-semibold text-slate-800">Tambah Paket</h3>
            <button type="button" class="btn-secondary" data-dialog-close>Tutup</button>
        </div>
        <div class="dialog-body space-y-4">
                <div>
                    <label class="field-label">Application</label>
                    <select class="field-select" name="application_id" required>
                    @foreach($applications as $application)
                        <option value="{{ $application->id }}">{{ $application->code }}</option>
                    @endforeach
                </select>
            </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="field-label">Kode</label>
                        <input class="field-input" name="code" required>
                    </div>
                    <div>
                        <label class="field-label">Nama</label>
                        <input class="field-input" name="name" required>
                    </div>
                </div>
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="field-label">Term Days</label>
                    <input class="field-input" type="number" name="term_days" min="1" required>
                </div>
                <div>
                    <label class="field-label">Seat Limit</label>
                    <input class="field-input" type="number" name="seat_limit" min="1" required>
                </div>
                <div>
                    <label class="field-label">Paket Uji Coba</label>
                    <select class="field-select" name="is_trial">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="dialog-foot">
            <button type="button" class="btn-secondary" data-dialog-close>Batal</button>
            <button type="submit" class="btn-primary">Simpan</button>
        </div>
    </form>
</dialog>

@foreach($plans as $plan)
    <dialog id="editPlanDialog{{ $plan->id }}" class="dialog-box">
        <form method="POST" action="{{ route('admin.plans.update', $plan) }}">
            @csrf
            @method('PUT')
            <div class="dialog-head">
                <h3 class="text-lg font-semibold text-slate-800">Edit Paket</h3>
                <button type="button" class="btn-secondary" data-dialog-close>Tutup</button>
            </div>
            <div class="dialog-body space-y-4">
                <div class="grid gap-4 md:grid-cols-3">
                    <div class="md:col-span-2">
                        <label class="field-label">Nama</label>
                        <input class="field-input" name="name" value="{{ $plan->name }}" required>
                    </div>
                    <div>
                        <label class="field-label">Term Days</label>
                        <input class="field-input" type="number" min="1" name="term_days" value="{{ $plan->term_days }}" required>
                    </div>
                </div>
                <div class="grid gap-4 md:grid-cols-3">
                    <div>
                        <label class="field-label">Seat Limit</label>
                        <input class="field-input" type="number" min="1" name="seat_limit" value="{{ $plan->seat_limit }}" required>
                    </div>
                    <div>
                        <label class="field-label">Paket Uji Coba</label>
                        <select class="field-select" name="is_trial" required>
                            <option value="1" @selected($plan->is_trial)>Yes</option>
                            <option value="0" @selected(!$plan->is_trial)>No</option>
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
            </div>
            <div class="dialog-foot">
                <button type="button" class="btn-secondary" data-dialog-close>Batal</button>
                <button type="submit" class="btn-primary">Update</button>
            </div>
        </form>
    </dialog>
@endforeach
@endsection
