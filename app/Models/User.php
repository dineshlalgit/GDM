<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'quota',
        'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the role associated with the user.
     */
    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class);
    }

    /**
     * Get the media files uploaded by the user.
     */
    public function mediaFiles()
    {
        return $this->hasMany(\App\Models\MediaFile::class);
    }

    /**
     * Get the event registrations for this user.
     */
    public function eventRegistrations()
    {
        return $this->hasMany(\App\Models\EventRegistration::class);
    }

    /**
     * Get the events this user is registered for.
     */
    public function registeredEvents()
    {
        return $this->belongsToMany(\App\Models\Event::class, 'event_registrations')
            ->withPivot('registered_at', 'status', 'notes')
            ->withTimestamps();
    }

    public function getUsedStorageAttribute()
    {
        $files = $this->mediaFiles()->pluck('file_path');
        $total = 0;
        foreach ($files as $file) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($file)) {
                $total += \Illuminate\Support\Facades\Storage::disk('public')->size($file);
            }
        }
        return $total; // in bytes
    }
}
