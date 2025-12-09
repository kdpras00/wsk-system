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
        Schema::table('production_reports', function (Blueprint $table) {
            $table->string('status')->default('Pending')->after('notes'); // Pending, Approved, Rejected
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->after('status');
            $table->text('rejection_note')->nullable()->after('approved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('production_reports', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['status', 'approved_by', 'rejection_note']);
        });
    }
};
