<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
	public function up(): void
	{
		Schema::table('gym_time_slots', function (Blueprint $table) {
			if (Schema::hasColumn('gym_time_slots', 'date')) {
				try { $table->dropUnique('gym_slots_unique_per_date_time'); } catch (\Throwable $e) {}
				$table->dropColumn('date');
			}
		});

		// Ensure we don't re-create a duplicate unique index
		try {
			DB::statement("ALTER TABLE `gym_time_slots` DROP INDEX `gym_slots_unique_time`");
		} catch (\Throwable $e) {
			// ignore if it doesn't exist
		}

		// Create unique only if not already present
		$hasUnique = DB::table('INFORMATION_SCHEMA.STATISTICS')
			->where('TABLE_SCHEMA', DB::getDatabaseName())
			->where('TABLE_NAME', 'gym_time_slots')
			->where('INDEX_NAME', 'gym_slots_unique_time')
			->exists();
		if (! $hasUnique) {
			Schema::table('gym_time_slots', function (Blueprint $table) {
				$table->unique(['start_time', 'end_time'], 'gym_slots_unique_time');
			});
		}

		Schema::table('gym_bookings', function (Blueprint $table) {
			// Add booking_date first if missing
			if (! Schema::hasColumn('gym_bookings', 'booking_date')) {
				$table->date('booking_date')->after('gym_time_slot_id');
			}
		});

		// Ensure there is a dedicated index for the foreign key before dropping the old unique
		$fkIndexExists = DB::table('INFORMATION_SCHEMA.STATISTICS')
			->where('TABLE_SCHEMA', DB::getDatabaseName())
			->where('TABLE_NAME', 'gym_bookings')
			->where('INDEX_NAME', 'gym_bookings_gym_time_slot_id_index')
			->exists();
		if (! $fkIndexExists) {
			Schema::table('gym_bookings', function (Blueprint $table) {
				$table->index('gym_time_slot_id', 'gym_bookings_gym_time_slot_id_index');
			});
		}

		// Drop previous unique if present
		try {
			Schema::table('gym_bookings', function (Blueprint $table) {
				$table->dropUnique('gym_unique_booking_per_user_slot');
			});
		} catch (\Throwable $e) {}

		// Create the new composite unique that includes booking_date if missing
		$compositeExists = DB::table('INFORMATION_SCHEMA.STATISTICS')
			->where('TABLE_SCHEMA', DB::getDatabaseName())
			->where('TABLE_NAME', 'gym_bookings')
			->where('INDEX_NAME', 'gym_unique_booking_per_user_slot_date')
			->exists();
		if (! $compositeExists) {
			Schema::table('gym_bookings', function (Blueprint $table) {
				$table->unique(['user_id', 'gym_time_slot_id', 'booking_date'], 'gym_unique_booking_per_user_slot_date');
			});
		}
	}

	public function down(): void
	{
		Schema::table('gym_time_slots', function (Blueprint $table) {
			if (! Schema::hasColumn('gym_time_slots', 'date')) {
				$table->date('date')->after('id');
			}
			try { $table->dropUnique('gym_slots_unique_time'); } catch (\Throwable $e) {}
			try { $table->unique(['date', 'start_time', 'end_time'], 'gym_slots_unique_per_date_time'); } catch (\Throwable $e) {}
		});

		Schema::table('gym_bookings', function (Blueprint $table) {
			try { $table->dropUnique('gym_unique_booking_per_user_slot_date'); } catch (\Throwable $e) {}
			if (Schema::hasColumn('gym_bookings', 'booking_date')) {
				$table->dropColumn('booking_date');
			}
			try { $table->unique(['user_id', 'gym_time_slot_id'], 'gym_unique_booking_per_user_slot'); } catch (\Throwable $e) {}
		});
	}
};


