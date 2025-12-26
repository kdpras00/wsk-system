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
        Schema::table('users', function (Blueprint $table) {
            // Modify enum to include supervisor
            // Note: DB::statement is required for enum modification in MySQL if strict is on, 
            // but standard Laravel migration might struggle with existing data if we don't use raw SQL for enums.
            // Using raw statement for better compatibility with MySQL/MariaDB
            \DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'manager', 'operator', 'supervisor') NOT NULL DEFAULT 'operator'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            \DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'manager', 'operator') NOT NULL DEFAULT 'operator'");
        });
    }
};
