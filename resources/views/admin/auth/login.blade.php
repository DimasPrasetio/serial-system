@extends('admin.layouts.auth')

@section('content')
<div class="mb-8 text-center">
    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Admin Access</p>
    <h1 class="mt-3 text-3xl font-bold text-slate-800">Selamat datang</h1>
    <p class="mt-2 text-sm text-slate-500">Masuk untuk melanjutkan pengelolaan lisensi.</p>
</div>

<form method="POST" action="{{ route('admin.login.store') }}" class="space-y-5">
    @csrf
    <div>
        <label class="field-label" for="email">Email</label>
        <input id="email" type="email" name="email" class="field-input" placeholder="admin@company.com" required value="{{ old('email') }}">
    </div>

    <div>
        <label class="field-label" for="password">Password</label>
        <input id="password" type="password" name="password" class="field-input" placeholder="Enter password" required>
    </div>

    <label class="inline-flex items-center gap-2 text-sm text-slate-600">
        <input type="checkbox" id="remember" name="remember" class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
        Remember me
    </label>

    <button class="btn-primary w-full" type="submit">Masuk</button>
</form>

<div class="mt-6 text-center text-sm">
    <a class="font-semibold text-brand-700 hover:text-brand-800" href="{{ route('admin.password.request') }}">Lupa password?</a>
</div>
@endsection
