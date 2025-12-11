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
        Schema::table('yarn_materials', function (Blueprint $table) {
            $table->string('pattern')->nullable()->after('name');
        });

        Schema::table('production_report_details', function (Blueprint $table) {
            $table->time('jam')->nullable()->after('shift_name');
            $table->string('posisi_benang_putus')->nullable()->after('meter_count'); // Bar I, II, III, IV
            $table->string('kode_masalah')->nullable()->after('posisi_benang_putus');
            $table->string('no_pcs')->nullable()->after('kode_masalah');
            $table->string('grade')->nullable()->after('no_pcs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('yarn_materials', function (Blueprint $table) {
            $table->dropColumn(['pattern']);
        });

        Schema::table('production_report_details', function (Blueprint $table) {
            $table->dropColumn(['jam', 'posisi_benang_putus', 'kode_masalah', 'no_pcs', 'grade']);
        });
    }
};
