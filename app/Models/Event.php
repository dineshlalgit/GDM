<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\EventClosedNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'type',
        'description',
        'event_datetime',
        'location',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'event_datetime' => 'datetime',
        ];
    }

    /**
     * Get the status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'open' => 'success',
            'closed' => 'danger',
            default => 'gray',
        };
    }

    /**
     * Scope for open events.
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Scope for closed events.
     */
    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    /**
     * Scope for upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('event_datetime', '>', now());
    }

    /**
     * Scope for past events.
     */
    public function scopePast($query)
    {
        return $query->where('event_datetime', '<', now());
    }

    /**
     * Check if the event is in the past.
     */
    public function isPast(): bool
    {
        return $this->event_datetime < now();
    }

    /**
     * Check if the event is upcoming.
     */
    public function isUpcoming(): bool
    {
        return $this->event_datetime > now();
    }

    /**
     * Automatically close past events.
     */
    public static function closePastEvents(): void
    {
        static::where('event_datetime', '<', now())
            ->where('status', 'open')
            ->update(['status' => 'closed']);
    }

    /**
     * Get the registrations for this event.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Get the users registered for this event.
     */
    public function registeredUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_registrations')
            ->withPivot('registered_at', 'status', 'notes')
            ->withTimestamps();
    }

    /**
     * Check if a specific user is registered for this event.
     */
    public function isUserRegistered(int $userId): bool
    {
        return $this->registrations()->where('user_id', $userId)->exists();
    }

    /**
     * Get the registration count for this event.
     */
    public function getRegistrationCountAttribute(): int
    {
        return $this->registrations()->count();
    }
}
