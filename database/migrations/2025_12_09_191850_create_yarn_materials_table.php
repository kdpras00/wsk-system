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
        Schema::create('yarn_materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color');
            $table->string('type'); // e.g. Cotton, Polyester
            $table->string('batch_number')->nullable();
            $table->decimal('stock_quantity', 10, 2);
            $table->string('unit')->default('kg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yarn_materials');
    }
};
