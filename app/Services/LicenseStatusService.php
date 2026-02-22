<?php

namespace App\Services;

use App\Models\License;
use App\Support\ApiException;
use App\Support\LicenseStatus;
use Carbon\CarbonImmutable;

class LicenseStatusService
{
    public function __construct(private readonly LicensePresenter $presenter)
    {
    }

    public function status(License $license): array
    {
        $now = CarbonImmutable::now('UTC');
        $license->loadMissing('plan');

        if ($license->status === LicenseStatus::REVOKED) {
            throw new ApiException('LICENSE_REVOKED', 'License is revoked.', 403);
        }

        if ($license->expires_at_utc->isPast()) {
            if ($license->status !== LicenseStatus::EXPIRED) {
                $license->update(['status' => LicenseStatus::EXPIRED]);
            }
            throw new ApiException('LICENSE_EXPIRED', 'License has expired.', 403);
        }

        return [
            'license' => $this->presenter->summarizeStatus($license, $now),
            'server_time' => $now->toISOString(),
        ];
    }
}
