<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Application;
use App\Models\DeviceBinding;
use App\Models\License;
use App\Models\Plan;
use App\Models\TrialClaim;
use App\Support\ApiException;
use App\Support\LicenseStatus;
use Carbon\CarbonImmutable;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class TrialLicenseService
{
    public function __construct(
        private readonly LicenseTokenService $tokenService,
        private readonly LicensePresenter $presenter
    ) {
    }

    public function createTrial(Application $application, array $payload): array
    {
        $now = CarbonImmutable::now('UTC');
        $email = strtolower(trim((string) $payload['email']));

        $trialPlan = Plan::query()
            ->where('application_id', $application->id)
            ->where('is_trial', true)
            ->where('is_active', true)
            ->latest()
            ->first();

        if (! $trialPlan) {
            throw new ApiException('APPLICATION_INVALID', 'Trial plan is not available for this application.', 403);
        }

        $deviceHash = $payload['device']['fingerprint_hash'];
        $existingTrial = TrialClaim::query()
            ->where('application_id', $application->id)
            ->where('device_hash', $deviceHash)
            ->exists();

        if ($existingTrial) {
            throw new ApiException('TRIAL_ALREADY_USED', 'Trial already used on this device.', 409);
        }

        try {
            $result = DB::transaction(function () use ($application, $payload, $trialPlan, $deviceHash, $now, $email) {
                TrialClaim::query()->create([
                    'application_id' => $application->id,
                    'device_hash' => $deviceHash,
                ]);

                $account = $this->firstOrCreateAccount($application, $email);

                $license = License::query()->create([
                    'application_id' => $application->id,
                    'account_id' => $account->id,
                    'plan_id' => $trialPlan->id,
                    'status' => LicenseStatus::ACTIVE,
                    'starts_at_utc' => $now,
                    'expires_at_utc' => $now->addDays($trialPlan->term_days),
                ]);

                DeviceBinding::query()->create([
                    'license_id' => $license->id,
                    'fingerprint_hash' => $deviceHash,
                    'label' => $payload['device']['label'],
                    'platform' => $payload['device']['platform'],
                    'status' => DeviceBinding::STATUS_ACTIVE,
                    'first_seen_at_utc' => $now,
                ]);

                $license->load('plan');
                $apiToken = $this->tokenService->issueToken($license);

                return [$license, $apiToken];
            }, 3);
        } catch (QueryException $e) {
            if ($this->isDuplicateKeyViolation($e) && str_contains(strtolower($e->getMessage()), 'trial_claim')) {
                throw new ApiException('TRIAL_ALREADY_USED', 'Trial already used on this device.', 409);
            }

            throw $e;
        }

        [$license, $apiToken] = $result;

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
