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
            ->count(3)
            ->create(['owner_id' => 3])
            ->each(function ($property) {
                // Each property has 1–10 floors
                $floors = rand(1, 5);

                for ($floor = 1; $floor <= $floors; $floor++) {
                    // Each floor has at least 5 units (can randomize upper limit)
                    $unitsPerFloor = rand(5, 8);

                    Unit::factory()
                        ->count($unitsPerFloor)
                        ->create([
                            'property_id' => $property->property_id,
                            'floor_number' => $floor, // assuming you have this column
                        ]);
                }
            });

    }
}
