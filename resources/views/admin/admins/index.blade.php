@extends('admin.layouts.app')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Management</p>
        <h2 class="mt-1 text-3xl font-bold text-slate-800">Admin Accounts</h2>
    </div>
    <button type="button" data-dialog-open="createAdminDialog" class="btn-primary">Tambah Admin</button>
</div>

<section class="panel overflow-hidden">
    <header class="panel-header">
        <h3 class="panel-title">Daftar Admin</h3>
        <span class="text-sm text-slate-500">{{ $admins->total() }} data</span>
    </header>

    <div class="table-shell">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="w-[260px]">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                    <tr>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->getRoleNames()->implode(', ') ?: '-' }}</td>
                        <td>
                            <span class="{{ $admin->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $admin->is_active ? 'active' : 'inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="table-action-group">
                                <button type="button" data-dialog-open="editAdminDialog{{ $admin->id }}" class="btn-table-brand">Edit</button>
                                <form method="POST" action="{{ route('admin.admins.update', $admin) }}" class="js-confirm" data-confirm-title="Ubah status admin?" data-confirm-text="Status akun admin akan diubah." data-confirm-button="ubah">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="name" value="{{ $admin->name }}">
                                    <input type="hidden" name="email" value="{{ $admin->email }}">
                                    <input type="hidden" name="role" value="{{ $admin->getRoleNames()->first() ?? 'ops_admin' }}">
                                    <input type="hidden" name="is_active" value="{{ $admin->is_active ? 0 : 1 }}">
                                    <button type="submit" class="{{ $admin->is_active ? 'btn-table-warning' : 'btn-table-success' }}">
                                        {{ $admin->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="table-empty">Belum ada data admin.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="border-t border-slate-200 px-6 py-4">
        {{ $admins->links() }}
    </div>
</section>

<dialog id="createAdminDialog" class="dialog-box">
    <form method="POST" action="{{ route('admin.admins.store') }}">
        @csrf
        <div class="dialog-head">
            <h3 class="text-lg font-semibold text-slate-800">Tambah Admin</h3>
            <button type="button" class="btn-secondary" data-dialog-close>Tutup</button>
        </div>
        <div class="dialog-body space-y-4">
            <div>
                <label class="field-label">Nama</label>
                <input class="field-input" name="name" required>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="field-label">Email</label>
                    <input class="field-input" type="email" name="email" required>
                </div>
                <div>
                    <label class="field-label">Role</label>
                    <select class="field-select" name="role" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="field-label">Password</label>
                <input class="field-input" type="password" name="password" minlength="8" required>
            </div>
        </div>
        <div class="dialog-foot">
            <button type="button" class="btn-secondary" data-dialog-close>Batal</button>
            <button type="submit" class="btn-primary">Simpan</button>
        </div>
    </form>
</dialog>

@foreach($admins as $admin)
    <dialog id="editAdminDialog{{ $admin->id }}" class="dialog-box">
        <form method="POST" action="{{ route('admin.admins.update', $admin) }}">
            @csrf
            @method('PUT')
            <div class="dialog-head">
                <h3 class="text-lg font-semibold text-slate-800">Edit Admin</h3>
                <button type="button" class="btn-secondary" data-dialog-close>Tutup</button>
            </div>
            <div class="dialog-body space-y-4">
                <div>
                    <label class="field-label">Nama</label>
                    <input class="field-input" name="name" value="{{ $admin->name }}" required>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="field-label">Email</label>
                        <input class="field-input" type="email" name="email" value="{{ $admin->email }}" required>
                    </div>
                    <div>
                        <label class="field-label">Role</label>
                        <select class="field-select" name="role" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" @selected(($admin->getRoleNames()->first() ?? '') === $role->name)>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="field-label">Password Baru (opsional)</label>
                    <input class="field-input" type="password" name="password" minlength="8">
                </div>
                <div>
                    <label class="field-label">Status</label>
                    <select class="field-select" name="is_active" required>
                        <option value="1" @selected($admin->is_active)>active</option>
                        <option value="0" @selected(!$admin->is_active)>inactive</option>
                    </select>
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
