<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
	public function up(): void
	{
		// Drop unique with booking_date if exists
		try {
			Schema::table('gym_bookings', function (Blueprint $table) {
				$table->dropUnique('gym_unique_booking_per_user_slot_date');
			});
		} catch (\Throwable $e) {}

		Schema::table('gym_bookings', function (Blueprint $table) {
			if (Schema::hasColumn('gym_bookings', 'booking_date')) {
				$table->dropColumn('booking_date');
			}
		});

		// Restore unique constraint per user and slot
		try {
			Schema::table('gym_bookings', function (Blueprint $table) {
				$table->unique(['user_id', 'gym_time_slot_id'], 'gym_unique_booking_per_user_slot');
			});
		} catch (\Throwable $e) {}
	}

	public function down(): void
	{
		Schema::table('gym_bookings', function (Blueprint $table) {
			$table->date('booking_date')->after('gym_time_slot_id');
			try { $table->dropUnique('gym_unique_booking_per_user_slot'); } catch (\Throwable $e) {}
			$table->unique(['user_id', 'gym_time_slot_id', 'booking_date'], 'gym_unique_booking_per_user_slot_date');
		});
	}
};


