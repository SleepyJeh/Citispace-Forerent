<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 80 Units
        Unit::factory()
            ->count(80)
            ->create()
            ->each(function ($unit) {
                // Beds are automatically created by UnitFactory's afterCreating()
                // Optional: you could customize bed generation here if needed
            });
    }
}
