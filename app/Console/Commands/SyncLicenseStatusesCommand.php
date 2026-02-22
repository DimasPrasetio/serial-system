<?php

namespace App\Console\Commands;

use App\Models\License;
use App\Models\LicenseToken;
use App\Support\LicenseStatus;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;

class SyncLicenseStatusesCommand extends Command
{
    protected $signature = 'licenses:sync-statuses';
    protected $description = 'Sinkron status license dan token yang sudah expired';

    public function handle(): int
    {
        $now = CarbonImmutable::now('UTC');

        $licenseUpdated = License::query()
            ->where('status', LicenseStatus::ACTIVE)
            ->where('expires_at_utc', '<', $now)
            ->update(['status' => LicenseStatus::EXPIRED]);

        $tokenUpdated = LicenseToken::query()
            ->whereNull('revoked_at_utc')
            ->where('expires_at_utc', '<', $now)
            ->update(['revoked_at_utc' => $now]);

        $this->info("License expired sync: {$licenseUpdated}");
        $this->info("Token revoked sync: {$tokenUpdated}");

        return self::SUCCESS;
    }
}
