<?php

namespace App\Services;

use App\Models\License;
use App\Models\LicenseToken;
use App\Support\SecretHasher;
use App\Support\TokenFactory;
use Carbon\CarbonImmutable;

class LicenseTokenService
{
    public function issueToken(License $license): string
    {
        $plainToken = TokenFactory::generateApiToken();
        $now = CarbonImmutable::now('UTC');

        LicenseToken::query()->create([
            'license_id' => $license->id,
            'token_hash' => SecretHasher::hash($plainToken),
            'issued_at_utc' => $now,
            'expires_at_utc' => $now->addDays(30),
        ]);

        return $plainToken;
    }
}
