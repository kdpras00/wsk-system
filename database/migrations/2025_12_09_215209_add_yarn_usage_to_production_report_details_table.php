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
        Schema::table('production_report_details', function (Blueprint $table) {
            $table->foreignId('yarn_material_id')->nullable()->constrained('yarn_materials')->onDelete('set null');
            $table->decimal('usage_qty', 8, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('production_report_details', function (Blueprint $table) {
            $table->dropForeign(['yarn_material_id']);
            $table->dropColumn(['yarn_material_id', 'usage_qty']);
        });
    }
};
