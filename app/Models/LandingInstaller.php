<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LandingInstaller extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'version',
        'download_url',
        'platform',
        'file_size_mb',
        'release_notes',
        'is_available',
        'released_at',
    ];

    protected $casts = [
        'file_size_mb' => 'float',
        'is_available' => 'bool',
        'released_at' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
