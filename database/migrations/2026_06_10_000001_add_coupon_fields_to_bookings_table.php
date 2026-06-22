<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'original_amount')) {
                $table->decimal('original_amount', 15, 0)->nullable()->after('tour_id');
            }

            if (!Schema::hasColumn('bookings', 'discount_amount')) {
                $table->decimal('discount_amount', 15, 0)->default(0)->after('original_amount');
            }

            if (!Schema::hasColumn('bookings', 'coupon_code')) {
                $table->string('coupon_code', 50)->nullable()->after('discount_amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'coupon_code')) {
                $table->dropColumn('coupon_code');
            }

            if (Schema::hasColumn('bookings', 'discount_amount')) {
                $table->dropColumn('discount_amount');
            }

            if (Schema::hasColumn('bookings', 'original_amount')) {
                $table->dropColumn('original_amount');
            }
        });
    }
};
