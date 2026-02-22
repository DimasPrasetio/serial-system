<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Plan;
use App\Models\SerialNumber;
use App\Services\AuditLogService;
use App\Support\SecretHasher;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SerialManagementController extends Controller
{
    public function __construct(private readonly AuditLogService $auditLog)
    {
    }

    public function index(Request $request): View
    {
        $applicationId = $request->integer('application_id');
        $customerEmail = strtolower(trim((string) $request->input('customer_email', '')));

        $query = SerialNumber::query()->with(['application', 'plan'])->latest();
        if ($applicationId > 0) {
            $query->where('application_id', $applicationId);
        }
        if ($customerEmail !== '') {
            $query->where('customer_email', 'like', '%'.$customerEmail.'%');
        }

        return view('admin.serials.index', [
            'serials' => $query->paginate(20)->withQueryString(),
            'applications' => Application::query()->orderBy('code')->get(),
            'plans' => Plan::query()
                ->with('application')
                ->where('is_active', true)
                ->where('is_trial', false)
                ->orderBy('application_id')
                ->orderBy('code')
                ->get(),
            'selectedApplicationId' => $applicationId,
            'selectedCustomerEmail' => $customerEmail,
        ]);
    }

    public function generate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'application_id' => ['required', 'exists:applications,id'],
            'plan_id' => [
                'required',
                Rule::exists('plans', 'id')->where(function ($query) use ($request) {
                    $query
                        ->where('application_id', (int) $request->input('application_id'))
                        ->where('is_active', true)
                        ->where('is_trial', false);
                }),
            ],
            'type' => ['required', 'in:initial,renew'],
            'quantity' => ['required', 'integer', 'min:1', 'max:200'],
            'customer_email' => ['required', 'email', 'max:255'],
            'order_note' => ['nullable', 'string', 'max:500'],
        ]);

        $plan = Plan::query()
            ->where('id', $data['plan_id'])
            ->where('application_id', $data['application_id'])
            ->where('is_active', true)
            ->where('is_trial', false)
            ->first();

        if (! $plan) {
            throw ValidationException::withMessages([
                'plan_id' => 'Paket pesanan tidak valid untuk application ini.',
            ]);
        }

        $customerEmail = strtolower(trim((string) $data['customer_email']));
        $orderNote = trim((string) ($data['order_note'] ?? ''));

        $generated = [];
        for ($i = 0; $i < $data['quantity']; $i++) {
            $plain = 'BLK-'.strtoupper(Str::random(4)).'-'.strtoupper(Str::random(4)).'-'.strtoupper(Str::random(4));
            SerialNumber::query()->create([
                'application_id' => $data['application_id'],
                'plan_id' => $data['plan_id'],
                'serial_hash' => SecretHasher::hash($plain),
                'serial_last4' => substr($plain, -4),
                'serial_encrypted' => Crypt::encryptString($plain),
                'customer_email' => $customerEmail,
                'order_note' => $orderNote !== '' ? $orderNote : null,
                'type' => $data['type'],
                'status' => SerialNumber::STATUS_AVAILABLE,
            ]);
            $generated[] = $plain;
        }

        $this->auditLog->log(
            auth('admin')->user(),
            'serial.generate',
            'serial_numbers',
            (string) $data['application_id'],
            [
                'type' => $data['type'],
                'quantity' => $data['quantity'],
                'customer_email' => $customerEmail,
                'plan_code' => $plan->code,
                'term_days' => $plan->term_days,
                'seat_limit' => $plan->seat_limit,
            ]
        );

        return back()->with('status', 'Serial pesanan untuk '.$customerEmail.' berhasil dibuat: '.implode(', ', $generated));
    }

    public function reveal(SerialNumber $serial): JsonResponse
    {
        if (! $serial->serial_encrypted) {
            return response()->json([
                'message' => 'Serial ini tidak memiliki data reveal (kemungkinan serial lama).',
            ], 404);
        }

        try {
            $plainSerial = Crypt::decryptString($serial->serial_encrypted);
        } catch (DecryptException) {
            return response()->json([
                'message' => 'Serial tidak valid. Silakan generate serial baru.',
            ], 422);
        }

        $this->auditLog->log(
            auth('admin')->user(),
            'serial.reveal',
            'serial_number',
            (string) $serial->id,
            ['serial_last4' => $serial->serial_last4]
        );

        return response()
            ->json(['serial' => $plainSerial])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    public function void(SerialNumber $serial): RedirectResponse
    {
        $serial->update(['status' => SerialNumber::STATUS_VOID]);

        $this->auditLog->log(
            auth('admin')->user(),
            'serial.void',
            'serial_number',
            (string) $serial->id,
            ['serial_last4' => $serial->serial_last4]
        );

        return back()->with('status', 'Serial berhasil di-void.');
    }
}
