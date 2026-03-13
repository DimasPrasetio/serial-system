<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\LandingContactSetting;
use App\Models\LandingInstaller;
use App\Models\LandingPricingPlan;
use App\Models\LandingTrialSetting;
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

        $landingPlans = [
            [
                'name' => 'Bulanan',
                'slug' => 'bulanan',
                'original_price' => 199000,
                'price' => 99000,
                'period' => 'bulan',
                'period_months' => 1,
                'badge' => null,
                'is_highlighted' => false,
                'features' => [
                    'Semua fitur inti',
                    'Lead scraping lokal',
                    'Database & segmentasi',
                    'Campaign adaptive',
                ],
                'cta_text' => 'Tanya & Order',
                'sort_order' => 1,
            ],
            [
                'name' => '3 Bulan',
                'slug' => '3-bulan',
                'original_price' => 597000,
                'price' => 279000,
                'period' => '3 bulan',
                'period_months' => 3,
                'badge' => 'Paling Efisien',
                'is_highlighted' => true,
                'features' => [
                    'Semua fitur inti',
                    'Lead scraping lokal',
                    'Database & segmentasi',
                    'Campaign adaptive',
                ],
                'cta_text' => 'Tanya & Order',
                'sort_order' => 2,
            ],
            [
                'name' => 'Tahunan',
                'slug' => 'tahunan',
                'original_price' => 2388000,
                'price' => 999000,
                'period' => 'tahun',
                'period_months' => 12,
                'badge' => null,
                'is_highlighted' => false,
                'features' => [
                    'Semua fitur inti',
                    'Lead scraping lokal',
                    'Database & segmentasi',
                    'Campaign adaptive',
                ],
                'cta_text' => 'Tanya & Order',
                'sort_order' => 3,
            ],
        ];

        foreach ($landingPlans as $landingPlan) {
            LandingPricingPlan::query()->updateOrCreate(
                [
                    'application_id' => $application->id,
                    'slug' => $landingPlan['slug'],
                ],
                $landingPlan + ['is_active' => true]
            );
        }

        LandingInstaller::query()->updateOrCreate(
            ['application_id' => $application->id],
            [
                'version' => '1.5.2',
                'download_url' => 'https://drive.usercontent.google.com/download?id=17uOtn9iQK9QHiYcP_2Eh1SPdfgr7Hhae&export=download&authuser=0',
                'platform' => 'windows',
                'file_size_mb' => 85.4,
                'release_notes' => 'Perbaikan stabilitas campaign adaptive dan peningkatan kecepatan scraper.',
                'is_available' => true,
                'released_at' => now()->copy()->startOfDay(),
            ]
        );

        LandingTrialSetting::query()->updateOrCreate(
            ['application_id' => $application->id],
            [
                'duration_days' => 7,
                'features_included' => 'full',
                'cta_text' => 'Download Gratis',
                'cta_subtext' => 'Trial {duration_days} hari penuh fitur inti',
                'is_active' => true,
            ]
        );

        LandingContactSetting::query()->updateOrCreate(
            ['application_id' => $application->id],
            [
                'whatsapp_number' => '6285173471146',
                'whatsapp_display' => '+62 851-7347-1146',
                'whatsapp_cta_text' => 'Tanya & Order',
                'whatsapp_message_template' => 'Halo, saya ingin bertanya tentang BLASKU.',
                'whatsapp_order_message_template' => 'Halo, saya ingin Tanya & Order BLASKU paket {plan_name} dengan harga {plan_price} / {plan_period}. Mohon info langkah pembayaran dan aktivasinya.',
                'email' => 'support@blasku.id',
                'instagram_url' => 'https://instagram.com/blasku.id',
                'youtube_url' => null,
                'tiktok_url' => null,
            ]
        );

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
