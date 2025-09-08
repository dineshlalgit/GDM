<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('events', 'status')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('events', 'status')) {
            Schema::table('events', function (Blueprint $table) {
                $table->enum('status', ['open', 'closed'])->default('open');
            });
        }
    }
};


