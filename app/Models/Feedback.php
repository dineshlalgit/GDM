<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'rating',
        'message',
        'status',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Filament resource methods
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'success',
            'pending' => 'warning',
            'rejected' => 'danger',
            default => 'gray',
        };
    }

    public function getRatingTextAttribute(): string
    {
        return match($this->rating) {
            1 => 'Poor',
            2 => 'Fair',
            3 => 'Good',
            4 => 'Very Good',
            5 => 'Excellent',
            default => 'Unknown',
        };
    }
}
