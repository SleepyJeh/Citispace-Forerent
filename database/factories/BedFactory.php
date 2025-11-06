<?php

namespace Database\Factories;

use App\Models\Bed;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class BedFactory extends Factory
{
    protected $model = Bed::class;

    public function definition(): array
    {
        return [
            'unit_id' => $this->getUnitId(),
            'bed_number' => $this->faker->numberBetween(1, 8), // realistic bed numbers
            'status' => $this->faker->randomElement(['Vacant', 'Occupied']), // matches enum
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function getUnitId(): int
    {
        $unit = Unit::inRandomOrder()->first();

        if (!$unit) {
            $unit = Unit::factory()->create();
        }

        return $unit->unit_id;
    }
}
