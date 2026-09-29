<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'organization',
        'phone',
        'email',
        'purpose',
        'checked_in_at',
        'registration_method',
        'is_active',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(VisitorComment::class);
    }
}
