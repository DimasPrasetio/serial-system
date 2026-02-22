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

        $trialPlan = Plan::query()
            ->where('application_id', $application->id)
            ->where('is_trial', true)
            ->where('is_active', true)
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

        $result = DB::transaction(function () use ($application, $payload, $trialPlan, $deviceHash, $now) {
            TrialClaim::query()->create([
                'application_id' => $application->id,
                'device_hash' => $deviceHash,
            ]);

            $account = Account::query()->firstOrCreate(
                ['application_id' => $application->id, 'email' => $payload['email']]
            );

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
        });

        [$license, $apiToken] = $result;

        return [
            'license' => $this->presenter->summarize($license),
            'api_token' => $apiToken,
            'server_time' => $now->toISOString(),
        ];
    }
}
