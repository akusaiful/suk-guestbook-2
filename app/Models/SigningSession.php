<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SigningSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'signer_id',
        'status',
        'opened_at',
        'signed_at',
        'device_id',
        'ip_address',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'signed_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function signer(): BelongsTo
    {
        return $this->belongsTo(Signer::class);
    }

    public function signature(): HasOne
    {
        return $this->hasOne(Signature::class);
    }
}
