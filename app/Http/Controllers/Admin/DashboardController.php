<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\License;
use App\Models\SerialNumber;
use Carbon\CarbonImmutable;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $todayStart = CarbonImmutable::now('UTC')->startOfDay();
        $todayEnd = CarbonImmutable::now('UTC')->endOfDay();

        return view('admin.dashboard.index', [
            'totalApplications' => Application::query()->count(),
            'activeLicenses' => License::query()->where('status', 'active')->count(),
            'expiredLicenses' => License::query()->where('status', 'expired')->count(),
            'revokedLicenses' => License::query()->where('status', 'revoked')->count(),
            'dailyActivations' => SerialNumber::query()
                ->where('type', SerialNumber::TYPE_INITIAL)
                ->whereNotNull('used_at_utc')
                ->whereBetween('used_at_utc', [$todayStart, $todayEnd])
                ->count(),
            'dailyRenews' => SerialNumber::query()
                ->where('type', SerialNumber::TYPE_RENEW)
                ->whereNotNull('used_at_utc')
                ->whereBetween('used_at_utc', [$todayStart, $todayEnd])
                ->count(),
            'dailyTrials' => License::query()
                ->whereHas('plan', fn ($q) => $q->where('is_trial', true))
                ->whereBetween('created_at', [$todayStart, $todayEnd])
                ->count(),
        ]);
    }
}
