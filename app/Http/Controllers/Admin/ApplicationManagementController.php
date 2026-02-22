<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Services\AuditLogService;
use App\Support\SecretHasher;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ApplicationManagementController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLog)
    {
    }

    public function index(): View
    {
        return view('admin.applications.index', [
            'applications' => Application::query()->latest()->paginate(15),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:100', 'unique:applications,code'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        Application::query()->create([
            'code' => strtoupper($data['code']),
            'name' => $data['name'],
            'is_active' => true,
        ]);

        return back()->with('status', 'Aplikasi berhasil dibuat.');
    }

    public function update(Request $request, Application $application): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'is_active' => ['required', 'boolean'],
        ]);

        $application->update($data);

        return back()->with('status', 'Aplikasi berhasil diperbarui.');
    }

    public function rotateToken(Application $application): RedirectResponse
    {
        $plainToken = 'app_'.Str::random(40);
        $application->update([
            'token_hash' => SecretHasher::hash($plainToken),
            'token_encrypted' => Crypt::encryptString($plainToken),
        ]);

        $this->auditLog->log(
            auth('admin')->user(),
            'application.token.rotate',
            'application',
            (string) $application->id,
            ['application_code' => $application->code]
        );

        return back()->with('status', "Kunci akses baru: {$plainToken}. Key juga tersedia di kolom KEY (masked).");
    }

    public function revealToken(Application $application): JsonResponse
    {
        if (! $application->token_encrypted) {
            return response()->json([
                'message' => 'Kunci akses belum tersedia. Perbarui kunci terlebih dahulu.',
            ], 404);
        }

        try {
            $plainToken = Crypt::decryptString($application->token_encrypted);
        } catch (DecryptException) {
            return response()->json([
                'message' => 'Kunci akses tidak valid. Silakan perbarui kunci aplikasi.',
            ], 422);
        }

        $this->auditLog->log(
            auth('admin')->user(),
            'application.token.reveal',
            'application',
            (string) $application->id,
            ['application_code' => $application->code]
        );

        return response()
            ->json(['token' => $plainToken])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }
}
