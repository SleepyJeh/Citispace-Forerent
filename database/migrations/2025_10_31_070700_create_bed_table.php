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
        Schema::create('beds', function (Blueprint $table) {
            $table->id('bed_id');
            $table->foreignId('unit_id')
                ->constrained('units', 'unit_id')
                ->onDelete('cascade');
            $table->integer('bed_number');
            $table->enum('status', ['Vacant', 'Occupied'])->default('Vacant');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beds');
    }
};
