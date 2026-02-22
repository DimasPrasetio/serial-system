@extends('admin.layouts.app')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Management</p>
        <h2 class="mt-1 text-3xl font-bold text-slate-800">Kode Aktivasi</h2>
        <p class="mt-2 text-sm text-slate-500">Buat serial activation berdasarkan pesanan user (durasi lisensi + jumlah device).</p>
    </div>
    <button type="button" data-dialog-open="generateSerialDialog" class="btn-primary">Buat Serial Pesanan</button>
</div>

<section class="panel mb-5">
    <div class="panel-body">
        <form method="GET" class="grid gap-3 sm:grid-cols-[1fr_1fr_auto_auto] sm:items-end">
            <div>
                <label class="field-label" for="application_id">Application</label>
                <select class="field-select" id="application_id" name="application_id">
                    <option value="">Semua Application</option>
                    @foreach($applications as $application)
                        <option value="{{ $application->id }}" @selected($selectedApplicationId === $application->id)>{{ $application->code }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="field-label" for="customer_email">Email User</label>
                <input class="field-input" id="customer_email" name="customer_email" type="email" value="{{ $selectedCustomerEmail ?? '' }}" placeholder="contoh: user@domain.com">
            </div>
            <button class="btn-primary" type="submit">Terapkan</button>
            <a href="{{ route('admin.serials.index') }}" class="btn-secondary">Reset</a>
        </form>
    </div>
</section>

<section class="panel overflow-hidden">
    <header class="panel-header">
        <h3 class="panel-title">Daftar Serial Pesanan</h3>
        <span class="text-sm text-slate-500">{{ $serials->total() }} data</span>
    </header>

    <div class="table-shell">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Email User</th>
                    <th>Aplikasi</th>
                    <th>Paket</th>
                    <th>Jenis</th>
                    <th>Serial Activation</th>
                    <th>Status</th>
                    <th>Catatan Pesanan</th>
                    <th class="w-[180px]">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($serials as $serial)
                <tr>
                    <td>{{ $serial->customer_email ?? '-' }}</td>
                    <td>{{ $serial->application->code }}</td>
                    <td>{{ $serial->plan->code }}</td>
                    <td>
                        <span class="status-inactive">{{ $serial->type === 'renew' ? 'Perpanjangan' : 'Aktivasi Baru' }}</span>
                    </td>
                    <td>
                        <div class="flex flex-wrap items-center gap-2">
                            <span
                                id="serial-value-{{ $serial->id }}"
                                class="code-text"
                                data-serial-state="masked"
                                data-serial-masked="{{ 'BLK-****-****-'.$serial->serial_last4 }}"
                                data-serial-revealed=""
                            >
                                {{ 'BLK-****-****-'.$serial->serial_last4 }}
                            </span>
                            @if($serial->serial_encrypted)
                                <button
                                    type="button"
                                    class="btn-table-neutral js-reveal-serial"
                                    data-serial-target="serial-value-{{ $serial->id }}"
                                    data-serial-url="{{ route('admin.serials.reveal', $serial) }}"
                                >
                                    Lihat Serial
                                </button>
                                <button
                                    type="button"
                                    class="btn-table-brand js-copy-serial hidden"
                                    data-serial-target="serial-value-{{ $serial->id }}"
                                >
                                    Copy
                                </button>
                            @else
                                <span class="text-xs text-slate-500">Serial lama: tidak bisa reveal</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        @php
                            $statusClass = $serial->status === 'available' ? 'status-active' : ($serial->status === 'used' ? 'status-warning' : 'status-danger');
                        @endphp
                        <span class="{{ $statusClass }}">{{ $serial->status }}</span>
                    </td>
                    <td>{{ $serial->order_note ?: '-' }}</td>
                    <td>
                        @if($serial->status !== 'void')
                            <form method="POST" action="{{ route('admin.serials.void', $serial) }}" class="js-confirm" data-confirm-title="Nonaktifkan kode ini?" data-confirm-text="Kode tidak bisa digunakan lagi setelah dinonaktifkan." data-confirm-button="lanjut">
                                @csrf
                                <button type="submit" class="btn-table-danger">Nonaktifkan</button>
                            </form>
                        @else
                            <span class="text-sm text-slate-500">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="table-empty">Belum ada serial.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="border-t border-slate-200 px-6 py-4">{{ $serials->links() }}</div>
</section>

<dialog id="generateSerialDialog" class="dialog-box">
    <form method="POST" action="{{ route('admin.serials.generate') }}">
        @csrf
        <div class="dialog-head">
            <h3 class="text-lg font-semibold text-slate-800">Buat Serial Pesanan User</h3>
            <button type="button" class="btn-secondary" data-dialog-close>Tutup</button>
        </div>
        <div class="dialog-body space-y-4">
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="field-label">Email User</label>
                    <input class="field-input" type="email" name="customer_email" required placeholder="user@domain.com">
                </div>
                <div>
                    <label class="field-label">Quantity Serial</label>
                    <input class="field-input" type="number" name="quantity" value="1" min="1" max="200" required>
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="field-label">Application</label>
                    <select class="field-select" id="generateApplicationSelect" name="application_id" required>
                        @foreach($applications as $application)
                            <option value="{{ $application->id }}">{{ $application->code }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="field-label">Paket</label>
                    <select class="field-select" id="generatePlanSelect" name="plan_id" required>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" data-application-id="{{ $plan->application_id }}">{{ $plan->application->code }} - {{ $plan->code }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-slate-500">Hanya paket paid aktif yang bisa dibuatkan serial.</p>
                </div>
                <div>
                    <label class="field-label">Jenis</label>
                    <select class="field-select" name="type" required>
                        <option value="initial">Aktivasi Baru</option>
                        <option value="renew">Perpanjangan</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="field-label">Catatan Pesanan (opsional)</label>
                <textarea class="field-input" name="order_note" rows="3" placeholder="Contoh: Paket 1 bulan 1 device, invoice INV-2026-001"></textarea>
            </div>
        </div>
        <div class="dialog-foot">
            <button type="button" class="btn-secondary" data-dialog-close>Batal</button>
            <button type="submit" class="btn-primary">Generate Serial</button>
        </div>
    </form>
</dialog>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const appSelect = document.getElementById('generateApplicationSelect');
    const planSelect = document.getElementById('generatePlanSelect');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!appSelect || !planSelect) return;

    function syncPlanOptions() {
        const targetAppId = appSelect.value;
        let hasVisible = false;

        Array.from(planSelect.options).forEach((option) => {
            const optionAppId = option.dataset.applicationId || '';
            const visible = optionAppId === targetAppId;
            option.hidden = !visible;
            option.disabled = !visible;
            if (visible) {
                hasVisible = true;
            }
        });

        if (!hasVisible) {
            planSelect.value = '';
            return;
        }

        const current = planSelect.selectedOptions[0];
        if (!current || current.hidden || current.disabled) {
            const firstVisible = Array.from(planSelect.options).find((option) => !option.hidden && !option.disabled);
            if (firstVisible) {
                planSelect.value = firstVisible.value;
            }
        }
    }

    appSelect.addEventListener('change', syncPlanOptions);
    syncPlanOptions();

    document.querySelectorAll('.js-reveal-serial').forEach((button) => {
        button.addEventListener('click', async () => {
            const targetId = button.dataset.serialTarget;
            const serialElement = targetId ? document.getElementById(targetId) : null;
            if (!serialElement) {
                return;
            }

            const wrapper = button.parentElement;
            const copyButton = wrapper ? wrapper.querySelector('.js-copy-serial') : null;
            const currentState = serialElement.dataset.serialState || 'masked';
            if (currentState === 'revealed') {
                serialElement.textContent = serialElement.dataset.serialMasked || '';
                serialElement.dataset.serialState = 'masked';
                button.textContent = 'Lihat Serial';
                if (copyButton) {
                    copyButton.classList.add('hidden');
                }
                return;
            }

            if (serialElement.dataset.serialRevealed) {
                serialElement.textContent = serialElement.dataset.serialRevealed;
                serialElement.dataset.serialState = 'revealed';
                button.textContent = 'Sembunyikan';
                if (copyButton) {
                    copyButton.classList.remove('hidden');
                }
                return;
            }

            const url = button.dataset.serialUrl;
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

                if (!response.ok || !payload.serial) {
                    throw new Error(payload.message || 'Gagal menampilkan serial activation.');
                }

                serialElement.dataset.serialRevealed = payload.serial;
                serialElement.textContent = payload.serial;
                serialElement.dataset.serialState = 'revealed';
                button.textContent = 'Sembunyikan';
                if (copyButton) {
                    copyButton.classList.remove('hidden');
                }
            } catch (error) {
                const errorMessage = error && typeof error.message === 'string'
                    ? error.message
                    : 'Gagal menampilkan serial activation.';
                window.alert(errorMessage);
                button.textContent = 'Lihat Serial';
            } finally {
                button.disabled = false;
            }
        });
    });

    document.querySelectorAll('.js-copy-serial').forEach((button) => {
        button.addEventListener('click', async () => {
            const targetId = button.dataset.serialTarget;
            const serialElement = targetId ? document.getElementById(targetId) : null;
            if (!serialElement) {
                return;
            }

            const serialValue = serialElement.dataset.serialRevealed || '';
            if (!serialValue) {
                window.alert('Tampilkan serial terlebih dahulu sebelum copy.');
                return;
            }

            try {
                await navigator.clipboard.writeText(serialValue);
                window.alert('Serial activation berhasil di-copy.');
            } catch (_) {
                window.alert('Gagal copy otomatis. Silakan copy manual.');
            }
        });
    });
});
</script>
@endpush
