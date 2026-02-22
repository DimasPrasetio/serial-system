<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeviceBinding;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;

class DeviceManagementController extends Controller
{
    public function deactivate(DeviceBinding $deviceBinding): RedirectResponse
    {
        $deviceBinding->update([
            'status' => DeviceBinding::STATUS_INACTIVE,
            'deactivated_at_utc' => CarbonImmutable::now('UTC'),
        ]);

        return back()->with('status', 'Device binding dinonaktifkan.');
    }
}
