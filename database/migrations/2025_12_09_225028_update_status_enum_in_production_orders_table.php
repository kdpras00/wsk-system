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
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE production_orders MODIFY COLUMN status ENUM('Planned', 'In Progress', 'Pending Check', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Planned'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE production_orders MODIFY COLUMN status ENUM('Planned', 'In Progress', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Planned'");
    }
};
