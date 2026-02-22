@extends('admin.layouts.auth')

@section('content')
<div class="mb-8 text-center">
    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Password Recovery</p>
    <h1 class="mt-3 text-3xl font-bold text-slate-800">Reset password</h1>
    <p class="mt-2 text-sm text-slate-500">Gunakan password baru minimal 8 karakter.</p>
</div>

<form method="POST" action="{{ route('admin.password.update') }}" class="space-y-5">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div>
        <label class="field-label" for="email">Email</label>
        <input id="email" type="email" name="email" class="field-input" required value="{{ $email }}" placeholder="admin@company.com">
    </div>

    <div>
        <label class="field-label" for="password">New Password</label>
        <input id="password" type="password" name="password" class="field-input" required placeholder="New password">
    </div>

    <div>
        <label class="field-label" for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" class="field-input" required placeholder="Repeat password">
    </div>

    <button class="btn-primary w-full" type="submit">Simpan Password Baru</button>
</form>

<div class="mt-6 text-center text-sm">
    <a class="font-semibold text-brand-700 hover:text-brand-800" href="{{ route('admin.login') }}">Kembali ke Login</a>
</div>
@endsection
