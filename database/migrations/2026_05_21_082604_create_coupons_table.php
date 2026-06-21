<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('coupons', function (Blueprint $table) {
    $table->id();
    $table->string('code')->unique();
    $table->enum('type', ['percent', 'fixed'])->default('percent');
    $table->decimal('value', 10, 2);
    $table->decimal('max_discount', 10, 2)->nullable();
    $table->integer('limit_usage')->default(1);
    $table->integer('used_count')->default(0);
    $table->date('expiry_date');
    $table->boolean('status')->default(1);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
