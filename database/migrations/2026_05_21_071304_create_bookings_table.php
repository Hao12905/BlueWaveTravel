<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->decimal('original_amount', 15, 0)->nullable();
            $table->decimal('discount_amount', 15, 0)->default(0);
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('fullname');
            $table->string('phone')->nullable();
            $table->string('email');
            $table->string('payment_method')->nullable();
            $table->date('departure_date');
            $table->date('end_date')->nullable();
            $table->integer('guests')->default(1);
            $table->decimal('total_amount', 15, 0);
            $table->integer('points_earned')->default(0);
            $table->timestamp('points_awarded_at')->nullable();
            $table->string('coupon_code', 50)->nullable();
            $table->enum('status', ['Pending', 'Confirmed', 'Completed', 'Cancelled'])->default('Pending');
            $table->text('note')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
