<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\Unit;
use App\Models\User;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $properties = Property::all();
        $managers = User::where('role', 'manager')->pluck('user_id')->toArray();

        foreach ($properties as $property) {

            for ($floor = 1; $floor <= 10; $floor++) {

                $floorFormatted = str_pad($floor, 2, '0', STR_PAD_LEFT); // "01", "02", ...

                for ($unit = 1; $unit <= 4; $unit++) {

                    $unitFormatted = str_pad($unit, 2, '0', STR_PAD_LEFT); // "01", "02", "03", "04"

                    $unitNumber = $floorFormatted . $unitFormatted; // e.g., "0101"

                    // 30% chance of having no manager
                    $managerId = (mt_rand(1, 100) <= 30) ? null : ($managers[array_rand($managers)] ?? null);

                    Unit::factory()
                        ->create([
                            'property_id'  => $property->property_id,
                            'manager_id'   => $managerId,
                            'floor_number' => $floor,
                            'unit_number'  => $unitNumber,
                        ]);
                }
            }
        }
    }
}
