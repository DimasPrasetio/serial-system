@extends('admin.layouts.auth')

@section('content')
<div class="mb-8 text-center">
    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Password Recovery</p>
    <h1 class="mt-3 text-3xl font-bold text-slate-800">Lupa password?</h1>
    <p class="mt-2 text-sm text-slate-500">Masukkan email admin, kami kirimkan link reset.</p>
</div>

<form method="POST" action="{{ route('admin.password.email') }}" class="space-y-5">
    @csrf
    <div>
        <label class="field-label" for="email">Email</label>
        <input id="email" type="email" name="email" class="field-input" placeholder="admin@company.com" required>
    </div>

    <button class="btn-primary w-full" type="submit">Kirim Link Reset</button>
</form>

<div class="mt-6 text-center text-sm">
    <a class="font-semibold text-brand-700 hover:text-brand-800" href="{{ route('admin.login') }}">Kembali ke Login</a>
</div>
@endsection
