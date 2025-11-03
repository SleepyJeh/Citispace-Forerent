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
        Schema::create('properties', function (Blueprint $table) {
            $table->id('property_id')->primary();
            $table->foreignId('manager_id')
                ->nullable() // <-- Make sure to allow null
                ->constrained('users', 'user_id')
                ->onDelete('set null');
            $table->string('building_name', 255);
            $table->string('address', 255);
            $table->text('prop_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
