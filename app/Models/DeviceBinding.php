<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceBinding extends Model
{
    use HasFactory;

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';

    protected $fillable = [
        'license_id',
        'fingerprint_hash',
        'label',
        'platform',
        'status',
        'first_seen_at_utc',
        'deactivated_at_utc',
    ];

    protected $casts = [
        'first_seen_at_utc' => 'datetime',
        'deactivated_at_utc' => 'datetime',
    ];

    public function license(): BelongsTo
    {
        return $this->belongsTo(License::class);
    }
}
