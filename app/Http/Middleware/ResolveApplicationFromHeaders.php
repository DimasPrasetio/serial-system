<?php

namespace App\Http\Middleware;

use App\Models\Application;
use App\Support\ApiException;
use App\Support\SecretHasher;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveApplicationFromHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $applicationCode = (string) $request->header('X-Application-Code', '');
        if ($applicationCode === '') {
            throw new ApiException('APPLICATION_INVALID', 'X-Application-Code header is required.', 403);
        }

        $application = Application::query()
            ->where('code', $applicationCode)
            ->where('is_active', true)
            ->first();

        if (! $application) {
            throw new ApiException('APPLICATION_INVALID', 'Application is invalid or inactive.', 403);
        }

        $applicationToken = trim((string) $request->header('X-Application-Token', ''));
        if ($application->token_hash !== null) {
            if ($applicationToken === '') {
                throw new ApiException('APPLICATION_INVALID', 'Application token is required.', 403);
            }

            if (SecretHasher::hash($applicationToken) !== $application->token_hash) {
                throw new ApiException('APPLICATION_INVALID', 'Application token is invalid.', 403);
            }
        }

        $request->attributes->set('application', $application);

        return $next($request);
    }
}
