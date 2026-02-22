<?php

namespace App\Models;

use App\Support\LicenseStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class License extends Model
{
    use HasFactory;
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'application_id',
        'issued_serial_number_id',
        'account_id',
        'plan_id',
        'status',
        'starts_at_utc',
        'expires_at_utc',
        'revoked_at_utc',
    ];

    protected $casts = [
        'starts_at_utc' => 'datetime',
        'expires_at_utc' => 'datetime',
        'revoked_at_utc' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function issuedSerialNumber(): BelongsTo
    {
        return $this->belongsTo(SerialNumber::class, 'issued_serial_number_id');
    }

    public function tokens(): HasMany
    {
        return $this->hasMany(LicenseToken::class);
    }

    public function deviceBindings(): HasMany
    {
        return $this->hasMany(DeviceBinding::class);
    }

    public function isRevoked(): bool
    {
        return $this->status === LicenseStatus::REVOKED;
    }

    public function isExpired(): bool
    {
        return $this->status === LicenseStatus::EXPIRED || $this->expires_at_utc->isPast();
    }
}
