<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('coupon_history')) {
            return;
        }

        Schema::create('coupon_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('coupon_code');
            $table->timestamp('used_at')->useCurrent();
            $table->unique(['user_id', 'coupon_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupon_history');
    }
};
