<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_add_fields_to_users_table.php
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'full_name')) {
            $table->string('full_name')->after('name')->nullable();
        }
        if (!Schema::hasColumn('users', 'phone')) {
            $table->string('phone')->after('email')->nullable();
        }
        if (!Schema::hasColumn('users', 'role')) {
            $table->tinyInteger('role')->default(0)->after('phone'); // 0:user,1:staff,2:admin
        }
        if (!Schema::hasColumn('users', 'points')) {
            $table->integer('points')->default(0)->after('role');
        }
        if (!Schema::hasColumn('users', 'status')) {
            $table->boolean('status')->default(1)->after('points');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
