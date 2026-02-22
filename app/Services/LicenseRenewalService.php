<?php

namespace App\Services;

use App\Models\Application;
use App\Models\License;
use App\Models\SerialNumber;
use App\Support\ApiException;
use App\Support\LicenseStatus;
use App\Support\SecretHasher;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

class LicenseRenewalService
{
    public function renew(Application $application, License $license, string $renewSerial): array
    {
        if ($license->status === LicenseStatus::REVOKED) {
            throw new ApiException('LICENSE_REVOKED', 'License is revoked.', 403);
        }

        $license->loadMissing('plan');

        $serial = SerialNumber::query()
            ->with('plan')
            ->where('serial_hash', SecretHasher::hash($renewSerial))
            ->where('type', SerialNumber::TYPE_RENEW)
            ->first();

        if (! $serial || $serial->status === SerialNumber::STATUS_VOID) {
            throw new ApiException('RENEW_SERIAL_INVALID', 'Renewal serial is invalid.', 400);
        }

        if ($serial->status === SerialNumber::STATUS_USED) {
            throw new ApiException('SERIAL_ALREADY_USED', 'Renew serial already used.', 409);
        }

        if ($serial->application_id !== $application->id || $serial->application_id !== $license->application_id) {
            throw new ApiException('PRODUCT_MISMATCH', 'Renew serial does not match application.', 403);
        }

        if ($serial->plan->seat_limit !== $license->plan->seat_limit) {
            throw new ApiException('PRODUCT_MISMATCH', 'Renew serial does not match license product.', 403);
        }

        $now = CarbonImmutable::now('UTC');
        $before = $license->expires_at_utc;
        $base = $before->greaterThan($now) ? $before : $now;
        $after = $base->copy()->addDays($serial->plan->term_days);

        DB::transaction(function () use ($license, $serial, $after, $now) {
            $license->update([
                'plan_id' => $serial->plan_id,
                'status' => LicenseStatus::ACTIVE,
                'expires_at_utc' => $after,
            ]);

            $serial->update([
                'status' => SerialNumber::STATUS_USED,
                'used_at_utc' => $now,
            ]);
        });

        return [
            'license' => [
                'expires_at_before' => $before->toISOString(),
                'expires_at_after' => $after->toISOString(),
                'plan_code' => $serial->plan->code,
            ],
            'server_time' => $now->toISOString(),
        ];
    }
}
