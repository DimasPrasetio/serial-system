@extends('admin.layouts.app')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Management</p>
        <h2 class="mt-1 text-3xl font-bold text-slate-800">Aplikasi</h2>
    </div>
    <button type="button" data-dialog-open="createAppDialog" class="btn-primary">Tambah Aplikasi</button>
</div>

<section class="panel overflow-hidden">
    <header class="panel-header">
        <h3 class="panel-title">Daftar Aplikasi</h3>
        <span class="text-sm text-slate-500">{{ $applications->total() }} data</span>
    </header>

    <div class="table-shell">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>KEY</th>
                    <th>Status</th>
                    <th class="w-[320px]">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $application)
                    <tr>
                        <td><span class="code-text">{{ $application->code }}</span></td>
                        <td>{{ $application->name }}</td>
                        <td>
                            @if($application->token_encrypted)
                                <div class="flex flex-wrap items-center gap-2">
                                    <span
                                        id="token-value-{{ $application->id }}"
                                        class="code-text"
                                        data-token-state="masked"
                                        data-token-masked="{{ 'app_'.str_repeat('*', 40) }}"
                                        data-token-revealed=""
                                    >
                                        {{ 'app_'.str_repeat('*', 40) }}
                                    </span>
                                    <button
                                        type="button"
                                        class="btn-table-neutral js-reveal-token"
                                        data-token-target="token-value-{{ $application->id }}"
                                        data-token-url="{{ route('admin.applications.reveal-token', $application) }}"
                                    >
                                        Lihat Key
                                    </button>
                                </div>
                            @else
                                <span class="text-sm text-slate-500">Belum ada kunci</span>
                            @endif
                        </td>
                        <td>
                            <span class="{{ $application->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $application->is_active ? 'active' : 'inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="table-action-group">
                                <button type="button" data-dialog-open="editAppDialog{{ $application->id }}" class="btn-table-brand">Edit</button>

                                <form method="POST" action="{{ route('admin.applications.rotate-token', $application) }}" class="js-confirm" data-confirm-title="Perbarui kunci akses aplikasi?" data-confirm-text="Kunci akses lama tidak akan bisa dipakai lagi." data-confirm-button="lanjut">
                                    @csrf
                                    <button type="submit" class="btn-table-neutral">Perbarui Kunci</button>
                                </form>

                                <form method="POST" action="{{ route('admin.applications.update', $application) }}" class="js-confirm" data-confirm-title="Ubah status application?" data-confirm-button="ubah">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="name" value="{{ $application->name }}">
                                    <input type="hidden" name="is_active" value="{{ $application->is_active ? 0 : 1 }}">
                                    <button type="submit" class="{{ $application->is_active ? 'btn-table-warning' : 'btn-table-success' }}">
                                        {{ $application->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="table-empty">Belum ada application.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="border-t border-slate-200 px-6 py-4">
        {{ $applications->links() }}
    </div>
</section>

<dialog id="createAppDialog" class="dialog-box">
    <form method="POST" action="{{ route('admin.applications.store') }}">
        @csrf
        <div class="dialog-head">
            <h3 class="text-lg font-semibold text-slate-800">Tambah Aplikasi</h3>
            <button type="button" class="btn-secondary" data-dialog-close>Tutup</button>
        </div>
        <div class="dialog-body space-y-4">
            <div>
                <label class="field-label">Kode Aplikasi</label>
                <input class="field-input" name="code" placeholder="APP_CODE" required>
            </div>
            <div>
                <label class="field-label">Nama Aplikasi</label>
                <input class="field-input" name="name" required>
            </div>
        </div>
        <div class="dialog-foot">
            <button type="button" class="btn-secondary" data-dialog-close>Batal</button>
            <button type="submit" class="btn-primary">Simpan</button>
        </div>
    </form>
</dialog>

@foreach($applications as $application)
    <dialog id="editAppDialog{{ $application->id }}" class="dialog-box">
        <form method="POST" action="{{ route('admin.applications.update', $application) }}">
            @csrf
            @method('PUT')
            <div class="dialog-head">
                <h3 class="text-lg font-semibold text-slate-800">Edit Aplikasi</h3>
                <button type="button" class="btn-secondary" data-dialog-close>Tutup</button>
            </div>
            <div class="dialog-body space-y-4">
                <div>
                    <label class="field-label">Nama Aplikasi</label>
                    <input class="field-input" name="name" value="{{ $application->name }}" required>
                </div>
                <div>
                    <label class="field-label">Status</label>
                    <select class="field-select" name="is_active" required>
                        <option value="1" @selected($application->is_active)>active</option>
                        <option value="0" @selected(!$application->is_active)>inactive</option>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    document.querySelectorAll('.js-reveal-token').forEach((button) => {
        button.addEventListener('click', async () => {
            const targetId = button.dataset.tokenTarget;
            const tokenElement = targetId ? document.getElementById(targetId) : null;

            if (!tokenElement) {
                return;
            }

            const currentState = tokenElement.dataset.tokenState || 'masked';
            if (currentState === 'revealed') {
                tokenElement.textContent = tokenElement.dataset.tokenMasked || '';
                tokenElement.dataset.tokenState = 'masked';
                button.textContent = 'Lihat Key';
                return;
            }

            if (tokenElement.dataset.tokenRevealed) {
                tokenElement.textContent = tokenElement.dataset.tokenRevealed;
                tokenElement.dataset.tokenState = 'revealed';
                button.textContent = 'Sembunyikan';
                return;
            }

            const url = button.dataset.tokenUrl;
            if (!url || !csrfToken) {
                return;
            }

            button.disabled = true;
            button.textContent = 'Memuat...';

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });

                let payload = {};
                try {
                    payload = await response.json();
                } catch (_) {
                    payload = {};
                }

                if (!response.ok || !payload.token) {
                    throw new Error(payload.message || 'Gagal menampilkan key aplikasi.');
                }

                tokenElement.dataset.tokenRevealed = payload.token;
                tokenElement.textContent = payload.token;
                tokenElement.dataset.tokenState = 'revealed';
                button.textContent = 'Sembunyikan';
            } catch (error) {
                const errorMessage = error && typeof error.message === 'string'
                    ? error.message
                    : 'Gagal menampilkan key aplikasi.';
                window.alert(errorMessage);
                button.textContent = 'Lihat Key';
            } finally {
                button.disabled = false;
            }
        });
    });
});
</script>
@endpush
@endsection
