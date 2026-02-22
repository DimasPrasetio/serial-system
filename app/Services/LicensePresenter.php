<?php

namespace App\Services;

use App\Models\DeviceBinding;
use App\Models\License;
use Carbon\CarbonInterface;

class LicensePresenter
{
    public function summarize(License $license): array
    {
        $seatUsed = $license->deviceBindings()
            ->where('status', DeviceBinding::STATUS_ACTIVE)
            ->count();

        return [
            'id' => $license->id,
            'status' => $license->status,
            'plan_code' => $license->plan->code,
            'seat_limit' => $license->plan->seat_limit,
            'seat_used' => $seatUsed,
            'starts_at' => $license->starts_at_utc->toISOString(),
            'expires_at' => $license->expires_at_utc->toISOString(),
        ];
    }

    public function summarizeStatus(License $license, CarbonInterface $now): array
    {
        $seatUsed = $license->deviceBindings()
            ->where('status', DeviceBinding::STATUS_ACTIVE)
            ->count();

        return [
            'status' => $license->status,
            'plan_code' => $license->plan->code,
            'expires_at' => $license->expires_at_utc->toISOString(),
            'seat_limit' => $license->plan->seat_limit,
            'seat_used' => $seatUsed,
            'days_remaining' => max(0, $now->diffInDays($license->expires_at_utc, false)),
        ];
    }
}
