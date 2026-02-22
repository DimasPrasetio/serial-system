@extends('admin.layouts.app')

@section('content')
<div class="mb-6">
    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Management</p>
    <h2 class="mt-1 text-3xl font-bold text-slate-800">Licenses</h2>
</div>

<section class="panel mb-5">
    <div class="panel-body">
        <form method="GET" class="grid gap-3 md:grid-cols-[2fr_1fr_auto_auto] md:items-end">
            <div>
                <label class="field-label" for="q">Keyword</label>
                <input id="q" class="field-input" name="q" placeholder="Cari license ID / email" value="{{ $q }}">
            </div>
            <div>
                <label class="field-label" for="status">Status</label>
                <select id="status" class="field-select" name="status">
                    <option value="">Semua status</option>
                    <option value="active" @selected($status === 'active')>active</option>
                    <option value="expired" @selected($status === 'expired')>expired</option>
                    <option value="revoked" @selected($status === 'revoked')>revoked</option>
                </select>
            </div>
            <button class="btn-primary" type="submit">Terapkan</button>
            <a href="{{ route('admin.licenses.index') }}" class="btn-secondary">Reset</a>
        </form>
    </div>
</section>

<section class="panel overflow-hidden">
    <header class="panel-header">
        <h3 class="panel-title">Daftar License</h3>
        <span class="text-sm text-slate-500">{{ $licenses->total() }} data</span>
    </header>

    <div class="table-shell">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Aplikasi</th>
                    <th>Email</th>
                    <th>Paket</th>
                    <th>Status</th>
                    <th>Berlaku Sampai</th>
                    <th class="w-[260px]">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($licenses as $license)
                <tr>
                    <td><span class="code-text">{{ $license->id }}</span></td>
                    <td>{{ $license->application->code }}</td>
                    <td>{{ $license->account->email }}</td>
                    <td>{{ $license->plan->code }}</td>
                    <td>
                        @php
                            $statusClass = $license->status === 'active' ? 'status-active' : ($license->status === 'expired' ? 'status-warning' : 'status-danger');
                        @endphp
                        <span class="{{ $statusClass }}">{{ $license->status }}</span>
                    </td>
                    <td>{{ $license->expires_at_utc }}</td>
                    <td>
                        <div class="table-action-group">
                            <a class="btn-table-brand" href="{{ route('admin.licenses.show', $license) }}">Detail</a>
                            <form method="POST" action="{{ route('admin.licenses.toggle-revoke', $license) }}" class="js-confirm" data-confirm-title="{{ $license->status === 'revoked' ? 'Buka revoke license?' : 'Revoke license?' }}" data-confirm-text="Status license akan diubah." data-confirm-button="lanjut">
                                @csrf
                                <button type="submit" class="{{ $license->status === 'revoked' ? 'btn-table-success' : 'btn-table-warning' }}">
                                    {{ $license->status === 'revoked' ? 'Aktifkan Lagi' : 'Nonaktifkan' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="table-empty">Belum ada data license.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="border-t border-slate-200 px-6 py-4">{{ $licenses->links() }}</div>
</section>
@endsection
