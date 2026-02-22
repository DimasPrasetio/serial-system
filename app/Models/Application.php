<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'token_hash',
        'token_encrypted',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'bool',
    ];

    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class);
    }

    public function serialNumbers(): HasMany
    {
        return $this->hasMany(SerialNumber::class);
    }

    public function licenses(): HasMany
    {
        return $this->hasMany(License::class);
    }
}
