<?php

namespace App\Exceptions;

use App\Support\ApiException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (ApiException $e): JsonResponse {
            return response()->json([
                'code' => $e->apiCode,
                'message' => $e->getMessage(),
            ], $e->status);
        });

        $this->renderable(function (ValidationException $e, $request): ?JsonResponse {
            if (! $request->is('v1/*')) {
                return null;
            }

            $firstError = collect($e->errors())->flatten()->first() ?? 'Validation failed.';

            return response()->json([
                'code' => 'VALIDATION_ERROR',
                'message' => $firstError,
            ], 422);
        });

        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
