<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GymTimeSlot extends Model
{
	use HasFactory;

	protected $fillable = [
		'start_time',
		'end_time',
		'capacity',
		'is_active',
	];

	protected $casts = [
		'start_time' => 'datetime:H:i',
		'end_time' => 'datetime:H:i',
		'is_active' => 'boolean',
	];

	public function bookings(): HasMany
	{
		return $this->hasMany(GymBooking::class);
	}

	public function getBookedCount(): int
	{
		return $this->bookings()
			->where('status', 'confirmed')
			->count();
	}

	public function isFull(): bool
	{
		return $this->getBookedCount() >= $this->capacity;
	}
}


