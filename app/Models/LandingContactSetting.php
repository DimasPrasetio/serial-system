<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LandingContactSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'whatsapp_number',
        'whatsapp_display',
        'whatsapp_cta_text',
        'whatsapp_message_template',
        'whatsapp_order_message_template',
        'email',
        'instagram_url',
        'youtube_url',
        'tiktok_url',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
