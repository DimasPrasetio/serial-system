<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\LandingContactSetting;
use App\Models\LandingInstaller;
use App\Models\LandingPricingPlan;
use App\Models\LandingTrialSetting;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BlaskuLandingManagementController extends Controller
{
    private const APPLICATION_CODE = 'BLASKU';

    public function __construct(private readonly AuditLogService $auditLog)
    {
    }

    public function overview(): View
    {
        return view('admin.blasku-landing.index', $this->buildLandingContext());
    }

    public function pricing(): View
    {
        return view('admin.blasku-landing.pricing', $this->buildLandingContext());
    }

    public function installer(): View
    {
        return view('admin.blasku-landing.installer', $this->buildLandingContext());
    }

    public function trial(): View
    {
        return view('admin.blasku-landing.trial', $this->buildLandingContext());
    }

    public function contact(): View
    {
        return view('admin.blasku-landing.contact', $this->buildLandingContext());
    }

    public function storePricingPlan(Request $request): RedirectResponse
    {
        $application = $this->resolveBlaskuApplication();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:120',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('landing_pricing_plans', 'slug')->where(
                    fn ($query) => $query->where('application_id', $application->id)
                ),
            ],
            'original_price' => ['nullable', 'integer', 'min:0'],
            'price' => ['required', 'integer', 'min:0'],
            'period' => ['required', 'string', 'max:100'],
            'period_months' => ['required', 'integer', 'min:1'],
            'badge' => ['nullable', 'string', 'max:100'],
            'is_highlighted' => ['required', 'boolean'],
            'is_active' => ['required', 'boolean'],
            'cta_text' => ['required', 'string', 'max:100'],
            'sort_order' => ['required', 'integer', 'min:1'],
            'features_text' => ['required', 'string', 'max:3000'],
        ]);

        $plan = LandingPricingPlan::query()->create([
            'application_id' => $application->id,
            'name' => $data['name'],
            'slug' => $data['slug'],
            'original_price' => $data['original_price'] !== null ? (int) $data['original_price'] : null,
            'price' => (int) $data['price'],
            'period' => $data['period'],
            'period_months' => (int) $data['period_months'],
            'badge' => $this->nullableString($data['badge'] ?? null),
            'is_highlighted' => (bool) $data['is_highlighted'],
            'is_active' => (bool) $data['is_active'],
            'features' => $this->parseFeatures($data['features_text']),
            'cta_text' => $data['cta_text'],
            'sort_order' => (int) $data['sort_order'],
        ]);

        $this->auditLog->log(
            auth('admin')->user(),
            'blasku.landing.pricing.create',
            'landing_pricing_plan',
            (string) $plan->id,
            ['slug' => $plan->slug]
        );

        return redirect()
            ->route('admin.blasku-landing.pricing.index')
            ->with('status', 'Paket pricing landing berhasil ditambahkan.');
    }

    public function updatePricingPlan(Request $request, LandingPricingPlan $pricingPlan): RedirectResponse
    {
        $application = $this->resolveBlaskuApplication();
        $this->assertBelongsToBlasku($pricingPlan->application_id, $application->id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:120',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('landing_pricing_plans', 'slug')
                    ->where(fn ($query) => $query->where('application_id', $application->id))
                    ->ignore($pricingPlan->id),
            ],
            'original_price' => ['nullable', 'integer', 'min:0'],
            'price' => ['required', 'integer', 'min:0'],
            'period' => ['required', 'string', 'max:100'],
            'period_months' => ['required', 'integer', 'min:1'],
            'badge' => ['nullable', 'string', 'max:100'],
            'is_highlighted' => ['required', 'boolean'],
            'is_active' => ['required', 'boolean'],
            'cta_text' => ['required', 'string', 'max:100'],
            'sort_order' => ['required', 'integer', 'min:1'],
            'features_text' => ['required', 'string', 'max:3000'],
        ]);

        $pricingPlan->update([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'original_price' => $data['original_price'] !== null ? (int) $data['original_price'] : null,
            'price' => (int) $data['price'],
            'period' => $data['period'],
            'period_months' => (int) $data['period_months'],
            'badge' => $this->nullableString($data['badge'] ?? null),
            'is_highlighted' => (bool) $data['is_highlighted'],
            'is_active' => (bool) $data['is_active'],
            'features' => $this->parseFeatures($data['features_text']),
            'cta_text' => $data['cta_text'],
            'sort_order' => (int) $data['sort_order'],
        ]);

        $this->auditLog->log(
            auth('admin')->user(),
            'blasku.landing.pricing.update',
            'landing_pricing_plan',
            (string) $pricingPlan->id,
            ['slug' => $pricingPlan->slug]
        );

        return redirect()
            ->route('admin.blasku-landing.pricing.index')
            ->with('status', 'Paket pricing landing berhasil diperbarui.');
    }

    public function deletePricingPlan(LandingPricingPlan $pricingPlan): RedirectResponse
    {
        $application = $this->resolveBlaskuApplication();
        $this->assertBelongsToBlasku($pricingPlan->application_id, $application->id);

        $slug = $pricingPlan->slug;
        $pricingPlan->delete();

        $this->auditLog->log(
            auth('admin')->user(),
            'blasku.landing.pricing.delete',
            'landing_pricing_plan',
            (string) $pricingPlan->id,
            ['slug' => $slug]
        );

        return redirect()
            ->route('admin.blasku-landing.pricing.index')
            ->with('status', 'Paket pricing landing berhasil dihapus.');
    }

    public function updateInstaller(Request $request): RedirectResponse
    {
        $application = $this->resolveBlaskuApplication();

        $data = $request->validate([
            'version' => ['required', 'string', 'max:50'],
            'download_url' => ['required', 'url', 'max:2000'],
            'platform' => ['required', 'string', 'max:50'],
            'file_size_mb' => ['nullable', 'numeric', 'min:0'],
            'release_notes' => ['nullable', 'string', 'max:4000'],
            'is_available' => ['required', 'boolean'],
            'released_at' => ['nullable', 'date'],
        ]);

        $installer = LandingInstaller::query()->updateOrCreate(
            ['application_id' => $application->id],
            [
                'version' => $data['version'],
                'download_url' => $data['download_url'],
                'platform' => strtolower($data['platform']),
                'file_size_mb' => $data['file_size_mb'] !== null ? (float) $data['file_size_mb'] : null,
                'release_notes' => $this->nullableString($data['release_notes'] ?? null),
                'is_available' => (bool) $data['is_available'],
                'released_at' => ! empty($data['released_at']) ? Carbon::parse($data['released_at'])->utc() : null,
            ]
        );

        $this->auditLog->log(
            auth('admin')->user(),
            'blasku.landing.installer.update',
            'landing_installer',
            (string) $installer->id,
            ['version' => $installer->version]
        );

        return redirect()
            ->route('admin.blasku-landing.installer.index')
            ->with('status', 'Konfigurasi installer landing berhasil diperbarui.');
    }

    public function updateTrial(Request $request): RedirectResponse
    {
        $application = $this->resolveBlaskuApplication();

        $data = $request->validate([
            'duration_days' => ['required', 'integer', 'min:1', 'max:365'],
            'features_included' => ['required', Rule::in(['full', 'limited'])],
            'cta_text' => ['required', 'string', 'max:100'],
            'cta_subtext' => ['required', 'string', 'max:255'],
            'is_active' => ['required', 'boolean'],
        ]);

        $trial = LandingTrialSetting::query()->updateOrCreate(
            ['application_id' => $application->id],
            [
                'duration_days' => (int) $data['duration_days'],
                'features_included' => $data['features_included'],
                'cta_text' => $data['cta_text'],
                'cta_subtext' => $data['cta_subtext'],
                'is_active' => (bool) $data['is_active'],
            ]
        );

        $this->auditLog->log(
            auth('admin')->user(),
            'blasku.landing.trial.update',
            'landing_trial_setting',
            (string) $trial->id,
            ['duration_days' => $trial->duration_days]
        );

        return redirect()
            ->route('admin.blasku-landing.trial.index')
            ->with('status', 'Konfigurasi trial landing berhasil diperbarui.');
    }

    public function updateContact(Request $request): RedirectResponse
    {
        $application = $this->resolveBlaskuApplication();

        $data = $request->validate([
            'whatsapp_number' => ['required', 'string', 'max:30', 'regex:/^[0-9]+$/'],
            'whatsapp_display' => ['required', 'string', 'max:50'],
            'whatsapp_cta_text' => ['required', 'string', 'max:100'],
            'whatsapp_message_template' => ['required', 'string', 'max:1000'],
            'whatsapp_order_message_template' => ['required', 'string', 'max:1000'],
            'email' => ['nullable', 'email', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'tiktok_url' => ['nullable', 'url', 'max:255'],
        ]);

        $contact = LandingContactSetting::query()->updateOrCreate(
            ['application_id' => $application->id],
            [
                'whatsapp_number' => $data['whatsapp_number'],
                'whatsapp_display' => $data['whatsapp_display'],
                'whatsapp_cta_text' => $data['whatsapp_cta_text'],
                'whatsapp_message_template' => $data['whatsapp_message_template'],
                'whatsapp_order_message_template' => $data['whatsapp_order_message_template'],
                'email' => $this->nullableString($data['email'] ?? null),
                'instagram_url' => $this->nullableString($data['instagram_url'] ?? null),
                'youtube_url' => $this->nullableString($data['youtube_url'] ?? null),
                'tiktok_url' => $this->nullableString($data['tiktok_url'] ?? null),
            ]
        );

        $this->auditLog->log(
            auth('admin')->user(),
            'blasku.landing.contact.update',
            'landing_contact_setting',
            (string) $contact->id,
            ['whatsapp_number' => $contact->whatsapp_number]
        );

        return redirect()
            ->route('admin.blasku-landing.contact.index')
            ->with('status', 'Kontak landing berhasil diperbarui.');
    }

    private function resolveBlaskuApplication(): Application
    {
        return Application::query()->firstOrCreate(
            ['code' => self::APPLICATION_CODE],
            ['name' => 'BLASKU Desktop App', 'is_active' => true]
        );
    }

    private function buildLandingContext(): array
    {
        $application = $this->resolveBlaskuApplication();

        return [
            'application' => $application,
            'pricingPlans' => $application->landingPricingPlans()->orderBy('sort_order')->orderBy('id')->get(),
            'installer' => $application->landingInstaller()->firstOrNew([
                'application_id' => $application->id,
            ], [
                'platform' => 'windows',
                'is_available' => true,
            ]),
            'trialSetting' => $application->landingTrialSetting()->firstOrNew([
                'application_id' => $application->id,
            ], [
                'duration_days' => 7,
                'features_included' => 'full',
                'cta_text' => 'Download Gratis',
                'cta_subtext' => 'Trial {duration_days} hari penuh fitur inti',
                'is_active' => true,
            ]),
            'contactSetting' => $application->landingContactSetting()->firstOrNew([
                'application_id' => $application->id,
            ], [
                'whatsapp_number' => '6285173471146',
                'whatsapp_display' => '+62 851-7347-1146',
                'whatsapp_cta_text' => 'Tanya & Order',
                'whatsapp_message_template' => 'Halo, saya ingin bertanya tentang BLASKU.',
                'whatsapp_order_message_template' => 'Halo, saya ingin Tanya & Order BLASKU paket {plan_name} dengan harga {plan_price} / {plan_period}. Mohon info langkah pembayaran dan aktivasinya.',
            ]),
            'publicApiEndpoints' => [
                [
                    'label' => 'Pricing Plans',
                    'path' => '/api/v1/public/pricing-plans',
                ],
                [
                    'label' => 'Installer',
                    'path' => '/api/v1/public/installer',
                ],
                [
                    'label' => 'Trial',
                    'path' => '/api/v1/public/trial',
                ],
                [
                    'label' => 'Contact',
                    'path' => '/api/v1/public/contact',
                ],
            ],
        ];
    }

    private function parseFeatures(string $featuresText): array
    {
        $features = collect(preg_split('/\r\n|\r|\n/', $featuresText) ?: [])
            ->map(static fn (string $feature): string => trim($feature))
            ->filter()
            ->values()
            ->all();

        if ($features === []) {
            throw ValidationException::withMessages([
                'features_text' => 'Minimal satu fitur wajib diisi.',
            ]);
        }

        return $features;
    }

    private function assertBelongsToBlasku(int $resourceApplicationId, int $blaskuApplicationId): void
    {
        if ($resourceApplicationId !== $blaskuApplicationId) {
            abort(404);
        }
    }

    private function nullableString(?string $value): ?string
    {
        $value = $value !== null ? trim($value) : null;

        return $value === '' ? null : $value;
    }
}
