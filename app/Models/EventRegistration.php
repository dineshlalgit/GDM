<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'registered_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
    ];

    /**
     * Get the user that registered for the event.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event that was registered for.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

}
