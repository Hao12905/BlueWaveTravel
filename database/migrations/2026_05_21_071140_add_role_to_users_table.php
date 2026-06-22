<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->tinyInteger('role')->default(0);
            }
            if (!Schema::hasColumn('users', 'points')) {
                $table->integer('points')->default(0);
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('users', 'full_name')) {
                $table->string('full_name')->nullable();
            }
        });
    }

    public function down(): void
    {
        // These columns belong to the current users schema.
    }
};
