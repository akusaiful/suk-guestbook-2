<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitorComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'visitor_id',
        'name',
        'organization',
        'comment',
        'rating',
        'status',
        'published_at',
    ];

    protected $casts = [
        'rating' => 'integer',
        'published_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(Visitor::class);
    }
}