@extends('admin.layouts.app')

@section('content')
<div class="mb-6 flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Landing BLASKU</p>
        <h2 class="mt-1 text-3xl font-bold text-slate-800">Trial</h2>
        <p class="mt-3 max-w-3xl text-sm leading-relaxed text-slate-500">
            Atur durasi trial, CTA, dan status penayangan tombol trial di landing page.
        </p>
    </div>

    <span class="{{ $trialSetting->is_active ? 'status-active' : 'status-inactive' }}">
        {{ $trialSetting->is_active ? 'CTA active' : 'CTA inactive' }}
    </span>
</div>

@include('admin.blasku-landing.partials.subnav')

<section class="panel">
    <header class="panel-header">
        <div>
            <h3 class="panel-title">Konfigurasi Trial</h3>
            <p class="mt-2 text-sm text-slate-500">Pastikan teks CTA dan subtext sinkron dengan pesan landing page.</p>
        </div>
    </header>

    <div class="panel-body">
        <form method="POST" action="{{ route('admin.blasku-landing.trial.update') }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="field-label" for="trial_duration_days">Durasi Trial (hari)</label>
                    <input id="trial_duration_days" class="field-input" type="number" min="1" name="duration_days" value="{{ old('duration_days', $trialSetting->duration_days) }}" required>
                </div>
                <div>
                    <label class="field-label" for="trial_features_included">Fitur</label>
                    <select id="trial_features_included" class="field-select" name="features_included" required>
                        <option value="full" @selected(old('features_included', $trialSetting->features_included) === 'full')>full</option>
                        <option value="limited" @selected(old('features_included', $trialSetting->features_included) === 'limited')>limited</option>
                    </select>
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="field-label" for="trial_cta_text">CTA Text</label>
                    <input id="trial_cta_text" class="field-input" name="cta_text" value="{{ old('cta_text', $trialSetting->cta_text) }}" required>
                </div>
                <div>
                    <label class="field-label" for="trial_is_active">Status Trial CTA</label>
                    <select id="trial_is_active" class="field-select" name="is_active" required>
                        <option value="1" @selected((string) old('is_active', (int) $trialSetting->is_active) === '1')>active</option>
                        <option value="0" @selected((string) old('is_active', (int) $trialSetting->is_active) === '0')>inactive</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="field-label" for="trial_cta_subtext">CTA Subtext</label>
                <input id="trial_cta_subtext" class="field-input" name="cta_subtext" value="{{ old('cta_subtext', $trialSetting->cta_subtext) }}" required>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="btn-primary">Simpan Trial</button>
            </div>
        </form>
    </div>
</section>
@endsection
