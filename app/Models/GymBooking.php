<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GymBooking extends Model
{
	use HasFactory;

	protected $fillable = [
		'user_id',
		'gym_time_slot_id',
		'status',
	];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function timeSlot(): BelongsTo
	{
		return $this->belongsTo(GymTimeSlot::class, 'gym_time_slot_id');
	}
}


