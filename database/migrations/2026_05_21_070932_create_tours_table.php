<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('short_desc')->nullable();
            $table->decimal('price', 15, 2);
            $table->string('duration')->nullable();
            $table->string('location')->nullable();
            $table->string('category')->nullable();
            $table->string('image_url')->nullable();
            $table->date('departure_date')->nullable();
            $table->boolean('featured')->default(0);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
