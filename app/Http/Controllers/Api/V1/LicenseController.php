<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivateLicenseRequest;
use App\Http\Requests\DeactivateDeviceRequest;
use App\Http\Requests\RenewLicenseRequest;
use App\Http\Requests\TrialLicenseRequest;
use App\Models\Application;
use App\Models\License;
use App\Services\DeviceBindingService;
use App\Services\LicenseActivationService;
use App\Services\LicenseRenewalService;
use App\Services\LicenseStatusService;
use App\Services\TrialLicenseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function __construct(
        private readonly LicenseActivationService $activationService,
        private readonly TrialLicenseService $trialService,
        private readonly LicenseStatusService $statusService,
        private readonly LicenseRenewalService $renewalService,
        private readonly DeviceBindingService $deviceBindingService
    ) {
    }

    public function activate(ActivateLicenseRequest $request): JsonResponse
    {
        /** @var Application $application */
        $application = $request->attributes->get('application');

        return response()->json($this->activationService->activate($application, $request->validated()));
    }

    public function trial(TrialLicenseRequest $request): JsonResponse
    {
        /** @var Application $application */
        $application = $request->attributes->get('application');

        return response()->json($this->trialService->createTrial($application, $request->validated()));
    }

    public function status(Request $request): JsonResponse
    {
        /** @var License $license */
        $license = $request->attributes->get('license');

        return response()->json($this->statusService->status($license));
    }

    public function renew(RenewLicenseRequest $request): JsonResponse
    {
        /** @var Application $application */
        $application = $request->attributes->get('application');
        /** @var License $license */
        $license = $request->attributes->get('license');

        return response()->json($this->renewalService->renew(
            $application,
            $license,
            $request->validated('renew_serial')
        ));
    }

    public function deactivateDevice(DeactivateDeviceRequest $request): JsonResponse
    {
        /** @var License $license */
        $license = $request->attributes->get('license');

        return response()->json(
            $this->deviceBindingService->deactivate($license, $request->validated('device_fingerprint_hash'))
        );
    }

    public function devices(Request $request): JsonResponse
    {
        /** @var License $license */
        $license = $request->attributes->get('license');
        $license->loadMissing('plan');

        return response()->json($this->deviceBindingService->list($license));
    }
}
