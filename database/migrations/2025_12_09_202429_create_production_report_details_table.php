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
        Schema::create('production_report_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_report_id')->constrained('production_reports')->onDelete('cascade');
            $table->string('shift_name'); // e.g. "Shift I", "Shift II"
            $table->double('counter_start')->default(0);
            $table->double('counter_end')->default(0);
            $table->integer('pcs_count')->default(0);
            $table->double('kg_count')->nullable(); // Optional based on log
            $table->double('meter_count')->nullable(); // Optional based on log
            $table->string('operator_name')->nullable(); // If different from main user
            $table->text('comment')->nullable(); // Keterangan / Kode Masalah
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_report_details');
    }
};
