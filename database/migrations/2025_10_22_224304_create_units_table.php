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
        // Create Units Table
        Schema::create('units', function (Blueprint $table) {
            $table->id('unit_id')->primary();
            $table->foreignId('property_id')
                ->constrained('properties', 'property_id')
                ->onDelete('cascade'); // <-- OnDelete delete all units related to Property ID
            $table->integer('floor_number');
            $table->enum('occupants', ['Male', 'Female', 'Co-ed'])->default('Co-ed');
            $table->enum('bed_type', ['Single', 'Bunk', 'Twin']);
            $table->enum('room_type', ['Standard', 'Deluxe', 'Suite']);
            $table->integer('room_cap');
            $table->integer('unit_cap');
            $table->decimal('price', 8, 2);
            $table->string('amenities', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
