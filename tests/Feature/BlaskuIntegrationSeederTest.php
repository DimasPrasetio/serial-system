<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\LandingContactSetting;
use App\Models\LandingInstaller;
use App\Models\LandingPricingPlan;
use App\Models\LandingTrialSetting;
use Database\Seeders\BlaskuIntegrationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlaskuIntegrationSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_creates_missing_blasku_landing_baseline_records(): void
    {
        $this->seed(BlaskuIntegrationSeeder::class);

        $application = Application::query()->where('code', 'BLASKU')->first();

        $this->assertNotNull($application);
        $this->assertSame(3, LandingPricingPlan::query()->where('application_id', $application->id)->count());
        $this->assertDatabaseHas('landing_installers', ['application_id' => $application->id]);
        $this->assertDatabaseHas('landing_trial_settings', ['application_id' => $application->id]);
        $this->assertDatabaseHas('landing_contact_settings', ['application_id' => $application->id]);
    }

    public function test_seeder_does_not_override_existing_admin_managed_landing_content(): void
    {
        $application = Application::query()->create([
            'code' => 'BLASKU',
            'name' => 'BLASKU Desktop App',
            'is_active' => true,
        ]);

        LandingPricingPlan::query()->create([
            'application_id' => $application->id,
            'name' => 'Bulanan Custom',
            'slug' => 'bulanan',
            'original_price' => 299000,
            'price' => 149000,
            'period' => 'bulan',
            'period_months' => 1,
            'badge' => 'Custom',
            'is_highlighted' => true,
            'is_active' => true,
            'features' => ['Custom feature'],
            'cta_text' => 'Order Sekarang',
            'sort_order' => 10,
        ]);

        LandingInstaller::query()->create([
            'application_id' => $application->id,
            'version' => '9.9.9',
            'download_url' => 'https://example.com/custom-installer.exe',
            'platform' => 'windows',
            'file_size_mb' => 99.9,
            'release_notes' => 'Custom installer note',
            'is_available' => true,
            'released_at' => now(),
        ]);

        LandingTrialSetting::query()->create([
            'application_id' => $application->id,
            'duration_days' => 14,
            'features_included' => 'custom',
            'cta_text' => 'Mulai Trial Khusus',
            'cta_subtext' => 'Trial khusus admin',
            'is_active' => false,
        ]);

        LandingContactSetting::query()->create([
            'application_id' => $application->id,
            'whatsapp_number' => '6200000000000',
            'whatsapp_display' => '+62 000-0000-0000',
            'whatsapp_cta_text' => 'Chat Admin',
            'whatsapp_message_template' => 'Template umum custom',
            'whatsapp_order_message_template' => 'Template order custom',
            'email' => 'custom@example.com',
            'instagram_url' => 'https://instagram.com/custom',
            'youtube_url' => 'https://youtube.com/custom',
            'tiktok_url' => 'https://tiktok.com/@custom',
        ]);

        $this->seed(BlaskuIntegrationSeeder::class);

        $this->assertDatabaseHas('landing_pricing_plans', [
            'application_id' => $application->id,
            'slug' => 'bulanan',
            'name' => 'Bulanan Custom',
            'price' => 149000,
            'cta_text' => 'Order Sekarang',
            'sort_order' => 10,
        ]);
        $this->assertSame(3, LandingPricingPlan::query()->where('application_id', $application->id)->count());

        $this->assertDatabaseHas('landing_installers', [
            'application_id' => $application->id,
            'version' => '9.9.9',
            'download_url' => 'https://example.com/custom-installer.exe',
        ]);

        $this->assertDatabaseHas('landing_trial_settings', [
            'application_id' => $application->id,
            'duration_days' => 14,
            'cta_text' => 'Mulai Trial Khusus',
            'is_active' => false,
        ]);

        $this->assertDatabaseHas('landing_contact_settings', [
            'application_id' => $application->id,
            'whatsapp_number' => '6200000000000',
            'whatsapp_cta_text' => 'Chat Admin',
            'whatsapp_order_message_template' => 'Template order custom',
            'email' => 'custom@example.com',
        ]);
    }
}
