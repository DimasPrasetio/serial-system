<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LandingTrialSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'duration_days',
        'features_included',
        'cta_text',
        'cta_subtext',
        'is_active',
    ];

    protected $casts = [
        'duration_days' => 'integer',
        'is_active' => 'bool',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
