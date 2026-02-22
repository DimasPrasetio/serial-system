<?php

namespace App\Console\Commands;

use App\Models\LicenseToken;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;

class CleanupLicenseTokensCommand extends Command
{
    protected $signature = 'licenses:cleanup-tokens {--days=60 : Hapus token revoked lebih lama dari N hari}';
    protected $description = 'Cleanup token lama yang sudah revoked';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $threshold = CarbonImmutable::now('UTC')->subDays(max(1, $days));

        $deleted = LicenseToken::query()
            ->whereNotNull('revoked_at_utc')
            ->where('revoked_at_utc', '<', $threshold)
            ->delete();

        $this->info("Deleted tokens: {$deleted}");

        return self::SUCCESS;
    }
}
