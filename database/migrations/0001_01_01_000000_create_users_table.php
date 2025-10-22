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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id')->primary();
            $table->string('email',255)->unique();
            $table->enum('role',['tenant', 'manager', 'landlord'])->default('tenant');
            $table->string('contact',255)->unique();
            $table->string('first_name',255)->nullable();
            $table->string('last_name',255)->nullable();
            $table->string('profile_img',255)->nullable();
            $table->string('password',255);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
