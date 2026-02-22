<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LicenseToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_id',
        'token_hash',
        'issued_at_utc',
        'expires_at_utc',
        'revoked_at_utc',
    ];

    protected $casts = [
        'issued_at_utc' => 'datetime',
        'expires_at_utc' => 'datetime',
        'revoked_at_utc' => 'datetime',
    ];

    public function license(): BelongsTo
    {
        return $this->belongsTo(License::class);
    }
}
