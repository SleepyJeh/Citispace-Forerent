<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\Bed;
use Illuminate\Database\Seeder;

class BedSeeder extends Seeder
{
    public function run(): void
    {
        Unit::all()->each(function ($unit) {
            $cap = $unit->unit_cap ?? 4;

            for ($i = 1; $i <= $cap; $i++) {
                Bed::factory()->create([
                    'unit_id' => $unit->unit_id,
                    'bed_number' => $i,
                ]);
            }
        });
    }
}
