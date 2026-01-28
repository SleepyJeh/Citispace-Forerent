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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id('receipt_id')->primary();
            $table->string('reference_no')->unique();
            $table->foreignId('billing_id')->constrained('billings', 'billing_id')->onDelete('cascade');
            $table->foreignId('manager_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->enum('purpose', ['Lease', 'Deposit', 'Advance']);
            $table->date('date_issued');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
