<?php

namespace App\Console\Commands;

use App\Models\License;
use App\Models\LicenseToken;
use App\Models\SerialNumber;
use App\Support\LicenseStatus;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AuditLicenseIntegrityCommand extends Command
{
    protected $signature = 'licenses:audit-integrity {--fail-on-issues : Return non-zero exit code if issues are found}';
    protected $description = 'Audit data integrity before applying production hardening migrations';

    public function handle(): int
    {
        $now = CarbonImmutable::now('UTC');

        $duplicateIssuedSerials = DB::table('licenses')
            ->select('issued_serial_number_id', DB::raw('COUNT(*) as total'))
            ->whereNotNull('issued_serial_number_id')
            ->groupBy('issued_serial_number_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        $initialSerialUsedWithoutLicense = SerialNumber::query()
            ->where('type', SerialNumber::TYPE_INITIAL)
            ->where('status', SerialNumber::STATUS_USED)
            ->whereNotExists(function ($q) {
                $q->selectRaw('1')
                    ->from('licenses')
                    ->whereColumn('licenses.issued_serial_number_id', 'serial_numbers.id');
            })
            ->count();

        $initialSerialAvailableWithLicense = SerialNumber::query()
            ->where('type', SerialNumber::TYPE_INITIAL)
            ->where('status', SerialNumber::STATUS_AVAILABLE)
            ->whereExists(function ($q) {
                $q->selectRaw('1')
                    ->from('licenses')
                    ->whereColumn('licenses.issued_serial_number_id', 'serial_numbers.id');
            })
            ->count();

        $activeSeatOverflowLicenses = DB::table('licenses')
            ->join('plans', 'plans.id', '=', 'licenses.plan_id')
            ->join('device_bindings', function ($join) {
                $join->on('device_bindings.license_id', '=', 'licenses.id')
                    ->where('device_bindings.status', '=', 'active');
            })
            ->select('licenses.id', 'plans.seat_limit', DB::raw('COUNT(device_bindings.id) as active_devices'))
            ->groupBy('licenses.id', 'plans.seat_limit')
            ->havingRaw('COUNT(device_bindings.id) > plans.seat_limit')
            ->get();

        $expiredStillActive = License::query()
            ->where('status', LicenseStatus::ACTIVE)
            ->where('expires_at_utc', '<', $now)
            ->count();

        $expiredTokensNotRevoked = LicenseToken::query()
            ->whereNull('revoked_at_utc')
            ->where('expires_at_utc', '<', $now)
            ->count();

        $issues = [
            'duplicate_issued_serial_license' => $duplicateIssuedSerials->count(),
            'initial_serial_used_without_license' => $initialSerialUsedWithoutLicense,
            'initial_serial_available_with_license' => $initialSerialAvailableWithLicense,
            'active_seat_overflow_licenses' => $activeSeatOverflowLicenses->count(),
            'expired_still_active_licenses' => $expiredStillActive,
            'expired_tokens_not_revoked' => $expiredTokensNotRevoked,
        ];

        $this->info('License integrity audit summary');
        $this->table(
            ['Check', 'Count', 'Status'],
            collect($issues)->map(function (int $count, string $check) {
                return [
                    $check,
                    $count,
                    $count === 0 ? 'OK' : 'ISSUE',
                ];
            })->values()->all()
        );

        if ($duplicateIssuedSerials->isNotEmpty()) {
            $this->warn('Duplicate issued serial references detected (sample up to 10 rows):');
            $this->table(
                ['issued_serial_number_id', 'total'],
                $duplicateIssuedSerials->take(10)->map(fn ($row) => [
                    (string) $row->issued_serial_number_id,
                    (int) $row->total,
                ])->all()
            );
        }

        if ($activeSeatOverflowLicenses->isNotEmpty()) {
            $this->warn('Seat overflow licenses detected (sample up to 10 rows):');
            $this->table(
                ['license_id', 'seat_limit', 'active_devices'],
                $activeSeatOverflowLicenses->take(10)->map(fn ($row) => [
                    (string) $row->id,
                    (int) $row->seat_limit,
                    (int) $row->active_devices,
                ])->all()
            );
        }

        $hasIssues = collect($issues)->contains(fn (int $count) => $count > 0);

        if ($hasIssues) {
            $this->warn('Issues found. Review and fix before running hardening migration in production.');
        } else {
            $this->info('No issues found. Safe to proceed to hardening migration.');
        }

        if ($hasIssues && $this->option('fail-on-issues')) {
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
