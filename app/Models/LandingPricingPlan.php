<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LandingPricingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'name',
        'slug',
        'original_price',
        'price',
        'period',
        'period_months',
        'badge',
        'is_highlighted',
        'is_active',
        'features',
        'cta_text',
        'sort_order',
    ];

    protected $casts = [
        'original_price' => 'integer',
        'price' => 'integer',
        'period_months' => 'integer',
        'is_highlighted' => 'bool',
        'is_active' => 'bool',
        'features' => 'array',
        'sort_order' => 'integer',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
