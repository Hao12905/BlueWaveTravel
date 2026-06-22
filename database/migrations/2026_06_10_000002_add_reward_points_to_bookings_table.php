<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'points_earned')) {
                $table->integer('points_earned')->default(0)->after('total_amount');
            }

            if (!Schema::hasColumn('bookings', 'points_awarded_at')) {
                $table->timestamp('points_awarded_at')->nullable()->after('points_earned');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'points_awarded_at')) {
                $table->dropColumn('points_awarded_at');
            }

            if (Schema::hasColumn('bookings', 'points_earned')) {
                $table->dropColumn('points_earned');
            }
        });
    }
};
