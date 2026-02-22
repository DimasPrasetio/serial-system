<?php

namespace App\Services;

use App\Models\DeviceBinding;
use App\Models\License;
use App\Support\ApiException;
use Carbon\CarbonImmutable;

class DeviceBindingService
{
    public function deactivate(License $license, string $fingerprintHash): array
    {
        $binding = DeviceBinding::query()
            ->where('license_id', $license->id)
            ->where('fingerprint_hash', $fingerprintHash)
            ->where('status', DeviceBinding::STATUS_ACTIVE)
            ->first();

        if (! $binding) {
            throw new ApiException('DEVICE_NOT_FOUND', 'Device not found.', 404);
        }

        $binding->update([
            'status' => DeviceBinding::STATUS_INACTIVE,
            'deactivated_at_utc' => CarbonImmutable::now('UTC'),
        ]);

        return [
            'message' => 'Device deactivated',
            'seat_used' => $this->seatUsed($license),
        ];
    }

    public function list(License $license): array
    {
        $devices = DeviceBinding::query()
            ->where('license_id', $license->id)
            ->orderBy('first_seen_at_utc')
            ->get()
            ->map(fn (DeviceBinding $device) => [
                'fingerprint_hash' => $device->fingerprint_hash,
                'label' => $device->label,
                'status' => $device->status === DeviceBinding::STATUS_INACTIVE ? 'deactivated' : $device->status,
                'first_seen_at' => $device->first_seen_at_utc->toISOString(),
            ])
            ->values()
            ->all();

        return [
            'devices' => $devices,
            'seat_limit' => $license->plan->seat_limit,
            'seat_used' => $this->seatUsed($license),
        ];
    }

    private function seatUsed(License $license): int
    {
        return DeviceBinding::query()
            ->where('license_id', $license->id)
            ->where('status', DeviceBinding::STATUS_ACTIVE)
            ->count();
    }
}
