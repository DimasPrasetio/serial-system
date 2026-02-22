<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Application;
use App\Models\License;
use App\Models\Plan;
use App\Models\SerialNumber;
use App\Support\LicenseStatus;
use App\Support\SecretHasher;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class LicenseApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_activate_success(): void
    {
        $app = $this->createApplicationEntity('APP1');
        $plan = $this->createPlan($app, 'PAID_1M_1SEAT', 30, 1);
        $serial = 'BLK-AAAA-BBBB-CCCC';
        $this->createSerial($app, $plan, $serial, SerialNumber::TYPE_INITIAL);

        $response = $this->postJson('/v1/licenses/activate', [
            'serial' => $serial,
            'email' => 'user@example.com',
            'device' => [
                'fingerprint_hash' => 'device-a',
                'label' => 'DESKTOP-01',
                'platform' => 'win32',
            ],
        ], $this->headersForApp('APP1'));

        $response
            ->assertOk()
            ->assertJsonPath('license.status', 'active')
            ->assertJsonPath('license.plan_code', 'PAID_1M_1SEAT')
            ->assertJsonPath('license.seat_limit', 1)
            ->assertJsonPath('license.seat_used', 1);
    }

    public function test_activate_app_mismatch_returns_application_invalid(): void
    {
        $app = $this->createApplicationEntity('APP1');
        $plan = $this->createPlan($app, 'PAID_1M_1SEAT', 30, 1);
        $this->createSerial($app, $plan, 'BLK-AAAA-BBBB-CCCC', SerialNumber::TYPE_INITIAL);

        $response = $this->postJson('/v1/licenses/activate', [
            'serial' => 'BLK-AAAA-BBBB-CCCC',
            'email' => 'user@example.com',
            'device' => [
                'fingerprint_hash' => 'device-a',
                'label' => 'DESKTOP-01',
                'platform' => 'win32',
            ],
        ], $this->headersForApp('UNKNOWN_APP'));

        $response
            ->assertStatus(403)
            ->assertJsonPath('code', 'APPLICATION_INVALID');
    }

    public function test_application_token_is_required_when_configured(): void
    {
        $app = $this->createApplicationEntity('APP1');
        $app->update(['token_hash' => SecretHasher::hash('app_secret_123')]);
        $plan = $this->createPlan($app, 'PAID_1M_1SEAT', 30, 1);
        $serial = 'BLK-TOKEN-REQ-0001';
        $this->createSerial($app, $plan, $serial, SerialNumber::TYPE_INITIAL);

        $payload = [
            'serial' => $serial,
            'email' => 'user@example.com',
            'device' => [
                'fingerprint_hash' => 'device-a',
                'label' => 'DESKTOP-01',
                'platform' => 'win32',
            ],
        ];

        $this->postJson('/v1/licenses/activate', $payload, $this->headersForApp('APP1'))
            ->assertStatus(403)
            ->assertJsonPath('code', 'APPLICATION_INVALID');

        $headers = $this->headersForApp('APP1');
        $headers['X-Application-Token'] = 'app_secret_123';

        $this->postJson('/v1/licenses/activate', $payload, $headers)
            ->assertOk()
            ->assertJsonPath('license.status', 'active');
    }

    public function test_trial_first_success(): void
    {
        $app = $this->createApplicationEntity('APP1');
        $this->createPlan($app, 'TRIAL_7D_1SEAT', 7, 1, true);

        $response = $this->postJson('/v1/licenses/trial', [
            'email' => 'trial@example.com',
            'device' => [
                'fingerprint_hash' => 'trial-device',
                'label' => 'LAPTOP-01',
                'platform' => 'win32',
            ],
        ], $this->headersForApp('APP1'));

        $response
            ->assertOk()
            ->assertJsonPath('license.plan_code', 'TRIAL_7D_1SEAT');
    }

    public function test_trial_second_same_device_returns_trial_already_used(): void
    {
        $app = $this->createApplicationEntity('APP1');
        $this->createPlan($app, 'TRIAL_7D_1SEAT', 7, 1, true);

        $payload = [
            'email' => 'trial@example.com',
            'device' => [
                'fingerprint_hash' => 'trial-device',
                'label' => 'LAPTOP-01',
                'platform' => 'win32',
            ],
        ];

        $this->postJson('/v1/licenses/trial', $payload, $this->headersForApp('APP1'))->assertOk();
        $this->postJson('/v1/licenses/trial', $payload, $this->headersForApp('APP1'))
            ->assertStatus(409)
            ->assertJsonPath('code', 'TRIAL_ALREADY_USED');
    }

    public function test_status_token_invalid(): void
    {
        $app = $this->createApplicationEntity('APP1');

        $this->getJson('/v1/licenses/status', $this->headersForApp($app->code))
            ->assertStatus(401)
            ->assertJsonPath('code', 'TOKEN_INVALID');
    }

    public function test_status_token_app_mismatch(): void
    {
        [$token] = $this->activateLicenseAndGetToken('APP1', 'SERIAL-APP1-0001', 30, 1);
        $this->createApplicationEntity('APP2');

        $headers = $this->headersForApp('APP2');
        $headers['Authorization'] = 'Bearer '.$token;

        $this->getJson('/v1/licenses/status', $headers)
            ->assertStatus(403)
            ->assertJsonPath('code', 'TOKEN_APP_MISMATCH');
    }

    public function test_renew_additive_when_not_expired(): void
    {
        [$token, $license] = $this->activateLicenseAndGetToken('APP1', 'SERIAL-APP1-0002', 30, 1);
        $renewPlan = $license->plan;
        $renewSerial = 'BLK-RENEW-0001';
        $this->createSerial($license->application, $renewPlan, $renewSerial, SerialNumber::TYPE_RENEW);

        $headers = $this->headersForApp('APP1');
        $headers['Authorization'] = 'Bearer '.$token;

        $response = $this->postJson('/v1/licenses/renew', [
            'renew_serial' => $renewSerial,
        ], $headers);

        $response->assertOk();
        $before = CarbonImmutable::parse($response->json('license.expires_at_before'));
        $after = CarbonImmutable::parse($response->json('license.expires_at_after'));
        $this->assertTrue($after->greaterThan($before));
        $this->assertEquals(30, $before->diffInDays($after));
    }

    public function test_renew_additive_when_expired(): void
    {
        [$token, $license] = $this->activateLicenseAndGetToken('APP1', 'SERIAL-APP1-0003', 30, 1);
        $license->update(['expires_at_utc' => CarbonImmutable::now('UTC')->subDays(2)]);
        $renewPlan = $license->plan;
        $renewSerial = 'BLK-RENEW-0002';
        $this->createSerial($license->application, $renewPlan, $renewSerial, SerialNumber::TYPE_RENEW);

        $headers = $this->headersForApp('APP1');
        $headers['Authorization'] = 'Bearer '.$token;

        $response = $this->postJson('/v1/licenses/renew', [
            'renew_serial' => $renewSerial,
        ], $headers);

        $response->assertOk();
        $before = CarbonImmutable::parse($response->json('license.expires_at_before'));
        $after = CarbonImmutable::parse($response->json('license.expires_at_after'));
        $this->assertTrue($after->greaterThan($before));
        $this->assertTrue($after->between(
            CarbonImmutable::now('UTC')->addDays(29),
            CarbonImmutable::now('UTC')->addDays(31)
        ));
    }

    public function test_renew_revoked_license_returns_license_revoked(): void
    {
        [$token, $license] = $this->activateLicenseAndGetToken('APP1', 'SERIAL-APP1-0004', 30, 1);
        $renewSerial = 'BLK-RENEW-0003';
        $this->createSerial($license->application, $license->plan, $renewSerial, SerialNumber::TYPE_RENEW);
        $license->update([
            'status' => LicenseStatus::REVOKED,
            'revoked_at_utc' => CarbonImmutable::now('UTC'),
        ]);

        $headers = $this->headersForApp('APP1');
        $headers['Authorization'] = 'Bearer '.$token;

        $this->postJson('/v1/licenses/renew', [
            'renew_serial' => $renewSerial,
        ], $headers)
            ->assertStatus(403)
            ->assertJsonPath('code', 'LICENSE_REVOKED');
    }

    public function test_seat_limit_enforcement(): void
    {
        $app = $this->createApplicationEntity('APP1');
        $plan = $this->createPlan($app, 'PAID_1M_1SEAT', 30, 1);
        $serial = 'BLK-SEAT-0001';
        $this->createSerial($app, $plan, $serial, SerialNumber::TYPE_INITIAL);

        $this->postJson('/v1/licenses/activate', [
            'serial' => $serial,
            'email' => 'user@example.com',
            'device' => [
                'fingerprint_hash' => 'device-1',
                'label' => 'PC-1',
                'platform' => 'win32',
            ],
        ], $this->headersForApp('APP1'))->assertOk();

        $this->postJson('/v1/licenses/activate', [
            'serial' => $serial,
            'email' => 'user@example.com',
            'device' => [
                'fingerprint_hash' => 'device-2',
                'label' => 'PC-2',
                'platform' => 'win32',
            ],
        ], $this->headersForApp('APP1'))
            ->assertStatus(409)
            ->assertJsonPath('code', 'SEAT_LIMIT_REACHED');
    }

    public function test_used_serial_cannot_be_reactivated_by_different_email(): void
    {
        $app = $this->createApplicationEntity('APP1');
        $plan = $this->createPlan($app, 'PAID_1M_2SEAT', 30, 2);
        $serial = 'BLK-EMAIL-LOCK-0001';
        $this->createSerial($app, $plan, $serial, SerialNumber::TYPE_INITIAL);

        $this->postJson('/v1/licenses/activate', [
            'serial' => $serial,
            'email' => 'owner@example.com',
            'device' => [
                'fingerprint_hash' => 'device-owner',
                'label' => 'PC-OWNER',
                'platform' => 'win32',
            ],
        ], $this->headersForApp('APP1'))->assertOk();

        $this->postJson('/v1/licenses/activate', [
            'serial' => $serial,
            'email' => 'other@example.com',
            'device' => [
                'fingerprint_hash' => 'device-other',
                'label' => 'PC-OTHER',
                'platform' => 'win32',
            ],
        ], $this->headersForApp('APP1'))
            ->assertStatus(403)
            ->assertJsonPath('code', 'SERIAL_EMAIL_MISMATCH');
    }

    public function test_devices_list_uses_deactivated_status_label(): void
    {
        [$token] = $this->activateLicenseAndGetToken('APP1', 'SERIAL-APP1-0005', 30, 1);
        $headers = $this->headersForApp('APP1');
        $headers['Authorization'] = 'Bearer '.$token;

        $this->postJson('/v1/licenses/devices/deactivate', [
            'device_fingerprint_hash' => 'base-device',
        ], $headers)->assertOk();

        $this->getJson('/v1/licenses/devices', $headers)
            ->assertOk()
            ->assertJsonFragment([
                'fingerprint_hash' => 'base-device',
                'status' => 'deactivated',
            ]);
    }

    public function test_admin_permission_boundary(): void
    {
        Permission::create(['name' => 'manage-licenses', 'guard_name' => 'admin']);
        $admin = Admin::query()->create([
            'name' => 'Ops Admin',
            'email' => 'ops@example.com',
            'password' => Hash::make('secret123'),
            'is_active' => true,
        ]);

        $this->assertFalse($admin->can('manage-licenses'));

        $admin->givePermissionTo('manage-licenses');
        $this->assertTrue($admin->fresh()->can('manage-licenses'));
    }

    private function createApplicationEntity(string $code): Application
    {
        return Application::query()->create([
            'code' => $code,
            'name' => $code.' App',
            'is_active' => true,
        ]);
    }

    private function createPlan(
        Application $application,
        string $code,
        int $termDays,
        int $seatLimit,
        bool $isTrial = false
    ): Plan {
        return Plan::query()->create([
            'application_id' => $application->id,
            'code' => $code,
            'name' => $code,
            'term_days' => $termDays,
            'seat_limit' => $seatLimit,
            'is_trial' => $isTrial,
            'is_active' => true,
        ]);
    }

    private function createSerial(
        Application $application,
        Plan $plan,
        string $serial,
        string $type
    ): SerialNumber {
        return SerialNumber::query()->create([
            'application_id' => $application->id,
            'plan_id' => $plan->id,
            'serial_hash' => SecretHasher::hash($serial),
            'serial_last4' => substr($serial, -4),
            'type' => $type,
            'status' => SerialNumber::STATUS_AVAILABLE,
        ]);
    }

    private function headersForApp(string $appCode): array
    {
        return ['X-Application-Code' => $appCode];
    }

    private function activateLicenseAndGetToken(
        string $appCode,
        string $serial,
        int $termDays,
        int $seatLimit
    ): array {
        $app = $this->createApplicationEntity($appCode);
        $plan = $this->createPlan($app, 'PAID_'.$termDays.'D_'.$seatLimit.'SEAT', $termDays, $seatLimit);
        $this->createSerial($app, $plan, $serial, SerialNumber::TYPE_INITIAL);

        $response = $this->postJson('/v1/licenses/activate', [
            'serial' => $serial,
            'email' => 'user@example.com',
            'device' => [
                'fingerprint_hash' => 'base-device',
                'label' => 'DESKTOP-01',
                'platform' => 'win32',
            ],
        ], $this->headersForApp($appCode));

        $response->assertOk();

        return [
            $response->json('api_token'),
            License::query()->with('application', 'plan')->firstOrFail(),
        ];
    }
}
