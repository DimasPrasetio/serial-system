<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $duplicateIssuedSerials = DB::table('licenses')
            ->select('issued_serial_number_id', DB::raw('COUNT(*) as total'))
            ->whereNotNull('issued_serial_number_id')
            ->groupBy('issued_serial_number_id')
            ->havingRaw('COUNT(*) > 1')
            ->limit(5)
            ->get();

        if ($duplicateIssuedSerials->isNotEmpty()) {
            $samples = $duplicateIssuedSerials
                ->map(fn ($row) => "{$row->issued_serial_number_id} (x{$row->total})")
                ->implode(', ');

            throw new RuntimeException(
                'Cannot add unique index on licenses.issued_serial_number_id because duplicate references exist. '.
                'Run `php artisan licenses:audit-integrity` and resolve duplicates first. Samples: '.$samples
            );
        }

        Schema::table('licenses', function (Blueprint $table) {
            $table->unique('issued_serial_number_id', 'licenses_issued_serial_unique');
            $table->index(['status', 'expires_at_utc'], 'licenses_status_expires_idx');
        });

        Schema::table('license_tokens', function (Blueprint $table) {
            $table->index(['revoked_at_utc', 'expires_at_utc'], 'license_tokens_revoked_expires_idx');
        });
    }

    public function down(): void
    {
        Schema::table('license_tokens', function (Blueprint $table) {
            $table->dropIndex('license_tokens_revoked_expires_idx');
        });

        Schema::table('licenses', function (Blueprint $table) {
            $table->dropIndex('licenses_status_expires_idx');
            $table->dropUnique('licenses_issued_serial_unique');
        });
    }
};
