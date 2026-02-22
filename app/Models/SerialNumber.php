<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SerialNumber extends Model
{
    use HasFactory;

    public const TYPE_INITIAL = 'initial';
    public const TYPE_RENEW = 'renew';

    public const STATUS_AVAILABLE = 'available';
    public const STATUS_USED = 'used';
    public const STATUS_VOID = 'void';

    protected $fillable = [
        'application_id',
        'plan_id',
        'serial_hash',
        'serial_last4',
        'serial_encrypted',
        'customer_email',
        'order_note',
        'type',
        'status',
        'used_at_utc',
    ];

    protected $casts = [
        'used_at_utc' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
