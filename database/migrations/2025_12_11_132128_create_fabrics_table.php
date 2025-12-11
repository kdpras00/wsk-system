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
        Schema::create('fabrics', function (Blueprint $table) {
            $table->id();
            $table->string('pattern');
            $table->decimal('meter', 8, 2)->default(0);
            $table->time('jam')->nullable();
            $table->string('no_pcs')->nullable(); // No PCS per potong
            $table->decimal('stok_kg', 8, 2)->default(0); // Stok (Kg)
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fabrics');
    }
};
