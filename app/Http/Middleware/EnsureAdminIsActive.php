<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $admin = auth('admin')->user();
        if (! $admin || ! $admin->is_active) {
            auth('admin')->logout();
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Akun admin tidak aktif.',
            ]);
        }

        return $next($request);
    }
}
