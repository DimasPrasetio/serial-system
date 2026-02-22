@extends('admin.layouts.app')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Management</p>
        <h2 class="mt-1 text-3xl font-bold text-slate-800">License Detail</h2>
    </div>
    <a href="{{ route('admin.licenses.index') }}" class="btn-secondary">Back</a>
</div>

<section class="panel mb-5">
    <header class="panel-header">
        <h3 class="panel-title">Summary</h3>
    </header>
    <div class="panel-body grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div>
            <p class="field-label">ID</p>
            <p class="text-sm font-medium text-slate-700 break-all">{{ $license->id }}</p>
        </div>
        <div>
            <p class="field-label">Application</p>
            <p class="text-sm font-medium text-slate-700">{{ $license->application->code }}</p>
        </div>
        <div>
            <p class="field-label">Account</p>
            <p class="text-sm font-medium text-slate-700">{{ $license->account->email }}</p>
        </div>
        <div>
            <p class="field-label">Paket</p>
            <p class="text-sm font-medium text-slate-700">{{ $license->plan->code }}</p>
        </div>
        <div>
            <p class="field-label">Status</p>
            @php
                $statusClass = $license->status === 'active' ? 'status-active' : ($license->status === 'expired' ? 'status-warning' : 'status-danger');
            @endphp
            <span class="{{ $statusClass }}">{{ $license->status }}</span>
        </div>
        <div>
            <p class="field-label">Mulai</p>
            <p class="text-sm font-medium text-slate-700">{{ $license->starts_at_utc }}</p>
        </div>
        <div>
            <p class="field-label">Berlaku Sampai</p>
            <p class="text-sm font-medium text-slate-700">{{ $license->expires_at_utc }}</p>
        </div>
    </div>
</section>

<div class="grid gap-5">
    <section class="panel overflow-hidden">
        <header class="panel-header">
            <h3 class="panel-title">Perangkat Tertaut</h3>
        </header>
        <div class="table-shell">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Fingerprint</th>
                        <th>Label</th>
                        <th>Status</th>
                        <th class="w-[130px]"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($license->deviceBindings as $device)
                        <tr>
                            <td class="break-all">{{ $device->fingerprint_hash }}</td>
                            <td>{{ $device->label }}</td>
                            <td><span class="{{ $device->status === 'active' ? 'status-active' : 'status-inactive' }}">{{ $device->status }}</span></td>
                            <td>
                                @if($device->status === 'active')
                                    <form method="POST" action="{{ route('admin.devices.deactivate', $device) }}" class="js-confirm" data-confirm-title="Deactivate device?" data-confirm-text="Seat aktif akan berkurang." data-confirm-button="deactivate">
                                        @csrf
                                        <button type="submit" class="btn-table-danger">Deactivate</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="table-empty">Tidak ada device binding.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
