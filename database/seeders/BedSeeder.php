<?php

namespace Database\Seeders;

use App\Models\Bed;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class BedSeeder extends Seeder
{
    public function run(): void
    {
        // Loop through all units and create beds based on unit_cap
        Unit::all()->each(function ($unit) {
            $bedCount = $unit->unit_cap ?? 4;

            // Use factory to create beds
            Bed::factory()
                ->count($bedCount)
                ->create([
                    'unit_id' => $unit->unit_id,
                ]);
        });
    }
}
