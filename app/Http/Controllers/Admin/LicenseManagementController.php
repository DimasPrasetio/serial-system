<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Services\AuditLogService;
use App\Support\LicenseStatus;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LicenseManagementController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLog)
    {
    }

    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $status = trim((string) $request->query('status', ''));

        $query = License::query()->with(['application', 'account', 'plan'])->latest();
        if ($q !== '') {
            $query->where(function ($inner) use ($q) {
                $inner->where('id', 'like', "%{$q}%")
                    ->orWhereHas('account', fn ($sq) => $sq->where('email', 'like', "%{$q}%"));
            });
        }
        if (in_array($status, [LicenseStatus::ACTIVE, LicenseStatus::EXPIRED, LicenseStatus::REVOKED], true)) {
            $query->where('status', $status);
        }

        return view('admin.licenses.index', [
            'licenses' => $query->paginate(20)->withQueryString(),
            'q' => $q,
            'status' => $status,
        ]);
    }

    public function show(License $license): View
    {
        $license->load(['application', 'account', 'plan', 'deviceBindings', 'tokens']);
        return view('admin.licenses.show', ['license' => $license]);
    }

    public function toggleRevoke(License $license): RedirectResponse
    {
        if ($license->status === LicenseStatus::REVOKED) {
            $license->update([
                'status' => $license->expires_at_utc->isPast() ? LicenseStatus::EXPIRED : LicenseStatus::ACTIVE,
                'revoked_at_utc' => null,
            ]);
            $action = 'license.unrevoke';
        } else {
            $license->update([
                'status' => LicenseStatus::REVOKED,
                'revoked_at_utc' => CarbonImmutable::now('UTC'),
            ]);
            $action = 'license.revoke';
        }

        $this->auditLog->log(
            auth('admin')->user(),
            $action,
            'license',
            (string) $license->id,
            ['status' => $license->status]
        );

        return back()->with('status', 'Status license berhasil diperbarui.');
    }
}
