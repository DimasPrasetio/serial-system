<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\LandingContactSetting;
use App\Models\LandingInstaller;
use App\Models\LandingPricingPlan;
use App\Models\LandingTrialSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlaskuLandingApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_pricing_plans_endpoint_returns_only_active_plans_sorted(): void
    {
        $application = $this->createBlaskuApplication();

        LandingPricingPlan::query()->create([
            'application_id' => $application->id,
            'name' => 'Tahunan',
            'slug' => 'tahunan',
            'original_price' => 2388000,
            'price' => 999000,
            'period' => 'tahun',
            'period_months' => 12,
            'badge' => null,
            'is_highlighted' => false,
            'is_active' => true,
            'features' => ['Semua fitur inti'],
            'cta_text' => 'Tanya & Order',
            'sort_order' => 3,
        ]);

        LandingPricingPlan::query()->create([
            'application_id' => $application->id,
            'name' => '3 Bulan',
            'slug' => '3-bulan',
            'original_price' => 597000,
            'price' => 279000,
            'period' => '3 bulan',
            'period_months' => 3,
            'badge' => 'Paling Efisien',
            'is_highlighted' => true,
            'is_active' => true,
            'features' => ['Lead scraping lokal', 'Campaign adaptive'],
            'cta_text' => 'Tanya & Order',
            'sort_order' => 2,
        ]);

        LandingPricingPlan::query()->create([
            'application_id' => $application->id,
            'name' => 'Bulanan',
            'slug' => 'bulanan',
            'original_price' => 199000,
            'price' => 99000,
            'period' => 'bulan',
            'period_months' => 1,
            'badge' => null,
            'is_highlighted' => false,
            'is_active' => true,
            'features' => ['Database & segmentasi'],
            'cta_text' => 'Tanya & Order',
            'sort_order' => 1,
        ]);

        LandingPricingPlan::query()->create([
            'application_id' => $application->id,
            'name' => 'Hidden',
            'slug' => 'hidden',
            'original_price' => null,
            'price' => 1000,
            'period' => 'bulan',
            'period_months' => 1,
            'badge' => null,
            'is_highlighted' => false,
            'is_active' => false,
            'features' => ['Should not show'],
            'cta_text' => 'Hidden',
            'sort_order' => 0,
        ]);

        $this->getJson('/api/v1/public/pricing-plans')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonCount(3, 'data')
            ->assertJsonPath('data.0.slug', 'bulanan')
            ->assertJsonPath('data.1.slug', '3-bulan')
            ->assertJsonPath('data.2.slug', 'tahunan')
            ->assertJsonPath('data.1.is_highlighted', true)
            ->assertJsonPath('data.1.features.1', 'Campaign adaptive');
    }

    public function test_installer_endpoint_returns_configured_installer(): void
    {
        $application = $this->createBlaskuApplication();

        LandingInstaller::query()->create([
            'application_id' => $application->id,
            'version' => '1.5.2',
            'download_url' => 'https://example.com/download.exe',
            'platform' => 'windows',
            'file_size_mb' => 85.4,
            'release_notes' => 'Perbaikan stabilitas',
            'is_available' => true,
            'released_at' => now()->startOfDay(),
        ]);

        $this->getJson('/api/v1/public/installer')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.version', '1.5.2')
            ->assertJsonPath('data.download_url', 'https://example.com/download.exe')
            ->assertJsonPath('data.platform', 'windows')
            ->assertJsonPath('data.is_available', true);
    }

    public function test_installer_endpoint_returns_not_found_when_unavailable(): void
    {
        $application = $this->createBlaskuApplication();

        LandingInstaller::query()->create([
            'application_id' => $application->id,
            'version' => '1.5.2',
            'download_url' => 'https://example.com/download.exe',
            'platform' => 'windows',
            'file_size_mb' => 85.4,
            'release_notes' => 'Perbaikan stabilitas',
            'is_available' => false,
            'released_at' => now()->startOfDay(),
        ]);

        $this->getJson('/api/v1/public/installer')
            ->assertStatus(404)
            ->assertJsonPath('success', false);
    }

    public function test_trial_endpoint_returns_trial_configuration(): void
    {
        $application = $this->createBlaskuApplication();

        LandingTrialSetting::query()->create([
            'application_id' => $application->id,
            'duration_days' => 7,
            'features_included' => 'full',
            'cta_text' => 'Download Gratis',
            'cta_subtext' => 'Trial {duration_days} hari penuh fitur inti',
            'is_active' => true,
        ]);

        $this->getJson('/api/v1/public/trial')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.duration_days', 7)
            ->assertJsonPath('data.features_included', 'full')
            ->assertJsonPath('data.cta_text', 'Download Gratis');
    }

    public function test_contact_endpoint_returns_contact_configuration(): void
    {
        $application = $this->createBlaskuApplication();

        LandingContactSetting::query()->create([
            'application_id' => $application->id,
            'whatsapp_number' => '6285173471146',
            'whatsapp_display' => '+62 851-7347-1146',
            'whatsapp_cta_text' => 'Tanya & Order',
            'whatsapp_message_template' => 'Halo, saya ingin bertanya tentang BLASKU.',
            'email' => 'support@blasku.id',
            'instagram_url' => 'https://instagram.com/blasku.id',
            'youtube_url' => null,
            'tiktok_url' => null,
        ]);

        $this->getJson('/api/v1/public/contact')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.whatsapp_number', '6285173471146')
            ->assertJsonPath('data.whatsapp_cta_text', 'Tanya & Order')
            ->assertJsonPath('data.social_media.instagram', 'https://instagram.com/blasku.id');
    }

    private function createBlaskuApplication(): Application
    {
        return Application::query()->create([
            'code' => 'BLASKU',
            'name' => 'BLASKU Desktop App',
            'is_active' => true,
        ]);
    }
}
