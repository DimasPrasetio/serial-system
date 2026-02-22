<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Application;
use App\Models\DeviceBinding;
use App\Models\License;
use App\Models\SerialNumber;
use App\Support\ApiException;
use App\Support\LicenseStatus;
use App\Support\SecretHasher;
use Carbon\CarbonImmutable;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class LicenseActivationService
{
    public function __construct(
        private readonly LicenseTokenService $tokenService,
        private readonly LicensePresenter $presenter
    ) {
    }

    public function activate(Application $application, array $payload): array
    {
        $email = strtolower(trim((string) $payload['email']));
        $now = CarbonImmutable::now('UTC');

        [$license, $apiToken] = DB::transaction(function () use ($application, $payload, $now, $email) {
            $serial = SerialNumber::query()
                ->with('plan')
                ->where('serial_hash', SecretHasher::hash($payload['serial']))
                ->where('application_id', $application->id)
                ->where('type', SerialNumber::TYPE_INITIAL)
                ->lockForUpdate()
                ->first();

            if (! $serial || $serial->status === SerialNumber::STATUS_VOID) {
                throw new ApiException('SERIAL_INVALID', 'Serial is invalid.', 400);
            }
            if (! $serial->plan || $serial->plan->is_trial || ! $serial->plan->is_active) {
                throw new ApiException('SERIAL_INVALID', 'Serial is invalid.', 400);
            }

            $existingLicense = License::query()
                ->with(['plan', 'account'])
                ->where('issued_serial_number_id', $serial->id)
                ->lockForUpdate()
                ->first();

            if ($serial->status === SerialNumber::STATUS_AVAILABLE && $existingLicense) {
                $serial->update([
                    'status' => SerialNumber::STATUS_USED,
                    'used_at_utc' => $serial->used_at_utc ?? $now,
                ]);
            }

            if ($serial->status === SerialNumber::STATUS_AVAILABLE) {
                $account = $this->firstOrCreateAccount($application, $email);

                $plan = $serial->plan;
                $license = License::query()->create([
                    'application_id' => $application->id,
                    'issued_serial_number_id' => $serial->id,
                    'account_id' => $account->id,
                    'plan_id' => $plan->id,
                    'status' => LicenseStatus::ACTIVE,
                    'starts_at_utc' => $now,
                    'expires_at_utc' => $now->addDays($plan->term_days),
                ]);

                $serial->update([
                    'status' => SerialNumber::STATUS_USED,
                    'used_at_utc' => $now,
                ]);
            } else {
                $license = $existingLicense;
                if (! $license) {
                    throw new ApiException('SERIAL_ALREADY_USED', 'Serial has already been used.', 409);
                }

                if (strtolower((string) $license->account?->email) !== $email) {
                    throw new ApiException('SERIAL_EMAIL_MISMATCH', 'Serial belongs to a different email account.', 403);
                }

                $plan = $license->plan;
            }

            $activeSeat = $license->deviceBindings()
                ->where('status', DeviceBinding::STATUS_ACTIVE)
                ->count();

            $hasDevice = $license->deviceBindings()
                ->where('fingerprint_hash', $payload['device']['fingerprint_hash'])
                ->where('status', DeviceBinding::STATUS_ACTIVE)
                ->exists();

            if (! $hasDevice && $activeSeat >= $plan->seat_limit) {
                throw new ApiException('SEAT_LIMIT_REACHED', 'Seat limit reached.', 409);
            }

            if (! $hasDevice) {
                DeviceBinding::query()->updateOrCreate(
                    [
                        'license_id' => $license->id,
                        'fingerprint_hash' => $payload['device']['fingerprint_hash'],
                    ],
                    [
                        'label' => $payload['device']['label'],
                        'platform' => $payload['device']['platform'],
                        'status' => DeviceBinding::STATUS_ACTIVE,
                        'first_seen_at_utc' => $now,
                        'deactivated_at_utc' => null,
                    ]
                );
            }

            $license->load('plan');
            $apiToken = $this->tokenService->issueToken($license);

            return [$license, $apiToken];
        }, 3);

        return [
            'license' => $this->presenter->summarize($license),
            'api_token' => $apiToken,
            'server_time' => $now->toISOString(),
        ];
    }

    private function firstOrCreateAccount(Application $application, string $email): Account
    {
        try {
            return Account::query()->firstOrCreate([
                'application_id' => $application->id,
                'email' => $email,
            ]);
        } catch (QueryException $e) {
            if (! $this->isDuplicateKeyViolation($e)) {
                throw $e;
            }

            return Account::query()
                ->where('application_id', $application->id)
                ->where('email', $email)
                ->firstOrFail();
        }
    }

    private function isDuplicateKeyViolation(QueryException $e): bool
    {
        $sqlState = (string) $e->getCode();
        $driverCode = (int) ($e->errorInfo[1] ?? 0);

        return $sqlState === '23000' || $driverCode === 1062;
    }
}
