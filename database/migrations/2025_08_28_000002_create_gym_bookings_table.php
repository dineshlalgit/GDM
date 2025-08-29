<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('gym_bookings', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained()->cascadeOnDelete();
			$table->foreignId('gym_time_slot_id')->constrained()->cascadeOnDelete();
			$table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
			$table->timestamps();
			$table->unique(['user_id', 'gym_time_slot_id'], 'gym_unique_booking_per_user_slot');
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('gym_bookings');
	}
};


