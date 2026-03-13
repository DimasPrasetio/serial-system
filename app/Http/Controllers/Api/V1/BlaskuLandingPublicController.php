<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\LandingContactSetting;
use App\Models\LandingInstaller;
use App\Models\LandingPricingPlan;
use App\Models\LandingTrialSetting;
use Illuminate\Http\JsonResponse;

class BlaskuLandingPublicController extends Controller
{
    private const APPLICATION_CODE = 'BLASKU';

    public function pricingPlans(): JsonResponse
    {
        $application = $this->resolveApplication();

        $plans = LandingPricingPlan::query()
            ->where('application_id', $application->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(fn (LandingPricingPlan $plan): array => [
                'id' => $plan->id,
                'name' => $plan->name,
                'slug' => $plan->slug,
                'original_price' => $plan->original_price,
                'price' => $plan->price,
                'period' => $plan->period,
                'period_months' => $plan->period_months,
                'badge' => $plan->badge,
                'is_highlighted' => $plan->is_highlighted,
                'features' => array_values($plan->features ?? []),
                'cta_text' => $plan->cta_text,
                'sort_order' => $plan->sort_order,
            ])
            ->values();

        return response()->json([
            'success' => true,
            'data' => $plans,
        ]);
    }

    public function installer(): JsonResponse
    {
        $application = $this->resolveApplication();

        $installer = LandingInstaller::query()
            ->where('application_id', $application->id)
            ->first();

        if (! $installer || ! $installer->is_available) {
            return response()->json([
                'success' => false,
                'message' => 'Installer tidak tersedia.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'version' => $installer->version,
                'download_url' => $installer->download_url,
                'platform' => $installer->platform,
                'file_size_mb' => $installer->file_size_mb,
                'release_notes' => $installer->release_notes,
                'is_available' => $installer->is_available,
                'released_at' => $installer->released_at?->toISOString(),
            ],
        ]);
    }

    public function trial(): JsonResponse
    {
        $application = $this->resolveApplication();

        /** @var LandingTrialSetting $trial */
        $trial = LandingTrialSetting::query()
            ->where('application_id', $application->id)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => [
                'duration_days' => $trial->duration_days,
                'features_included' => $trial->features_included,
                'cta_text' => $trial->cta_text,
                'cta_subtext' => $trial->cta_subtext,
                'is_active' => $trial->is_active,
            ],
        ]);
    }

    public function contact(): JsonResponse
    {
        $application = $this->resolveApplication();

        /** @var LandingContactSetting $contact */
        $contact = LandingContactSetting::query()
            ->where('application_id', $application->id)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => [
                'whatsapp_number' => $contact->whatsapp_number,
                'whatsapp_display' => $contact->whatsapp_display,
                'whatsapp_cta_text' => $contact->whatsapp_cta_text,
                'whatsapp_message_template' => $contact->whatsapp_message_template,
                'email' => $contact->email,
                'social_media' => [
                    'instagram' => $contact->instagram_url,
                    'youtube' => $contact->youtube_url,
                    'tiktok' => $contact->tiktok_url,
                ],
            ],
        ]);
    }

    private function resolveApplication(): Application
    {
        return Application::query()
            ->where('code', self::APPLICATION_CODE)
            ->firstOrFail();
    }
}
