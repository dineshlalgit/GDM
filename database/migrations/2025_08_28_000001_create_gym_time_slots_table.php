<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('gym_time_slots', function (Blueprint $table) {
			$table->id();
			$table->date('date');
			$table->time('start_time');
			$table->time('end_time');
			$table->unsignedInteger('capacity')->default(20);
			$table->boolean('is_active')->default(true);
			$table->timestamps();
			$table->unique(['date', 'start_time', 'end_time'], 'gym_slots_unique_per_date_time');
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('gym_time_slots');
	}
};


