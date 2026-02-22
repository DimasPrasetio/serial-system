<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Plan;
use App\Models\SerialNumber;
use App\Support\SecretHasher;
use Illuminate\Database\Seeder;

class BlaskuIntegrationSeeder extends Seeder
{
    public function run(): void
    {
        $application = Application::query()->firstOrCreate(
            ['code' => 'BLASKU'],
            [
                'name' => 'BLASKU Desktop App',
                'is_active' => true,
            ]
        );

        $plainAppToken = trim((string) env('BLASKU_APPLICATION_TOKEN', ''));
        $updates = [
            'name' => 'BLASKU Desktop App',
            'is_active' => true,
        ];

        if ($plainAppToken !== '') {
            $updates['token_hash'] = SecretHasher::hash($plainAppToken);
        }

        $application->update($updates);

        $planCatalog = [
            ['code' => 'TRIAL_7D_1SEAT', 'name' => 'Trial 7 Hari (1 Seat)', 'term_days' => 7, 'seat_limit' => 1, 'is_trial' => true],
            ['code' => 'PAID_1M_1SEAT', 'name' => 'Paid 1 Bulan (1 Seat)', 'term_days' => 30, 'seat_limit' => 1, 'is_trial' => false],
            ['code' => 'PAID_3M_1SEAT', 'name' => 'Paid 3 Bulan (1 Seat)', 'term_days' => 90, 'seat_limit' => 1, 'is_trial' => false],
            ['code' => 'PAID_1Y_1SEAT', 'name' => 'Paid 1 Tahun (1 Seat)', 'term_days' => 365, 'seat_limit' => 1, 'is_trial' => false],
            ['code' => 'PAID_1M_5SEAT', 'name' => 'Paid 1 Bulan (5 Seat)', 'term_days' => 30, 'seat_limit' => 5, 'is_trial' => false],
            ['code' => 'PAID_3M_5SEAT', 'name' => 'Paid 3 Bulan (5 Seat)', 'term_days' => 90, 'seat_limit' => 5, 'is_trial' => false],
            ['code' => 'PAID_1Y_5SEAT', 'name' => 'Paid 1 Tahun (5 Seat)', 'term_days' => 365, 'seat_limit' => 5, 'is_trial' => false],
        ];

        foreach ($planCatalog as $plan) {
            Plan::query()->updateOrCreate(
                [
                    'application_id' => $application->id,
                    'code' => $plan['code'],
                ],
                [
                    'name' => $plan['name'],
                    'term_days' => $plan['term_days'],
                    'seat_limit' => $plan['seat_limit'],
                    'is_trial' => $plan['is_trial'],
                    'is_active' => true,
                ]
            );
        }

        $this->cleanupSeededSampleSerials($application);

        if ($this->command) {
            $this->command->info('BLASKU integration seeded.');
            $this->command->line('Application Code: BLASKU');
            if ($plainAppToken === '') {
                $this->command->line('Application Token: <kosong, optional header X-Application-Token tidak diwajibkan>');
            } else {
                $this->command->line('Application Token: <dari env BLASKU_APPLICATION_TOKEN>');
            }
            $this->command->line('Sample serial disabled: daftar serial pesanan dikelola manual oleh admin.');
        }
    }

    private function cleanupSeededSampleSerials(Application $application): void
    {
        $sampleSerialHashes = collect([
            'BLK-BLSK-1M1S-INIT',
            'BLK-BLSK-3M1S-INIT',
            'BLK-BLSK-1Y1S-INIT',
            'BLK-BLSK-1M5S-INIT',
            'BLK-BLSK-3M5S-INIT',
            'BLK-BLSK-1Y5S-INIT',
            'BLK-BLSK-1M1S-RNEW',
            'BLK-BLSK-3M1S-RNEW',
            'BLK-BLSK-1Y1S-RNEW',
            'BLK-BLSK-1M5S-RNEW',
            'BLK-BLSK-3M5S-RNEW',
            'BLK-BLSK-1Y5S-RNEW',
        ])->map(static fn (string $plain): string => SecretHasher::hash($plain))->all();

        SerialNumber::query()
            ->where('application_id', $application->id)
            ->whereIn('serial_hash', $sampleSerialHashes)
            ->delete();
    }
}
