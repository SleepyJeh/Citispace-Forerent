<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 6 Properties
        Property::factory()
            ->count(6)
            ->create()
            ->each(function ($property) {
                // Create 2-5 Units per Property
                Unit::factory()
                    ->count(rand(5, 20))
                    ->for($property) // automatically sets property_id
                    ->create();
                // Beds are automatically generated via UnitFactory's afterCreating()
            });
    }
}
