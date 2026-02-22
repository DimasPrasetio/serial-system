<?php

namespace App\Http\Middleware;

use App\Models\LicenseToken;
use App\Support\ApiException;
use App\Support\SecretHasher;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateLicenseToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $header = (string) $request->header('Authorization', '');
        if (! str_starts_with($header, 'Bearer ')) {
            throw new ApiException('TOKEN_INVALID', 'Bearer token is required.', 401);
        }

        $token = trim(substr($header, 7));
        if ($token === '') {
            throw new ApiException('TOKEN_INVALID', 'Bearer token is invalid.', 401);
        }

        $licenseToken = LicenseToken::query()
            ->with('license.plan')
            ->where('token_hash', SecretHasher::hash($token))
            ->first();

        if (! $licenseToken || $licenseToken->revoked_at_utc !== null || $licenseToken->expires_at_utc->isPast()) {
            throw new ApiException('TOKEN_INVALID', 'Token is invalid or expired.', 401);
        }

        $application = $request->attributes->get('application');
        if (! $application || $licenseToken->license->application_id !== $application->id) {
            throw new ApiException('TOKEN_APP_MISMATCH', 'Token does not belong to this application.', 403);
        }

        $request->attributes->set('license_token', $licenseToken);
        $request->attributes->set('license', $licenseToken->license);

        return $next($request);
    }
}
