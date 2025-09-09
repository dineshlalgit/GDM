<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

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

    protected static function booted(): void
    {
        static::deleting(function (EventRegistration $registration): void {
            // Delete attachments uploaded by this user for this specific event
            $deleted = EventAttachment::where('event_id', $registration->event_id)
                ->where('user_id', $registration->user_id)
                ->get();

            $count = $deleted->count();
            $deleted->each->delete();

            if ($count > 0) {
                Log::info('[EventRegistration] Deleted user event attachments due to registration deletion.', [
                    'event_id' => $registration->event_id,
                    'user_id' => $registration->user_id,
                    'attachments_deleted' => $count,
                ]);
            }
        });
    }
}
