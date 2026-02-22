<?php

namespace App\Console;

use App\Console\Commands\CleanupLicenseTokensCommand;
use App\Console\Commands\SyncLicenseStatusesCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(SyncLicenseStatusesCommand::class)->everyFiveMinutes();
        $schedule->command(CleanupLicenseTokensCommand::class, ['--days' => 60])->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
