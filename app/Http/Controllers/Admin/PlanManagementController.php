<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Plan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanManagementController extends Controller
{
    public function index(Request $request): View
    {
        $applicationId = $request->integer('application_id');

        $query = Plan::query()->with('application')->latest();
        if ($applicationId > 0) {
            $query->where('application_id', $applicationId);
        }

        return view('admin.plans.index', [
            'plans' => $query->paginate(20)->withQueryString(),
            'applications' => Application::query()->orderBy('code')->get(),
            'selectedApplicationId' => $applicationId,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'application_id' => ['required', 'exists:applications,id'],
            'code' => ['required', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'term_days' => ['required', 'integer', 'min:1'],
            'seat_limit' => ['required', 'integer', 'min:1'],
            'is_trial' => ['sometimes', 'boolean'],
        ]);

        $isTrial = (bool) ($data['is_trial'] ?? false);

        if ($isTrial) {
            $hasActiveTrial = Plan::query()
                ->where('application_id', $data['application_id'])
                ->where('is_trial', true)
                ->where('is_active', true)
                ->exists();

            if ($hasActiveTrial) {
                return back()
                    ->withInput()
                    ->withErrors(['is_trial' => 'Sudah ada trial aktif untuk aplikasi ini. Nonaktifkan trial yang lama terlebih dahulu.']);
            }
        }

        Plan::query()->create([
            ...$data,
            'is_trial' => $isTrial,
            'is_active' => true,
        ]);

        return back()->with('status', 'Plan berhasil dibuat.');
    }

    public function update(Request $request, Plan $plan): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'term_days' => ['required', 'integer', 'min:1'],
            'seat_limit' => ['required', 'integer', 'min:1'],
            'is_trial' => ['required', 'boolean'],
            'is_active' => ['required', 'boolean'],
        ]);

        $plan->update($data);

        return back()->with('status', 'Plan berhasil diperbarui.');
    }
}
